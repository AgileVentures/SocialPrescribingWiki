First error, when trying to run `sudo update-alternatives --set php /usr/bin/php7.2`

`update-alternatives: warning: forcing reinstallation of alternative /usr/bin/php7.2 because link group php is broken`

Following instructions here:
<<<<<<< HEAD
https://thishosting.rocks/install-php-on-ubuntu/
I ran `sudo apt-get update && sudo apt-get upgrade` to which I got this notice:
=======

https://thishosting.rocks/install-php-on-ubuntu/

I ran `sudo apt-get update && sudo apt-get upgrade` to which I got this notice:

>>>>>>> 966760563cd8aa6da03b6b942f1090d870615a53
```
* Restarting web server apache2                                                                                                                                               AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.0.1. Set the 'ServerName' directive globally to suppress this message
(98)Address already in use: AH00072: make_sock: could not bind to address [::]:80
(98)Address already in use: AH00072: make_sock: could not bind to address 0.0.0.0:80
no listening sockets available, shutting down
AH00015: Unable to open logs
Action 'start' failed.
The Apache error log may have more information.
                                                                                                                                                                        [fail]
 * The apache2 instance did not start within 20 seconds. Please read the log files to discover problems
invoke-rc.d: initscript apache2, action "restart" failed.
```
<<<<<<< HEAD
Maybe the server needed to be stopped first?
As a result of running the upgrade, there seems to be an issue introduced with locales which threw this error:
=======

Maybe the server needed to be stopped first?
As a result of running the upgrade, there seems to be an issue introduced with locales which threw this error:

>>>>>>> 966760563cd8aa6da03b6b942f1090d870615a53
```
matt@bitnami-mediawiki-8a65:~$ sudo add-apt-repository ppa:ondrej/apache2
 This branch follows latest Apache2 packages as maintained by the Debian Apache2 team with couple of compatibility patches on top.

It also includes some widely used Apache 2 modules (if you need some other feel free to send me a request).

BUGS&FEATURES: This PPA now has a issue tracker: https://deb.sury.org/#bug-reporting

PLEASE READ: If you like my work and want to give me a little motivation, please consider donating: https://deb.sury.org/#donate
 More info: https://launchpad.net/~ondrej/+archive/ubuntu/apache2
Press [ENTER] to continue or ctrl-c to cancel adding it

gpg: keyring `/tmp/tmpjtk3pp50/secring.gpg' created
gpg: keyring `/tmp/tmpjtk3pp50/pubring.gpg' created
gpg: requesting key E5267A6C from hkp server keyserver.ubuntu.com
gpg: /tmp/tmpjtk3pp50/trustdb.gpg: trustdb created
gpg: key E5267A6C: public key "Launchpad PPA for Ond\xc5\x99ej Sur�" imported
gpg: Total number processed: 1
gpg:               imported: 1  (RSA: 1)
Exception in thread Thread-1:
Traceback (most recent call last):
  File "/usr/lib/python3.4/threading.py", line 920, in _bootstrap_inner
    self.run()
  File "/usr/lib/python3.4/threading.py", line 868, in run
    self._target(*self._args, **self._kwargs)
  File "/usr/lib/python3/dist-packages/softwareproperties/SoftwareProperties.py", line 687, in addkey_func
    func(**kwargs)
  File "/usr/lib/python3/dist-packages/softwareproperties/ppa.py", line 370, in add_key
    return apsk.add_ppa_signing_key()
  File "/usr/lib/python3/dist-packages/softwareproperties/ppa.py", line 261, in add_ppa_signing_key
    tmp_export_keyring, signing_key_fingerprint, tmp_keyring_dir):
  File "/usr/lib/python3/dist-packages/softwareproperties/ppa.py", line 210, in _verify_fingerprint
    got_fingerprints = self._get_fingerprints(keyring, keyring_dir)
  File "/usr/lib/python3/dist-packages/softwareproperties/ppa.py", line 202, in _get_fingerprints
    output = subprocess.check_output(cmd, universal_newlines=True)
  File "/usr/lib/python3.4/subprocess.py", line 609, in check_output
    output, unused_err = process.communicate(inputdata, timeout=timeout)
  File "/usr/lib/python3.4/subprocess.py", line 947, in communicate
    stdout = _eintr_retry_call(self.stdout.read)
  File "/usr/lib/python3.4/subprocess.py", line 491, in _eintr_retry_call
    return func(*args)
  File "/usr/lib/python3.4/encodings/ascii.py", line 26, in decode
    return codecs.ascii_decode(input, self.errors)[0]
UnicodeDecodeError: 'ascii' codec can't decode byte 0xc5 in position 92: ordinal not in range(128)
```
<<<<<<< HEAD
Was able to get passed this by prefixing it like so:
=======

Was able to get passed this by prefixing it like so:

>>>>>>> 966760563cd8aa6da03b6b942f1090d870615a53
```
matt@bitnami-mediawiki-8a65:~$ LC_ALL=C.UTF-8 sudo add-apt-repository -y ppa:ondrej/apache2
gpg: keyring `/tmp/tmpm6wqz257/secring.gpg' created
gpg: keyring `/tmp/tmpm6wqz257/pubring.gpg' created
gpg: requesting key E5267A6C from hkp server keyserver.ubuntu.com
gpg: /tmp/tmpm6wqz257/trustdb.gpg: trustdb created
gpg: key E5267A6C: public key "Launchpad PPA for Ondřej Surý" imported
gpg: Total number processed: 1
gpg:               imported: 1  (RSA: 1)
```

Maybe a more permanent fix can be found here? https://askubuntu.com/questions/393638/unicodedecodeerror-ascii-codec-cant-decode-byte-0x-in-position-ordinal-n

This was some interesting output from a command I found here: https://ayesh.me/Ubuntu-PHP-7.2

```
matt@bitnami-mediawiki-8a65:~$ apachectl -V
AH00526: Syntax error on line 35 of /opt/bitnami/apache2/conf/bitnami/bitnami.conf:
SSLCertificateFile: file '/etc/letsencrypt/live/hlp-wiki-production-clone.agileventures.org/fullchain.pem' does not exist or is empty
```

There seem to be more than one certficate here?

`sudo vim /etc/letsencrypt/live/hlp-wiki-production-clone.agileventures.org/fullchain.pem`

This rather long output seems to indicate that php is still v5.6.30?

```
php --info
phpinfo()
PHP Version => 5.6.30
```

Attempt to disconfigure apache to use php5.6 says that php5.6 does not exist, same result as for php5:

```
matt@bitnami-mediawiki-8a65:~$ sudo a2disconf php5.6
perl: warning: Setting locale failed.
perl: warning: Please check that your locale settings:
	LANGUAGE = (unset),
	LC_ALL = (unset),
	LC_PAPER = "pt_BR.UTF-8",
	LC_ADDRESS = "pt_BR.UTF-8",
	LC_MONETARY = "pt_BR.UTF-8",
	LC_NUMERIC = "pt_BR.UTF-8",
	LC_TELEPHONE = "pt_BR.UTF-8",
	LC_IDENTIFICATION = "pt_BR.UTF-8",
	LC_MEASUREMENT = "pt_BR.UTF-8",
	LC_CTYPE = "pt_BR.UTF-8",
	LC_TIME = "pt_BR.UTF-8",
	LC_NAME = "pt_BR.UTF-8",
	LANG = "en_US.UTF-8"
    are supported and installed on your system.
perl: warning: Falling back to the standard locale ("C").
ERROR: Conf php5.6 does not exist!

matt@bitnami-mediawiki-8a65:~$ sudo a2dismod php5.6
perl: warning: Setting locale failed.
perl: warning: Please check that your locale settings:
	LANGUAGE = (unset),
	LC_ALL = (unset),
	LC_PAPER = "pt_BR.UTF-8",
	LC_ADDRESS = "pt_BR.UTF-8",
	LC_MONETARY = "pt_BR.UTF-8",
	LC_NUMERIC = "pt_BR.UTF-8",
	LC_TELEPHONE = "pt_BR.UTF-8",
	LC_IDENTIFICATION = "pt_BR.UTF-8",
	LC_MEASUREMENT = "pt_BR.UTF-8",
	LC_CTYPE = "pt_BR.UTF-8",
	LC_TIME = "pt_BR.UTF-8",
	LC_NAME = "pt_BR.UTF-8",
	LANG = "en_US.UTF-8"
    are supported and installed on your system.
perl: warning: Falling back to the standard locale ("C").
ERROR: Module php5.6 does not exist!
```

sudo a2enmod php7.2 to enable 7.2 says that it is already enabled, but adds `Considering conflict php5 for php7.2`

```
matt@bitnami-mediawiki-8a65:~$ sudo a2enmod php7.2
perl: warning: Setting locale failed.
perl: warning: Please check that your locale settings:
	LANGUAGE = (unset),
	LC_ALL = (unset),
	LC_PAPER = "pt_BR.UTF-8",
	LC_ADDRESS = "pt_BR.UTF-8",
	LC_MONETARY = "pt_BR.UTF-8",
	LC_NUMERIC = "pt_BR.UTF-8",
	LC_TELEPHONE = "pt_BR.UTF-8",
	LC_IDENTIFICATION = "pt_BR.UTF-8",
	LC_MEASUREMENT = "pt_BR.UTF-8",
	LC_CTYPE = "pt_BR.UTF-8",
	LC_TIME = "pt_BR.UTF-8",
	LC_NAME = "pt_BR.UTF-8",
	LANG = "en_US.UTF-8"
    are supported and installed on your system.
perl: warning: Falling back to the standard locale ("C").
Considering dependency mpm_prefork for php7.2:
Considering conflict mpm_event for mpm_prefork:
Considering conflict mpm_worker for mpm_prefork:
Module mpm_prefork already enabled
Considering conflict php5 for php7.2:
Module php7.2 already enabled
matt@bitnami-mediawiki-8a65:~$ locale -a | grep "^en_.\+UTF-8"
locale: Cannot set LC_CTYPE to default locale: No such file or directory
```

Attempting to purge php5 with `sudo apt purge php5*` resulted in all php's being purged, except that `php -v` continued with the same output.

After having walked through the process of reinstalling php7.2, I found a SO post that said to run `sudo apt-get purge php5-common` with the same results, no change.

Trouble starting apache with port 80 error resolved with:

`sudo killall -9 apache2`

Confident that apache2 had php7.2 enabled and only 7.2, I proceeded with the upgrade instructions for downloading mediawiki-1.31 in the `/home/matt` folder.

That went smoothly, and I made note of the fact that many extensions were already added to the extensions folder.

I copied over the `LocalSettings.php` and went through it, updating a `require_once` to newer after `mediawiki-1.24` syntax. The ones added by us I didn't update in this fashion.

I made a note of the extensions that would need to be added, which were these, with my notes of what I did.

```
ExtraLanguageLink - added, no extra config...
EmbedVideo - https://github.com/HydraWiki/mediawiki-embedvideo#installation
SemanticMediaWiki
ShoogleTweet
WikiSEO
ImageMap - comes with mediawiki
Moderation
```

I decided to not continue on because it occurred to me that there is no easy way to check to see that things are working before adding all the extensions and would be better if we can get apache serving this new mediawiki instance and add the extensions one by one and verify they work before continuing.

Some places I looked for apache config:

```
sudo vim /opt/bitnami/apache2/conf/bitnami/httpd.conf
sudo vim /opt/bitnami/apache2/conf/original/httpd.conf
sudo vim /opt/bitnami/apache2/conf/httpd.conf
```

I have also noted that bitnami really do not make it easy to upgrade any of these things in place really. Here is a bitnami community post where someone is trying to update php form 5.6 to 7 as we would need to do and the response from the bitnami people, presumably, is to just launch a new instance. https://community.bitnami.com/t/how-to-update-bitmani-lamp-php-5-6-to-7-0/44676/20
