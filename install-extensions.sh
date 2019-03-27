#!/bin/bash

cd extensions && \ 
curl -L https://extdist.wmflabs.org/dist/extensions/Elastica-REL1_31-7019d96.tar.gz | tar xz && \
cd Elastica && php /var/www/html/composer.phar install --no-dev