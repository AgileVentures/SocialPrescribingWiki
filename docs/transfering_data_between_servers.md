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

grab the files from production

```
~/apps/mediawiki/htdocs$ php maintenance/dumpUploads.php | xargs tar cf backup_files.tar
```

note this may generated the following warnings:

```
xargs: unmatched single quote; by default quotes are special to xargs unless you use the -0 option
tar: images/2/21/Upload_file_button.png: Cannot stat: No such file or directory
tar: Exiting with failure status due to previous errors
```

pull the tar down locally

```
scp hlpwiki:/home/bitnami/apps/mediawiki/htdocs/backup_files.tar .
```

assuming that the directory where you want the files is available on the remote box, transfer the tar file to the remote box:

```
scp backup_files.tar hlp-ssh:~/ # upload to user direcotory
sudo mv backup_files.tar /var/lib/dokku/data/storage/hlpwiki/  # move to desired location
```

then unpack the files:

```
cd /var/lib/dokku/data/storage/hlpwiki/
sudo tar xf backup_files.tar
```
