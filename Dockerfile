FROM mediawiki:1.31

RUN apt-get update -qq && apt-get install -y software-properties-common apt-transport-https gnupg
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get update -qq && apt-add-repository "deb https://releases.wikimedia.org/debian jessie-mediawiki main"
RUN apt-get update -qq && apt-get install -y nodejs parsoid --allow-unauthenticated

COPY parsoid /etc/mediawiki/parsoid
RUN apt-get update -qq && apt-get install -y wget zip

COPY conf /conf

COPY dokku-entrypoint.sh entrypoint.sh \ 
     composer-install.sh composer.local.json \ 
     install-update-php-dependencies.sh /
COPY extensions /var/www/html/extensions
COPY VectorTemplate.php /var/www/html/skins/Vector/includes/VectorTemplate.php
COPY apache-virtual-host.conf /etc/apache2/sites-enabled/000-default.conf

EXPOSE 80 443
ENTRYPOINT ["/dokku-entrypoint.sh"]
# CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
