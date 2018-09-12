Matt's work from part 5 of the sprint
-------------------------------------

After having tried to follow Sam's blog step by step at: https://medium.com/agileventures/azure-mediawiki-stack-part-4-2697678a43aa, and not finding any `/tmp/certbot` or `certbot-auto`, I decided to go directly to certbot's site and see how the commands differed.

I was able to find this, https://certbot.eff.org/lets-encrypt/ubuntutrusty-apache, which is for ubuntutrust and apache, and followed the instructions there, by running:

```
$ sudo apt-get update
$ sudo apt-get install software-properties-common
$ sudo add-apt-repository ppa:certbot/certbot
$ sudo apt-get update
$ sudo apt-get install python-certbot-apache
```

software-properties-common was already installed, but python-certbot-apache was not.

Then the instructions say to run `sudo certbot --apache`, and added 

```
Running this command will get a certificate for you and have Certbot edit your Apache configuration automatically to serve it. If you're feeling more conservative and would like to make the changes to your Apache configuration by hand, you can use the certonly subcommand:
``` 

`sudo certbot --apache certonly`

As this was what I found Sam had run in the blog post, I tried this command with `--webroot` like so: `sudo certbot certonly --webroot -w /opt/bitnami/apps/mediawiki/htdocs/ -d hlp-wiki-staging-clone.agileventures.org`, which failed with this error 

```
Failed authorization procedure. hlp-wiki-staging-clone.agileventures.org (http-01): urn:ietf:params:acme:error:connection :: The server could not connect to the client to verify the domain :: Fetching http://hlp-wiki-staging-clone.agileventures.org/.well-known/acme-challenge/e5uTN1hwKhUJw0raoYnORUW3YFqstyd1KdB7o-QHfIU: Connection refused
```

Feeling I might make things more difficult, I stopped the video recording, and almost gave up, when I decided to try running the `sudo certbot --apache certonly` command, which prompted me like so: 

```
No names were found in your configuration files. Please enter in your domain
name(s) (comma and/or space separated)  (Enter 'c' to cancel): hlp-wiki-staging-clone.agileventures.org
``` 

and then created the certificate!!

Success looks like this:

```
Congratulations! You have successfully enabled
https://hlp-wiki-staging-clone.agileventures.org

You should test your configuration at:
https://www.ssllabs.com/ssltest/analyze.html?d=hlp-wiki-staging-clone.agileventures.org
```

I promptly went to test the configuration which gave me this result:

![](https://dl.dropbox.com/s/2ymz7k32h47wvi0/hlp-wiki-staging-clone-test-cert.png?dl=0)

The output also gave this helpful information:

```
IMPORTANT NOTES:
 - Congratulations! Your certificate and chain have been saved at:
   /etc/letsencrypt/live/hlp-wiki-staging-clone.agileventures.org/fullchain.pem
   Your key file has been saved at:
   /etc/letsencrypt/live/hlp-wiki-staging-clone.agileventures.org/privkey.pem
   Your cert will expire on 2018-12-10. To obtain a new or tweaked
   version of this certificate in the future, simply run certbot again
   with the "certonly" option. To non-interactively renew *all* of
   your certificates, run "certbot renew"```

I then went to start apache and got this familiar error from day 1 of our Sprint
```
matt@bitnami-mediawiki-74f7:/etc/certbot$ sudo /opt/bitnami/ctlscript.sh start apache
Syntax OK
(98)Address already in use: AH00072: make_sock: could not bind to address [::]:80
(98)Address already in use: AH00072: make_sock: could not bind to address 0.0.0.0:80
no listening sockets available, shutting down
AH00015: Unable to open logs
/opt/bitnami/apache2/scripts/ctl.sh : httpd could not be started
Monitored apache
```
I was able to get passed this by running a serious of commands to kill the process listening on port 80, but not the first time, nor the second, that I tried.
```
sudo netstat -tulpn | grep :::80
tcp6       0      0 :::80                   :::*                    LISTEN      18361/apache2   
matt@bitnami-mediawiki-74f7:/etc/certbot$ sudo kill -9 18361
matt@bitnami-mediawiki-74f7:/etc/certbot$ sudo netstat -tulpn | grep :::80
matt@bitnami-mediawiki-74f7:/etc/certbot$ sudo /opt/bitnami/ctlscript.sh start apache
Syntax OK
/opt/bitnami/apache2/scripts/ctl.sh : httpd started at port 80
Monitored apache
```
 Not a hundred percent sure why it was successfully killed this time and not the others...

Having got that to work, I moved on in the blog and tried making a symlink, like so:
```
matt@bitnami-mediawiki-74f7:/etc/certbot$ sudo ln -s /etc/letsencrypt/live/hlp-wiki-staging-clone.agileventures.org/fullchain.pem /opt/bitnami/apache2/conf/server.crt
ln: failed to create symbolic link '/opt/bitnami/apache2/conf/server.crt': File exists
matt@bitnami-mediawiki-74f7:/etc/certbot$ sudo ln -s /etc/letsencrypt/live/hlp-wiki-staging-clone.agileventures.org/fullchain.pem /opt/bitnami/apache2/conf/server.key
ln: failed to create symbolic link '/opt/bitnami/apache2/conf/server.key': File exists
```
, which gave me a similar error to what Sam had documented. Somewhat unsurprisingly as we had taken a clone of the staging server and those files have the info serving `hlp-wiki-develop.agileventures.org`.

I was able to find this site, https://community.bitnami.com/t/lets-encrypt-error-file-exists-following-bitnami-guide/51351/2, which talks about moving, or removing, those files. I removed those files and succesfully created the symlinks. After having restarted apache, I got the following result!
![](https://dl.dropbox.com/s/n8df8w39x4glive/hlp-wiki-staging-clone-https-success.png?dl=0)

Also, it seems like we changed the necessary config files to get VisualEditor working in part 3 of the blog!!
![](https://dl.dropbox.com/s/bk2sa4tlw6kp4xx/hlp-wiki-staging-clone-veditor-working.png?dl=0)
![](https://dl.dropbox.com/s/bovcvwk6ttne160/hlp-wiki-staging-clone-visual-editor.png?dl=0)
