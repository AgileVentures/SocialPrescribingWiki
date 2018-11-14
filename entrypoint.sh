#!/bin/bash
set -x


/composer-install.sh
/install-update-php-dependencies.sh

sed -i "/MEDIAWIKI_SITE_SERVER/c\        uri: '$MEDIAWIKI_SITE_SERVER/api.php'" /etc/mediawiki/parsoid/config.yaml
pear install mail
pear install net_smtp

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
				php maintenance/changePassword.php --user=Admin --password=$MEDIAWIKI_ADMIN_PASS --conf ./LocalSettings.php
fi


if [ -e "LocalSettings.php" -a $MEDIAWIKI_UPDATE = true ]; then
	echo >&2 'info: Running maintenance/update.php';
	php maintenance/update.php --quick --conf ./LocalSettings.php
fi

chmod 755 images

service parsoid start
apachectl -e info -D FOREGROUND

exec "$@"