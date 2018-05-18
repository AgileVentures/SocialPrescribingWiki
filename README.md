# SocialPrescribingWiki
for the NHS HLP Social Prescribing and Self Care Wiki

To get the app up on a dokku system 
-----------------------------------

Useful commands:

Get a list of apps:
```
$ ssh dokku@nhs-dokku.eastus.cloudapp.azure.com apps:list
```

Get a list of domains:

```
$ ssh dokku@nhs-dokku.eastus.cloudapp.azure.com domains:report
```

Connect local repo to the place to deploy:
```
$ git remote add azure-develop dokku@nhs-dokku.eastus.cloudapp.azure.com:hlpwiki-develop
```

Setting up MySQL
----------------

1. Follow instructions at https://github.com/dokku/dokku-mysql#installation (requires admin access to remote)
2. ```dokku mysql:create mediawiki```
3. ```dokku mysql:link mediawiki hlpwiki-develop```
... may need to follow: https://github.com/kingsquare/mediawiki-dokku
