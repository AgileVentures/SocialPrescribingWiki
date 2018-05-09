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
