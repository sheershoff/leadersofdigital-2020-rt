FROM bscheshir/php:7.3.11-fpm-4yii2-xdebug
# The commented out strings resolved old debian repos issue, left here just in case
#RUN echo "deb http://deb.debian.org/debian/ jessie main" > /etc/apt/sources.list && \
#    echo "deb-src http://deb.debian.org/debian/ jessie main" >> /etc/apt/sources.list && \
#    echo "deb http://security.debian.org/ jessie/updates main" >> /etc/apt/sources.list && \
#    echo "deb-src http://security.debian.org/ jessie/updates main" >> /etc/apt/sources.list && \
#    echo "deb [check-valid-until=no] http://archive.debian.org/debian jessie-backports main" >> /etc/apt/sources.list && \
#    echo "deb-src [check-valid-until=no] http://archive.debian.org/debian jessie-backports main" >> /etc/apt/sources.list && \
#    rm -rf /var/lib/apt/lists/* && \
#    apt-get update && \

ENV current_os=linux

#   First string here installs nodejs but also does the apt-get update inside. At least it does it now.
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    apt-get install -y nodejs unzip libssh2-1-dev procps time libxml-filter-sort-perl libxml2-utils && \
    npm i -g coffeescript@1.12.7 && \
# blackfire start
    version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/$current_os/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz \
    && mkdir -p /tmp/blackfire \
    && curl -A "Docker" -L https://blackfire.io/api/v1/releases/client/linux_static/amd64 | tar zxp -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire /usr/bin/blackfire \
    && rm -Rf /tmp/blackfire
# blackfire end
# no need for postgres
RUN mv /usr/local/etc/php/conf.d/docker-php-ext-pgsql.ini /usr/local/etc/php/conf.d/docker-php-ext-pgsql.ini.bak && \
    mv /usr/local/etc/php/conf.d/docker-php-ext-pdo_pgsql.ini /usr/local/etc/php/conf.d/docker-php-ext-pdo_pgsql.ini.bak
RUN docker-php-ext-install calendar && \
    docker-php-ext-enable calendar
RUN cd /tmp \
    && git clone https://git.php.net/repository/pecl/networking/ssh2.git \
    && cd /tmp/ssh2/ \
    && .travis/build.sh \
    && docker-php-ext-enable ssh2 \
# Upgrade xDebug
#ENV XDEBUG_VERSION 2.8.0
#RUN pecl install xdebug-$XDEBUG_VERSION && \
#    docker-php-ext-enable xdebug && \
#    rm -r /tmp/pear/* && \
#    echo -e "xdebug.remote_port = 9001\n\
#xdebug.idekey = \"PHPSTORM\"\n\
#xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# End Upgrade xDebug
    && rm -rf /var/lib/apt/lists/*
RUN composer self-update 1.9.0 && \
    composer global require "fxp/composer-asset-plugin:^1.2.0"

RUN composer config -g github-oauth.github.com b61fcff24e8e33de55584a313db4ccd73445f7ef
