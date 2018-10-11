FROM mediawiki:1.31

COPY conf /conf

COPY dokku-entrypoint.sh /dokku-entrypoint.sh
COPY entrypoint.sh /entrypoint.sh
COPY extensions /custom-extensions
COPY extensions/Moderation /var/www/html/extensions/Moderation

EXPOSE 80 443
ENTRYPOINT ["/dokku-entrypoint.sh"]
CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
