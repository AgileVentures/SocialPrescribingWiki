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

RUN cd /var/www/html/extensions && curl -L https://extdist.wmflabs.org/dist/extensions/CookieWarning-REL1_31-8ab2dfc.tar.gz| tar xz
COPY extensions /var/www/html/extensions

COPY VectorTemplate.php /var/www/html/skins/Vector/includes/VectorTemplate.php
COPY nginx.conf.sigil /var/www/html
COPY .htaccess /var/www/html

RUN mv /var/www/html/images /var/www/html/images-old
RUN ln -s /storage/images /var/www/html/images

EXPOSE 80 443
ENTRYPOINT ["/dokku-entrypoint.sh"]
CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
