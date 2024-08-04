<?php

declare(strict_types=1);

namespace App\Shared;

use ArrayAccess;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionEnum;

/**
 * Model風データクラス
 *
 * $casts や アクセサが使える。
 */
abstract class Param implements Arrayable, ArrayAccess
{
    /**
     * コンストラクタで一括代入可能なキー
     *
     * 但しModelと異なり、他のキーがあってもエラーにはならず、無視される
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * @var array<string, string>
     */
    protected $synonyms = [];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [];

    /**
     * @param array<string, mixed>|Arrayable|null $values
     */
    public function __construct(array|Arrayable|null $values = null)
    {
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        } else {
            $values ??= [];
        }

        // キーの読み替え
        foreach ($this->synonyms as $key => $possible_key) {
            if (Arr::has($values, $possible_key)) {
                $values[$key] = Arr::get($values, $possible_key);
            }
        }

        // 不要なキーの除去、足りないキーの補完
        foreach ($this->fillable as $key) {
            $this->attributes[$key] = $values[$key] ?? null;
        }

        $this->attributes = array_combine(
            $this->fillable,
            array_map($this->castAttribute(...), $this->fillable, $this->attributes),
        );
    }

    public function __get(string $key): mixed
    {
        if (in_array($key, $this->fillable, true)) {
            return $this->attributes[$key];
        }

        // アクセサ
        $method_name = 'get' . Str::studly($key) . 'Attribute';
        if (method_exists($this, $method_name)) {
            return $this->{$method_name}();
        }

        throw new Exception("property {$key} is undefined");
    }

    public function __set(string $key, mixed $value): void
    {
        if (in_array($key, $this->fillable, true)) {
            $this->attributes[$key] = $this->castAttribute($key, $value);
        }
    }

    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * キャスト
     */
    private function castAttribute(string $key, mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        // キャスト指定なし
        if (!array_key_exists($key, $this->casts)) {
            return $value;
        }

        // 配列 (integer[], string[]) の場合
        if (substr($this->casts[$key], -2) === '[]') {
            if (!is_array($value)) {
                throw new Exception('cast failed');
            }

            $type = substr($this->casts[$key], 0, -2);

            return array_map(fn ($row) => $this->cast($row, $type), $value);
        }

        // Collection<ClassName> の場合
        if (stripos($this->casts[$key], 'Collection<') === 0 && substr($this->casts[$key], -1) === '>') {
            if (!is_array($value)) {
                throw new Exception('cast failed');
            }

            $type = substr($this->casts[$key], 11, -1);

            return collect($value)->map(fn ($row) => $this->cast($row, $type));
        }

        return $this->cast($value, $this->casts[$key]);
    }

    /**
     * キャスト
     */
    private function cast(mixed $value, string $castType): mixed
    {
        if ($value === null) {
            return null;
        }

        if (enum_exists($castType)) {
            $enum = new ReflectionEnum($castType);
            $type = (string)$enum->getBackingType();

            if ($type === 'int') {
                $cast_value = (int)$value;
            } elseif ($value === 'string') {
                $cast_value = (string)$value;
            } else {
                return null;
            }

            return $castType::tryFrom($cast_value);
        }

        if (class_exists($castType)) {
            return new $castType($value);
        }

        // HasAttributes の castAttribute() を参考にしてます
        switch ($castType) {
            case 'int':
            case 'integer':
                return (int)$value;

            case 'real':
            case 'float':
            case 'double':
                return (float)$value;

            case 'string':
                return (string)$value;

            case 'bool':
            case 'boolean':
                return (bool)$value;

            case 'date':
            case 'datetime':
                return CarbonImmutable::parse($value);

            case 'safe_html':
                return strip_tags((string)$value, ['h2', 'h3', 'h4', 'p', 'strong', 'ul', 'ol', 'li', 'br']);

            default:
                throw new Exception("castType {$castType} is undefined");
        }
    }

    // ----------------------
    //
    // ArrayAccess への対応
    //
    // ----------------------

    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            throw new Exception('Param にオフセットなしでメンバーを追加すること ($param[] = xxx) はできません');
        }

        if (is_int($offset)) {
            throw new Exception('Param 数値オフセットでメンバーを追加すること ($param[0] = xxx) はできません');
        }

        /** @var string $offset */
        if (in_array($offset, $this->fillable, true)) {
            $this->attributes[$offset] = $this->castAttribute($offset, $value);
        }
    }

    public function offsetExists($offset): bool
    {
        return in_array($offset, $this->fillable, true);
    }

    public function offsetUnset($offset): void
    {
        throw new Exception('Param は unset できません');
    }

    public function offsetGet($offset): mixed
    {
        if (in_array($offset, $this->fillable, true)) {
            return $this->attributes[$offset];
        }

        $method_name = 'get' . Str::studly($offset) . 'Attribute';
        if (method_exists($this, $method_name)) {
            return $this->{$method_name}();
        }

        throw new Exception("property {$offset} is undefined");
    }
}
