# SocialPrescribingWiki
For the [NHS HLP Social Prescribing and Self Care Wiki](https://wiki.healthylondon.org)

# History

in 2017 the AgileVentures charity was awarded a contract on a tender put out by the NHS HLP Proactive Care team to build a wiki to support knowledge management for commissioners (UK clinical folks who assign budgets to pay for health related services throughout the UK) and other interested stakeholders working with Social Prescribing in the UK.  Social Prescribing, sometimes referred to as community referral, is a means of enabling GPs, nurses and other staff working in the health and care sectors to refer people to a range of local, non-clinical services.

The wiki went live on May 4th 2017, and AgileVentures continues to host, maintain, moderate and develop the wiki.  Here are some documents on the original design and development process.

[Original Design Sprint blogs](https://medium.com/agileventures/nhs-design-sprint-day-one-535e0500d2be)

[Original Bitnami/Azure Mediawiki deployment process](https://medium.com/agileventures/azure-mediawiki-stack-part-1-be00a29eade9)

Current Status
==============

We're trying to migrate from bitnami/azure to a dokku/azure deployment process to make future upgrades to the underlying mediawiki software easier, as well as ensuring that all the configuration for the system is versioned.

We're working on organising our documentation which can currently be found in the [docs](/docs) folder in this repo

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
