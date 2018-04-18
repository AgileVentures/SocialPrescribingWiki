for access to the staging server add the following to your ~/.ssh/config file:

```
Host hlpwiki-staging
HostName bitnami-mediawiki-74f7.cloudapp.net
User bitnami
```

we will also need your ssh public key to give you access


## Adding Another User to the VM

see also: https://docs.bitnami.com/aws/faq/operating-servers-instances/provide_additional_ssh_access/

To grant VM access to another user:

1. `ssh ubuntu@hlpwiki-staging`

2. `sudo adduser michael` to add a sam as a user and fill out form with password. Dispatch password to michael forthwith, using any means at your disposal, however crypographically insecure.

```
bitnami@bitnami-mediawiki-74f7:~$ sudo adduser michael
Adding user `michael' ...
Adding new group `michael' (1003) ...
Adding new user `michael' (1002) with group `michael' ...
Creating home directory `/home/michael' ...
Copying files from `/etc/skel' ...
Enter new UNIX password: 
Retype new UNIX password: 
passwd: password updated successfully
Changing the user information for michael
Enter the new value, or press ENTER for the default
	Full Name []: Michael C
	Room Number []: 
	Work Phone []: 
	Home Phone []: 
	Other []: 
Is the information correct? [Y/n] Y
```

3. Create .ssh directory for michael user: `mkdir /home/michael/.ssh` and then:

```
sudo cp -rp ~bitnami/.ssh ~michael/
sudo cp -rp ~bitnami/.bashrc ~michael/
sudo cp -rp ~bitnami/.profile ~michael/
```

4. Edit the authorized keys file `sudo nano /home/michael/.ssh/authorized_keys` and add michael's public key (making sure ssh is at the start)
5. Give michael back ownership of his folder and file

   ```sh
     $ sudo chown michael:michael /home/michael/.ssh/authorized_keys

     $ sudo chown michael:michael /home/michael/.ssh
   ```

7. Add michael to the sudoer group: `sudo usermod -aG bitnami-admins michael`
8. Run the service to make ssh changes be taken up: `sudo service ssh reload`


    Now michael should be able to ssh in with a proper configuration on his side.
