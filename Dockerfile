FROM mediawiki:1.31

RUN apt-get update -qq && apt-get install -y wget zip

COPY conf /conf

COPY dokku-entrypoint.sh entrypoint.sh \ 
     composer-install.sh composer.local.json \ 
     install-update-php-dependencies.sh /
COPY extensions /var/www/html/extensions
COPY VectorTemplate.php /var/www/html/skins/Vector/includes/VectorTemplate.php
COPY nginx.conf.sigil /var/www/html

RUN mv /var/www/html/images /var/www/html/images-old
RUN ln -s /storage/images /var/www/html/images

EXPOSE 80 443
ENTRYPOINT ["/dokku-entrypoint.sh"]
CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
