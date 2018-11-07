
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
