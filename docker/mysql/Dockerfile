FROM mysql:8.0-debian

RUN apt-get update && apt-get install -y \
    wget \
    git \
    openssh-server \
    tar \
    gcc \
    make \
    zip \
    unzip \
    vim \
    iputils-ping \
    net-tools

#mysql config
ADD ./my.cnf /etc/mysql/my.cnf
#mysql8では以下のディレクトリがないと起動エラー
RUN mkdir /etc/mysql/mysql.conf.d
RUN mkdir /var/lib/mysql-files

ENV MYSQL_ALLOW_EMPTY_PASSWORD=no
ENV MYSQL_ROOT_PASSWORD="password"

#mysql script
#COPY ./create_database.sql /docker-entrypoint-initdb.d/create_database.sql

#local environment
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
ENV LANG ja_JP.UTF-8


WORKDIR /etc/mysql
