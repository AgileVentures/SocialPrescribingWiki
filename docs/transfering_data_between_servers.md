Database
--------

ssh into the server you want to grab data from, and this command will create the backup

```
mysqldump -h localhost -u bn_mediawiki -p bitnami_mediawiki  > backup.sql
```

Pull that backup down locally with scp:

```
scp hlpwiki:/home/bitnami/backup.sql .
```

assuming you have the hostname etc. in .ssh/config

```
Host hlpwiki
HostName bitnami-mediawiki-8a65.cloudapp.net
User bitnami
```

Stream a backup of db to a new instance

```
ssh -t hlp-dokku mariadb:import mediawiki_official < backup.sql
```

FileSystem
----------

Mediawiki recommends grabbing the files from production with this [command](https://www.mediawiki.org/wiki/Manual:DumpUploads.php)

```
~/apps/mediawiki/htdocs$ php maintenance/dumpUploads.php | xargs tar cf backup_files.tar
```

However we get these problems:

```
xargs: unmatched single quote; by default quotes are special to xargs unless you use the -0 option
tar: images/2/21/Upload_file_button.png: Cannot stat: No such file or directory
tar: Exiting with failure status due to previous errors
```

so we prefer:
```
tar vcf images.tar images/
```

pull the tar down locally

```
scp hlpwiki:/home/bitnami/apps/mediawiki/htdocs/images.tar .
```

assuming that the directory where you want the files is available on the remote box, transfer the tar file to the remote box:

```
scp images.tar hlp-ssh:~/ # upload to user direcotory
sudo mv images.tar /var/lib/dokku/data/storage/hlpwiki/  # move to desired location
```

then unpack the files:

```
cd /var/lib/dokku/data/storage/hlpwiki/
sudo tar xf images.tar
```

and set the permissions correctly:

```
sudo chown -R  www-data:www-data images
```
