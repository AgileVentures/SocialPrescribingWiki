FROM mediawiki:1.31

RUN apt-get update -qq && apt-get install -y software-properties-common apt-transport-https gnupg
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get update -qq && apt-add-repository "deb https://releases.wikimedia.org/debian jessie-mediawiki main"
RUN apt-get update -qq && apt-get install -y nodejs parsoid --allow-unauthenticated

COPY parsoid /etc/mediawiki/parsoid

COPY conf /conf

COPY dokku-entrypoint.sh /dokku-entrypoint.sh
COPY entrypoint.sh /entrypoint.sh
COPY extensions /var/www/html/extensions

EXPOSE 80 443 8142
ENTRYPOINT ["/dokku-entrypoint.sh"]
# CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
