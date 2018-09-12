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
c) set up agileventures subdomain on gandi DNS

```
hlp-wiki-production-clone 10800 IN CNAME hlpwiki-production-clone.cloudapp.net.
```


d) tune the parsoid/mediawiki/apache config

in `/home/bitnami/apps/mediawiki/htdocsLocalSettings.php` update the Parsoid URL

```
## Parsoid service for Visual Editor

$wgVirtualRestConfig['modules']['parsoid'] = array(
        // URL to the Parsoid instance
        // Use port 8142 if you use the Debian package
        'url' => 'https://hlp-wiki-production-clone.agileventures.org:8000',
        // Parsoid "domain", see below (optional)
        'domain' => 'localhost',
        //Parsoid "prefix", see below (optional)
        'prefix' => 'localhost'
);
```

update `sudo nano /etc/mediawiki/parsoid/config.yaml`

```
        mwApis:
        - # This is the only required parameter,
          # the URL of you MediaWiki API endpoint.
          uri: 'https://hlp-wiki-production-clone.agileventures.org/api.php'
          # The "domain" is used for communication with Visual Editor
```

update `nano /etc/mediawiki/parsoid/settings.js`

```
parsoidConfig.setMwApi({ uri: 'https://hlp-wiki-production-clone.agileventures.org/api.php', prefix: ...
```

update `sudo nano /opt/bitnami/apache2/conf/bitnami/bitnami.conf` (stop apache before this change)

```
<VirtualHost *:80>
  DocumentRoot "/opt/bitnami/apache2/htdocs"
  ServerName hlp-wiki-production-clone.agileventures.org
  Redirect permanent / https://hlp-wiki-production-clone.agileventures.org/
</VirtualHost>

<VirtualHost *:8000>
  ProxyPreserveHost On
  ProxyRequests Off
  ServerName hlp-wiki-production-clone.agileventures.org
#  ServerAlias healthylondon.org
  SSLEngine on
  SSLCertificateFile /etc/letsencrypt/live/hlp-wiki-production-clone.agileventures.org/fullchain.pem
  SSLCertificateKeyFile /etc/letsencrypt/live/hlp-wiki-production-clone.agileventures.org/privkey.pem

  ProxyPass / http://localhost:8142/
  ProxyPassReverse / http://localhost:8142/
</VirtualHost>

<VirtualHost _default_:443>
  DocumentRoot "/opt/bitnami/apache2/htdocs"
  ServerName hlp-wiki-production-clone.agileventures.org
  SSLEngine on
  SSLCertificateFile /etc/letsencrypt/live/hlp-wiki-production-clone.agileventures.org/fullchain.pem
  SSLCertificateKeyFile /etc/letsencrypt/live/hlp-wiki-production-clone.agileventures.org/privkey.pem

  <Directory "/opt/bitnami/apache2/htdocs">
```

e) set up the ssl certs (stop apache first)

```
sudo certbot certonly --standalone
```



Notes
-----

Apparently we can upgrade a mediawiki in place 

* https://docs.bitnami.com/aws/apps/mediawiki/#how-to-upgrade-mediawiki
* https://www.mediawiki.org/wiki/Manual:Upgrading


Setting up backups on staging (to mirror the situation on production)

![](https://dl.dropbox.com/s/xt0s5mxqg56g5v4/Screenshot%202018-09-10%2013.55.25.png?dl=0)
