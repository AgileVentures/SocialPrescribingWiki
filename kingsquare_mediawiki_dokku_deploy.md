To deploy the kingsquare mediawiki onto dokku and setup with https we need to do the following:

1. instructions from https://github.com/kingsquare/mediawiki-dokku  

(assumes you are logged into the box dokku is running on)
(this run through via dokku 0.12.7)

```
# create an app
dokku apps:create mediawiki

# set the environment (only required for non-dev envs)
dokku config:set mediawiki environment=production

## Add Persistent storage (for uploads)

# create storage for the app
sudo mkdir -p  /host/location/mediawiki

# ensure the dokku user has access to this directory
sudo chown -R dokku:dokku /host/location/mediawiki

# mount the directory into your app
dokku storage:mount mediawiki /host/location/mediawiki:/data

## Add database
# Create a mariadb service with environment variables
dokku mariadb:create mediawiki

# Link the mariadb service to the app
dokku mariadb:link mediawiki mediawiki
```

2. set admin variables

(assumes you are logged into the box dokku is running on)

```
dokku config:set mediawiki MEDIAWIKI_ADMIN_USER=XXXXX
dokku config:set mediawiki MEDIAWIKI_ADMIN_USER=XXXXX
```

3. Git based deploy

i) set remote on clone of kingsquare/mediawiki-dokku

```
git remote add azure_develop dokku@nhs-dokku.eastus.cloudapp.azure.com:mediawiki
```

ii) push up dockerfile via git

```
git push azure_develop master
```

4. set up a domain to run on:

(assumes that this domain is pointed at the dokku instance - requires azure portal work for us)

```
dokku domains:add mediawiki develop.hlpwiki.agileventures.org
```

5. Get https set up - following instructions from https://github.com/dokku/dokku-letsencrypt

(assumes you are logged into the box dokku is running on)

```
dokku config:set --no-restart mediawiki DOKKU_LETSENCRYPT_EMAIL=sam@agileventures.org
dokku network:set mediawiki bind-all-interfaces true
dokku letsencrypt mediawiki
```
6. ? adjust ports (not sure if needed?)

```
dokku proxy:ports-clear mediawiki
dokku proxy:ports-remove mediawiki http:443:443
dokku ps:restart mediawiki
```

7. ? wait a couple of hours and then refresh (not sure if needed?)

```
dokku letsencrypt:cleanup mediawiki
dokku letsencrypt:auto-renew mediawiki
dokku letsencrypt mediawiki
```

8. set up cron job to ensure autorenewal?

Notes
-----

these config vars on working instance that are not there by default ...

```
DOKKU_APP_PROXY_TYPE:         nginx-vhosts
DOKKU_LETSENCRYPT_EMAIL:      sam@agileventures.org
DOKKU_NGINX_SSL_PORT:         443
DOKKU_PROXY_PORT_MAP:         http:80:80
DOKKU_PROXY_SSL_PORT:         443
```


