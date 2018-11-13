To deploy the official mediawiki onto dokku and setup with https we need to do the following:

1. instructions modified from https://github.com/kingsquare/mediawiki-dokku  

(assumes you are logged into the box dokku is running on)
(this run through via dokku 0.12.7)

```
# create an app
dokku apps:create mediawiki

# set the environment (only required for non-dev envs)
dokku config:set mediawiki environment=production

## Add Persistent storage (for uploads)

# create storage for the app
sudo mkdir -p  /var/lib/dokku/data/storage/mediawiki

# ensure the dokku user has access to this directory
sudo chown -R www-data:www-data /var/lib/dokku/data/storage/mediawiki

# mount the directory into your app
dokku storage:mount mediawiki /var/lib/dokku/data/storage/mediawiki:/storage

## Add database
# Create a mariadb service with environment variables
dokku mariadb:create mediawiki

# Link the mariadb service to the app
dokku mariadb:link mediawiki mediawiki
```

2. set admin variables

(assumes you are logged into the box dokku is running on)

```
dokku config:set mediawiki MEDIAWIKI_ADMIN_USER=XXXXX MEDIAWIKI_ADMIN_PASS=XXXXX
```

**NOTE: The below is now specific to HLPWiki deploy - we're working on another Dockerfile for a vanilla installation**

3. Git based deploy

i) set remote on clone of AgileVentures/SocialPrescribingWiki

```
git remote add azure-develop dokku@nhs-dokku.eastus.cloudapp.azure.com:mediawiki
```

ii) push up dockerfile via git

```
git push azure-develop master
```


4. Set up domains

```
ssh dokku@nhs-dokku.eastus.cloudapp.azure.com domains:add mediawiki_official develop-official.hlpwiki.agileventures.org 
```
**Potential sticking points:**

**Admin Access**

Although, we have access to MEDIAWIKI_ADMIN_USER and MEDIAWIKI_ADMIN_PASS in our `entrypoint.sh` and `dokku-entrypoint.sh`, we cannot use them to log into the site.

We believe we have access to them because we have echoed them and found them in the box's logs.

Attempts to change the password using the changePassword.php have been unsuccessful. It's ownership looks like this `-rw-r--r--  1      501 staff     2492 Jun 13 17:19 changePassword.php`

The documentation here, https://www.mediawiki.org/wiki/Manual:ChangePassword.php, does not list anything in the troubleshooting section about what the permissions should be.

**Loading extensions**

An attempt has been made to add extensions `Moderation` and `ShoggleTweet` and neither were successful. 

The approach used was to use `git clone` locally and then `COPY extensions /extensions` in the **Dockerfile**; however, in both cases this has lead to a blank screen when visiting the site with no error messaging in the logs. It say MediaWiki has successfully been installed.

 



