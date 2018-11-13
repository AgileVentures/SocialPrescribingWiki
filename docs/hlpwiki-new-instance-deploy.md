To deploy the an hlp instance on to dokku and setup with https we need to do the following:

1. create app and associated filesystem/db

(assumes you are logged into the box dokku is running on)
(this run through via dokku 0.12.7)

```
# create an app
dokku apps:create hlpwiki

# set the environment (only required for non-dev envs)
dokku config:set hlpwiki environment=production

## Add Persistent storage (for uploads)

# create storage for the app
sudo mkdir -p  /var/lib/dokku/data/storage/hlpwiki

# ensure the dokku user has access to this directory
sudo chown -R www-data:www-data /var/lib/dokku/data/storage/hlpwiki

# mount the directory into your app
dokku storage:mount hlpwiki /var/lib/dokku/data/storage/hlpwiki:/storage

## Add database
# Create a mariadb service with environment variables
dokku mariadb:create hlpwiki

# Link the mariadb service to the app
dokku mariadb:link hlpwiki hlpwiki
```

2. set admin variables

(assumes you are logged into the box dokku is running on)

```
dokku config:set hlpwiki MEDIAWIKI_ADMIN_USER=XXXXX MEDIAWIKI_ADMIN_PASS=XXXXX
dokku config:set hlpwiki MEDIAWIKI_SITE_SERVER=https://test.hlpwiki.agileventures.org
```

3. Git based deploy

i) set remote on clone of AgileVentures/SocialPrescribingWiki

```
git remote add hlpwiki-production dokku@nhs-dokku.eastus.cloudapp.azure.com:hlpwiki-production
```

ii) push up dockerfile via git

```
git push azure-develop master
```

4. Set up domains

```
dokku  domains:add hlpwiki test.hlpwiki.agileventures.org 
```

Azure will need adjusting too, e.g.

![](https://dl.dropbox.com/s/oieozci4jnturm3/Screenshot%202018-11-13%2013.54.34.png?dl=0)

5. Enabling https

```
dokku config:set --no-restart hlpwiki DOKKU_LETSENCRYPT_EMAIL=hlpwikiadmin@agileventures.org
dokku letsencrypt hlpwiki
dokku letsencrypt:auto-renew hlpwiki
```

6. Over environment variables

```
dokku config:set hlpwiki-production SHOOGLE_TWEET_CONSUMER_KEY=<CONSUMER_KEY> SHOOGLE_TWEET_CONSUMER_KEY_SECRET=<SECRET_KEY>
dokku config:set hlpwiki-production RECAPTCHA_SECRET_KEY=<SECRET_KEY> RECAPTCHA_SITE_KEY=<SITE_KEY>
```

6. Transfering data in

see [transfering_data_between_servers.md](transfering_data_between_servers.md)



 



