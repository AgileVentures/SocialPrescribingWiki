FROM mediawiki:1.31

RUN apt-get update -qq && apt-get install wget

COPY conf /conf

COPY dokku-entrypoint.sh /dokku-entrypoint.sh
COPY entrypoint.sh /entrypoint.sh
COPY composer-install.sh /composer-install.sh
COPY composer.local.json /composer.local.json
COPY extensions /var/www/html/extensions

EXPOSE 80 443
ENTRYPOINT ["/dokku-entrypoint.sh"]
CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
