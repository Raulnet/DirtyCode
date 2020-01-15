FROM php:7.4.1-fpm

ENTRYPOINT ["entrypoint"]

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /home/.composer
ENV APCU_VERSION 5.1.17
ENV GOSU_VERSION 1.10

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        wget \
        libreadline-dev \
        git \
        libicu-dev \
        openssh-client \
        sqlite3 \
        unzip \
        libonig-dev \
        libzip-dev \
        zlib1g-dev && \
    docker-php-ext-install \
        mbstring \
        intl \
        zip \
        opcache && \
    pecl install \
        apcu-${APCU_VERSION} && \
    docker-php-ext-enable \
        apcu

# Copy file LUA for install extension LUA interpreter
COPY ./lua/config.m4 /tmp/lua/config.m4
COPY ./lua/config_x64.path /tmp/lua/config_x64.path
COPY ./lua/install.sh /tmp/lua/install.sh

RUN /tmp/lua/install.sh

RUN  apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
        curl -L -s -o /bin/gosu https://github.com/tianon/gosu/releases/download/${GOSU_VERSION}/gosu-$(dpkg --print-architecture | awk -F- '{ print $NF }') && \
        chmod +x /bin/gosu && \
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php --install-dir=/usr/local/bin --filename=composer && rm composer-setup.php && \
        chmod +x /usr/local/bin/composer && \
        addgroup bar && \
        adduser --home=/home --shell=/bin/bash --ingroup=bar --disabled-password --quiet foo && \
        composer global require symfony/flex && chown -R foo:bar /home/.composer

ENTRYPOINT ["entrypoint"]