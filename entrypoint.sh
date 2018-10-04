# If there is no LocalSettings.php, create one using maintenance/install.php
echo "MEDIAWIKI_DB_NAME: $MEDIAWIKI_DB_NAME"
echo "MEDIAWIKI_DB_SCHEMA: $MEDIAWIKI_DB_SCHEMA"
echo "MEDIAWIKI_DB_PORT: $MEDIAWIKI_DB_PORT"
echo "MEDIAWIKI_DB_HOST: $MEDIAWIKI_DB_HOST"
echo "MEDIAWIKI_DB_TYPE: $MEDIAWIKI_DB_TYPE"
echo "MEDIAWIKI_DB_USER: $MEDIAWIKI_DB_USER"
echo "MEDIAWIKI_DB_PASSWORD: $MEDIAWIKI_DB_PASSWORD"
echo "MEDIAWIKI_SITE_SERVER: $MEDIAWIKI_SITE_SERVER"
echo "MEDIAWIKI_SITE_LANG: $MEDIAWIKI_SITE_LANG"
echo "MEDIAWIKI_SITE_NAME: $MEDIAWIKI_SITE_NAME"

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

exec "$@"