FROM mediawiki:1.31

# below is copied from https://github.com/kingsquare/mediawiki-docker/blob/master/Dockerfile

# COPY php.ini /usr/local/etc/php/conf.d/mediawiki.ini

# COPY apache/mediawiki.conf /etc/apache2/
# RUN echo "Include /etc/apache2/mediawiki.conf" >> /etc/apache2/apache2.conf

COPY entrypoint.sh /entrypoint.sh

EXPOSE 80 443
ENTRYPOINT ["/entrypoint.sh"]
CMD ["apachectl", "-e", "info", "-D", "FOREGROUND"]
