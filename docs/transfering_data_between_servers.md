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

pull the tar down locally

```
scp hlpwiki:/home/bitnami/apps/mediawiki/htdocs/backup_files.tar .
```
ssh into the box you want to transfer the files to and create a directory like so:

```
sudo mkdir -p  /var/lib/dokku/data/storage/mediawiki_official
```

change the permissions like so:

```
sudo chown -R dokku:dokku /var/lib/dokku/data/storage/mediawiki_official
```
Notes from dokku persistent storage documentation:

```
# For dockerfile deploys, substitute the user and group id in use within the image
chown -R 32767:32767 /var/lib/dokku/data/storage/mediawiki_official
```
