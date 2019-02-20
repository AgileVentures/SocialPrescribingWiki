#!/bin/sh

cd /var/www/html/extensions && \
curl -L https://extdist.wmflabs.org/dist/extensions/CookieWarning-REL1_32-214f5cb.tar.gz | tar xz && \
curl -L https://extdist.wmflabs.org/dist/extensions/MsUpload-REL1_32-0779791.tar.gz | tar xz && \
git clone https://github.com/schinken/mediawiki-shoogletweet && cd mediawiki-shoogletweet/ && git submodule init && git submodule update && \
cd ../ && git clone https://github.com/edwardspec/mediawiki-moderation.git && mkdir Moderation && mv mediawiki-moderation/* Moderation/ && rm -rf mediawiki-moderation