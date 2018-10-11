Production server:
------------------

The following seems to work pretty reliably

```
$ sudo /opt/bitnami/ctlscript.sh stop apache
$ sudo certbot renew
$ sudo /opt/bitnami/ctlscript.sh start apache
```

Staging server: `sudo certbot renew` appears to work but may see the following:
------------------------------------------------------------------------------

```
bitnami@bitnami-mediawiki-74f7:~$ sudo certbot renew
Saving debug log to /var/log/letsencrypt/letsencrypt.log

-------------------------------------------------------------------------------
Processing /etc/letsencrypt/renewal/hlp-wiki-develop.agileventures.org.conf
-------------------------------------------------------------------------------
Cert not yet due for renewal

The following certs are not due for renewal yet:
  /etc/letsencrypt/live/hlp-wiki-develop.agileventures.org/fullchain.pem (skipped)
No renewals were attempted.
```

in which case ensure to restart apache:

```
sudo /opt/bitnami/ctlscript.sh restart apache
```

Production server (renewing cert requires taking system offline)
----------------------------------------------------------------

```
$ sudo /opt/bitnami/ctlscript.sh stop
$ sudo certbot renew --standalone --preferred-challenges http
$ sudo /opt/bitnami/ctlscript.sh start
```

`sudo certbot renew` currently fails with this error:

```
bitnami@bitnami-mediawiki-8a65:~$ sudo certbot renew
Saving debug log to /var/log/letsencrypt/letsencrypt.log

-------------------------------------------------------------------------------
Processing /etc/letsencrypt/renewal/wiki.healthylondon.org.conf
-------------------------------------------------------------------------------
Cert is due for renewal, auto-renewing...
Could not choose appropriate plugin: The manual plugin is not working; there may be problems with your existing configuration.
The error was: PluginError('An authentication script must be provided with --manual-auth-hook when using the manual plugin non-interactively.',)
Attempting to renew cert (wiki.healthylondon.org) from /etc/letsencrypt/renewal/wiki.healthylondon.org.conf produced an unexpected error: The manual plugin is not working; there may be problems with your existing configuration.
The error was: PluginError('An authentication script must be provided with --manual-auth-hook when using the manual plugin non-interactively.',). Skipping.
All renewal attempts failed. The following certs could not be renewed:
  /etc/letsencrypt/live/wiki.healthylondon.org/fullchain.pem (failure)

-------------------------------------------------------------------------------

All renewal attempts failed. The following certs could not be renewed:
  /etc/letsencrypt/live/wiki.healthylondon.org/fullchain.pem (failure)
-------------------------------------------------------------------------------
1 renew failure(s), 0 parse failure(s)
```
standalone switch gets further, but still no joy.  --apache switch fails with the following:

```
bitnami@bitnami-mediawiki-8a65:~$ sudo certbot renew --apache
Saving debug log to /var/log/letsencrypt/letsencrypt.log

-------------------------------------------------------------------------------
Processing /etc/letsencrypt/renewal/wiki.healthylondon.org.conf
-------------------------------------------------------------------------------
Cert is due for renewal, auto-renewing...
Plugins selected: Authenticator apache, Installer apache
Renewing an existing certificate
Performing the following challenges:
tls-sni-01 challenge for wiki.healthylondon.org
Enabled Apache socache_shmcb module
Enabled Apache ssl module
Error while running apache2ctl graceful.
httpd not running, trying to start
Action 'graceful' failed.
The Apache error log may have more information.

AH00112: Warning: DocumentRoot [/var/lib/letsencrypt/tls_sni_01_page/] does not exist
AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.0.1. Set the 'ServerName' directive globally to suppress this message
(98)Address already in use: AH00072: make_sock: could not bind to address [::]:80
(98)Address already in use: AH00072: make_sock: could not bind to address 0.0.0.0:80
no listening sockets available, shutting down
AH00015: Unable to open logs

Cleaning up challenges
Error while running apache2ctl graceful.
httpd not running, trying to start
Action 'graceful' failed.
The Apache error log may have more information.

AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.0.1. Set the 'ServerName' directive globally to suppress this message
(98)Address already in use: AH00072: make_sock: could not bind to address [::]:80
(98)Address already in use: AH00072: make_sock: could not bind to address 0.0.0.0:80
no listening sockets available, shutting down
AH00015: Unable to open logs

Encountered exception during recovery
Error while running apache2ctl graceful.
httpd not running, trying to start
Action 'graceful' failed.
The Apache error log may have more information.

AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.0.1. Set the 'ServerName' directive globally to suppress this message
(98)Address already in use: AH00072: make_sock: could not bind to address [::]:80
(98)Address already in use: AH00072: make_sock: could not bind to address 0.0.0.0:80
no listening sockets available, shutting down
AH00015: Unable to open logs
Traceback (most recent call last):
  File "/usr/lib/python2.7/dist-packages/certbot/error_handler.py", line 100, in _call_registered
    self.funcs[-1]()
  File "/usr/lib/python2.7/dist-packages/certbot/auth_handler.py", line 284, in _cleanup_challenges
    self.auth.cleanup(achalls)
  File "/usr/lib/python2.7/dist-packages/certbot_apache/configurator.py", line 1945, in cleanup
    self.restart()
  File "/usr/lib/python2.7/dist-packages/certbot_apache/configurator.py", line 1834, in restart
    self._reload()
  File "/usr/lib/python2.7/dist-packages/certbot_apache/configurator.py", line 1845, in _reload
    raise errors.MisconfigurationError(str(err))
MisconfigurationError: Error while running apache2ctl graceful.
httpd not running, trying to start
Action 'graceful' failed.
The Apache error log may have more information.

AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.0.1. Set the 'ServerName' directive globally to suppress this message
(98)Address already in use: AH00072: make_sock: could not bind to address [::]:80
(98)Address already in use: AH00072: make_sock: could not bind to address 0.0.0.0:80
no listening sockets available, shutting down
AH00015: Unable to open logs

Attempting to renew cert (wiki.healthylondon.org) from /etc/letsencrypt/renewal/wiki.healthylondon.org.conf produced an unexpected error: Error while running apache2ctl graceful.
httpd not running, trying to start
Action 'graceful' failed.
The Apache error log may have more information.

AH00112: Warning: DocumentRoot [/var/lib/letsencrypt/tls_sni_01_page/] does not exist
AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.0.1. Set the 'ServerName' directive globally to suppress this message
(98)Address already in use: AH00072: make_sock: could not bind to address [::]:80
(98)Address already in use: AH00072: make_sock: could not bind to address 0.0.0.0:80
no listening sockets available, shutting down
AH00015: Unable to open logs
. Skipping.
All renewal attempts failed. The following certs could not be renewed:
  /etc/letsencrypt/live/wiki.healthylondon.org/fullchain.pem (failure)

-------------------------------------------------------------------------------

All renewal attempts failed. The following certs could not be renewed:
  /etc/letsencrypt/live/wiki.healthylondon.org/fullchain.pem (failure)
-------------------------------------------------------------------------------
```


