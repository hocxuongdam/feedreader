FROM php:7.2-fpm

## enable to log error to a file instead of showing up to user
## COPY log.conf /usr/local/etc/php-fpm.d/zz-log.conf

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install bcmath pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN groupadd -g 1000 testuser && \
    useradd -u 1000 -g testuser -m testuser && \
    usermod -p "*" testuser

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini

RUN  curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.8/install.sh | bash \
    && export NVM_DIR="$HOME/.nvm" \
    && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
    && nvm install node && nvm use node \
    && npm cache clean -f && npm install -g n && n stable && npm install -g cross-env