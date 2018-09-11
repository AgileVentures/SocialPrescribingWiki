The [bitnami docs on mediawiki](https://docs.bitnami.com/installer/apps/mediawiki/)

Apparently we can upgrade a mediawiki in place 

* https://docs.bitnami.com/aws/apps/mediawiki/#how-to-upgrade-mediawiki
* https://www.mediawiki.org/wiki/Manual:Upgrading


Setting up backups on staging (to replicate production)

![](https://dl.dropbox.com/s/xt0s5mxqg56g5v4/Screenshot%202018-09-10%2013.55.25.png?dl=0)



Creating a new server
---------------------

1. Selecting a cloud

![](https://dl.dropbox.com/s/foe9rqjf3jq6k2s/Screenshot%202018-09-11%2013.09.55.png?dl=0)

2. find mediawiki

![](https://dl.dropbox.com/s/gc63t02srgu0hmi/Screenshot%202018-09-11%2013.10.59.png?dl=0)



possible problems
-----------------

> AADSTS50020: User account 'sam@agileventures.org' from identity provider 'live.com' does not exist in tenant 'Default Directory' and cannot access the application 'a9932f31-f5ee-486a-8563-c76331b1945f' in that tenant. The account needs to be added as an external user in the tenant first. Sign out and sign in again with a different Azure Active Directory user account.

![](https://dl.dropbox.com/s/cll9a4wvqi7yxog/Screenshot%202018-09-11%2013.15.18.png?dl=0)

> You have no Subscriptions in your account. Please contact your administrator for giving you access for a subscription.

![](https://dl.dropbox.com/s/flwoyc3qs7gsw6c/Screenshot%20at%202018-09-11%2012%3A39%3A16.png?dl=0)

this is the types of users we have (only federico can see this):

![](https://dl.dropbox.com/s/x8klbhnr5hrvkfd/Screenshot%202018-09-11%2016.40.42.png?dl=0)
