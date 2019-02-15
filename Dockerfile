FROM mediawiki:1.32

RUN apt-get update -qq && apt-get install -y software-properties-common apt-transport-https gnupg wget zip && \
    curl -sL https://deb.nodesource.com/setup_8.x | bash - && \
    apt-get update -qq && apt-add-repository "deb https://releases.wikimedia.org/debian jessie-mediawiki main" && \
    apt-get update -qq && apt-get install -y ghostscript poppler-utils nodejs parsoid --allow-unauthenticated --no-install-recommends && \
    mv ./images ./images-old && ln -s /storage/images ./ && \
    cd /var/www/html/extensions && \
    git clone -b REL1_32 https://gerrit.wikimedia.org/r/p/mediawiki/extensions/VisualEditor.git && cd VisualEditor && git submodule update --init && \
    rm -rf /var/lib/apt/lists/*

COPY parsoid /etc/mediawiki/parsoid
COPY conf /conf
COPY dokku-entrypoint.sh entrypoint.sh \ 
     composer-install.sh composer.local.json \ 
     install-update-php-dependencies.sh install-extensions.sh /
COPY extensions extensions/
COPY VectorTemplate.php skins/Vector/includes/VectorTemplate.php
COPY nginx.conf.sigil .htaccess ./

EXPOSE 80 443
ENTRYPOINT ["/dokku-entrypoint.sh"]

CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
