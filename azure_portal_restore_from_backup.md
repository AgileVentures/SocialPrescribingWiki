1. Create VM from backup

![](https://dl.dropbox.com/s/9pq3jzu2bqa1ksx/Screenshot%202018-09-12%2016.06.38.png?dl=0)

![](https://dl.dropbox.com/s/7j7ctppiwx1ek6y/Screenshot%202018-09-12%2016.06.59.png?dl=0)

2. Wait until new VM has been created

![](https://dl.dropbox.com/s/foewonwp9mtba1q/Screenshot%202018-09-12%2016.07.58.png?dl=0)

3. To access the box we pop the following in our ~.ssh/config

```
Host hlpwiki-production-clone
HostName hlpwiki-production-clone.cloudapp.net
User bitnami
```


4. Now need to adjust the box

a) adjust the port endpoints (they get randomised)

![](https://dl.dropbox.com/s/5vzili62uyb73l7/Screenshot%202018-09-12%2016.15.47.png?dl=0)

need to be as follows:

![](https://dl.dropbox.com/s/lhw1ypedcap55to/Screenshot%202018-09-12%2016.32.33.png?dl=0)

b) ensure apache is running (may involve configuring sshd)
c) set up agileventures subdomain on gandi
d) set up the ssl certs
e) tune the parsoid/mediawiki/apache config





Notes
-----

Apparently we can upgrade a mediawiki in place 

* https://docs.bitnami.com/aws/apps/mediawiki/#how-to-upgrade-mediawiki
* https://www.mediawiki.org/wiki/Manual:Upgrading


Setting up backups on staging (to mirror the situation on production)

![](https://dl.dropbox.com/s/xt0s5mxqg56g5v4/Screenshot%202018-09-10%2013.55.25.png?dl=0)
