FROM mediawiki:1.31

RUN apt-get update -qq && apt-get install -y software-properties-common apt-transport-https gnupg && \
    curl -sL https://deb.nodesource.com/setup_8.x | bash - && \
    apt-get update -qq && apt-add-repository "deb https://releases.wikimedia.org/debian jessie-mediawiki main" && \
    apt-get update -qq && apt-get install -y nodejs parsoid wget zip --allow-unauthenticated && \
    ln -s /storage/images ./images

COPY parsoid /etc/mediawiki/parsoid

COPY conf /conf
COPY dokku-entrypoint.sh entrypoint.sh \ 
     composer-install.sh composer.local.json \ 
     install-update-php-dependencies.sh /
COPY extensions extensions/
COPY VectorTemplate.php skins/Vector/includes/VectorTemplate.php
COPY .htaccess ./

EXPOSE 80 443
ENTRYPOINT ["/dokku-entrypoint.sh"]
CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
