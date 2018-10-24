FROM mediawiki:1.31
RUN apt-get update -qq && apt-get install -y build-essential \
    apt-utils apt-transport-https lsb-release gnupg
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get update -qq && apt-get install -y nodejs
RUN npm install -g parsoid
COPY parsoid /var/www/html/mediawiki/parsoid
# RUN echo "parsoid copied modified, start long build process" && sleep 1200 && echo "Long build process finished"

COPY conf /conf

COPY dokku-entrypoint.sh /dokku-entrypoint.sh
COPY entrypoint.sh /entrypoint.sh
COPY extensions /var/www/html/extensions

EXPOSE 80 443 8142
ENTRYPOINT ["/dokku-entrypoint.sh"]
CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
