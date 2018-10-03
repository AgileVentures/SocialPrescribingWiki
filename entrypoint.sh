echo "MEDIAWIKI_ADMIN_USER: '$MEDIAWIKI_ADMIN_USER'"
echo "MEDIAWIKI_ADMIN_PASS: '$MEDIAWIKI_ADMIN_PASS'"

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

    #     # Append inclusion of /compose_conf/CustomSettings.php
    #     echo "@include('/conf/CustomSettings.php');" >> LocalSettings.php

		# # If we have a mounted share volume, move the LocalSettings.php to it
		# # so it can be restored if this container needs to be reinitiated
		# if [ -d "$MEDIAWIKI_SHARED" ]; then
		# 	# Move generated LocalSettings.php to share volume
		# 	mv LocalSettings.php "$MEDIAWIKI_SHARED/LocalSettings.php"
		# 	ln -s "$MEDIAWIKI_SHARED/LocalSettings.php" LocalSettings.php
		# fi
fi

exec "$@"