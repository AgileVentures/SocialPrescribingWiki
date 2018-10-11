#!/bin/bash

$(php -- <<'EOPHP'
<?php

$SHOGGLE_TWEET_CONSUMER_KEY = getenv('SHOGGLE_TWEET_CONSUMER_KEY');
$SHOGGLE_TWEET_CONSUMER_KEY_SECRET = getenv('SHOGGLE_TWEET_CONSUMER_KEY_SECRET');

$MEDIAWIKI_ADMIN_USER = getenv('MEDIAWIKI_ADMIN_USER');
$MEDIAWIKI_ADMIN_PASS = getenv('MEDIAWIKI_ADMIN_PASS');

$DATABASE_URL = parse_url(trim(getenv('DATABASE_URL')));
if (empty($DATABASE_URL['scheme'])) {
    echo 'echo "DATABASE_URL is not set.. have you linked the database?" && exit -1';
    exit;
}

echo 'export ' . implode(' ', [
    'MEDIAWIKI_DB_TYPE=' . $DATABASE_URL['scheme'],
    'MEDIAWIKI_DB_HOST=' . $DATABASE_URL['host'],
    'MEDIAWIKI_DB_PORT=' . $DATABASE_URL['port'],
    'MEDIAWIKI_DB_USER=' . $DATABASE_URL['user'],
    'MEDIAWIKI_DB_PASSWORD=' . $DATABASE_URL['pass'],
    'MEDIAWIKI_DB_NAME=' . trim($DATABASE_URL['path'], '/'),
    'MEDIAWIKI_UPDATE=true',
    'MEDIAWIKI_SITE_SERVER=https://develop-official.hlpwiki.agileventures.org',
    'MEDIAWIKI_RESTBASE_URL=',
    'SHOGGLE_TWEET_CONSUMER_KEY=' . $SHOGGLE_TWEET_CONSUMER_KEY,
    'SHOGGLE_TWEET_CONSUMER_KEY_SECRET=' . $SHOGGLE_TWEET_CONSUMER_KEY_SECRET
    'MEDIAWIKI_ADMIN_USER=' . $MEDIAWIKI_ADMIN_USER,
    'MEDIAWIKI_ADMIN_PASS=' . $MEDIAWIKI_ADMIN_PASS
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
echo "SHOGGLE_TWEET_CONSUMER_KEY: '$SHOGGLE_TWEET_CONSUMER_KEY'";
echo "SHOGGLE_TWEET_CONSUMER_KEY_SECRET: '$SHOGGLE_TWEET_CONSUMER_KEY_SECRET'";
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
