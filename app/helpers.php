<?php

declare(strict_types=1);

function ddh(mixed ...$args): void
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: *');
    header('Access-Control-Allow-Headers: *');
    dd(...$args);
}

function ddr(mixed ...$args): void
{
    var_dump(...$args);

    exit;
}
