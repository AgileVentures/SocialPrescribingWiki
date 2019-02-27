#!/bin/bash
set -x

/composer-install.sh
/install-update-php-dependencies.sh

sed -i "/MEDIAWIKI_SITE_SERVER/c\        uri: '$MEDIAWIKI_SITE_SERVER/api.php'" /etc/mediawiki/parsoid/config.yaml

# If there is no LocalSettings.php, create one using maintenance/install.php
if [ ! -e "LocalSettings.php" -a ! -z "$MEDIAWIKI_SITE_SERVER" ]; then
	php maintenance/install.php \
		--confpath /var/www/html \
		--dbname "$MEDIAWIKI_DB_NAME" \
		--dbschema "$MEDIAWIKI_DB_SCHEMA" \
		--dbport "$MEDIAWIKI_DB_PORT" \
		--dbserver "$MEDIAWIKI_DB_HOST" \
		--dbtype "$MEDIAWIKI_DB_TYPE" \
		--dbuser "$MEDIAWIKI_DB_USER" \
		--dbpass "$MEDIAWIKI_DB_PASSWORD" \
		--installdbuser "$MEDIAWIKI_DB_USER" \
		--installdbpass "$MEDIAWIKI_DB_PASSWORD" \
		--server "$MEDIAWIKI_SITE_SERVER" \
		--scriptpath "" \
		--lang "$MEDIAWIKI_SITE_LANG" \
		--pass "$MEDIAWIKI_ADMIN_PASS" \
		"$MEDIAWIKI_SITE_NAME" \
		"$MEDIAWIKI_ADMIN_USER"

        # Append inclusion of /compose_conf/CustomSettings.php
        echo "@include('/conf/CustomSettings.php');" >> LocalSettings.php
fi


if [ -e "LocalSettings.php" -a $MEDIAWIKI_UPDATE = true ]; then
	echo >&2 'info: Running maintenance/update.php';
	php maintenance/update.php --quick --conf ./LocalSettings.php
fi

a2enmod rewrite
sed -i '12 a RewriteEngine On' /etc/apache2/sites-available/000-default.conf
sed -i '13 a RewriteRule ^/(.*):(.*) /index.php/$1:$2' /etc/apache2/sites-available/000-default.conf
sed -i "/case 'jpg':/c\          case 'jpg': case 'jpeg': case 'png': case 'gif': case 'bmp': case 'tif': case 'tiff': case 'pdf':" extensions/MsUpload/MsUpload.js
service parsoid start

exec "$@"