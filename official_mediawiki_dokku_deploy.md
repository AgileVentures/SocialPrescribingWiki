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
dokku config:set mediawiki MEDIAWIKI_ADMIN_PASS=XXXXX
```

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
