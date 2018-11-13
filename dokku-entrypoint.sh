#!/bin/bash

$(php -- <<'EOPHP'
<?php

$DATABASE_URL = parse_url(trim(getenv('DATABASE_URL')));
if (empty($DATABASE_URL['scheme'])) {
    echo 'echo "DATABASE_URL is not set.. have you linked the database?" && exit -1';
    exit;
}

$MEDIAWIKI_SITE_SERVER = getenv('MEDIAWIKI_SITE_SERVER'); 

echo 'export ' . implode(' ', [
    'MEDIAWIKI_DB_TYPE=' . $DATABASE_URL['scheme'],
    'MEDIAWIKI_DB_HOST=' . $DATABASE_URL['host'],
    'MEDIAWIKI_DB_PORT=' . $DATABASE_URL['port'],
    'MEDIAWIKI_DB_USER=' . $DATABASE_URL['user'],
    'MEDIAWIKI_DB_PASSWORD=' . $DATABASE_URL['pass'],
    'MEDIAWIKI_DB_NAME=' . trim($DATABASE_URL['path'], '/'),
    'MEDIAWIKI_SITE_SERVER=' . $MEDIAWIKI_SITE_SERVER,
    'MEDIAWIKI_UPDATE=true',
    'MEDIAWIKI_RESTBASE_URL=',
]);

EOPHP
)

# todo linked redis vars?

# todo linked memcached vars?

# custom image entrypoint
echo "Trying custom entrypoint script..."
if [ -f /app/dokku-entrypoint.sh -a -x /app/dokku-entrypoint.sh ]; then
    echo "Executing custom entrypoint script..."
    /app/dokku-entrypoint.sh
fi

# main image entrypoint
echo "Executing main entrypoint script..."
echo "MEDIAWIKI_DB_TYPE: $MEDIAWIKI_DB_TYPE"
echo "MEDIAWIKI_DB_HOST: $MEDIAWIKI_DB_HOST"
echo "MEDIAWIKI_DB_PORT: $MEDIAWIKI_DB_PORT"
echo "MEDIAWIKI_DB_USER: $MEDIAWIKI_DB_USER"
echo "MEDIAWIKI_DB_PORT: $MEDIAWIKI_DB_PORT"
echo "MEDIAWIKI_DB_NAME: $MEDIAWIKI_DB_NAME"
echo "MEDIAWIKI_UPDATE: $MEDIAWIKI_UPDATE"
echo "MEDIAWIKI_SITE_SERVER: $MEDIAWIKI_SITE_SERVER"
echo "$@"
/entrypoint.sh $@
