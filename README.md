# Healthy Hearing - CakePHP 4.x

The [Healthy Hearing](https://www.healthyhearing.com) application codebase, made with [CakePHP](https://cakephp.org) 4.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation and Initial Setup
The following instructions presume that you have a working setup of the [Healthy Hearing development environment](https://github.com/Healthy-Hearing/HH-CakePHP4x-DevEnv) that is compatible with CakePHP 4.x.

### Start with an empty hh/ directory
Be sure that the hh/ directory created during your environment setup is empty; _that includes hidden files_.

### Clone the HH-CakePHP-4x repository
From within your VM, in the `/var/www/` directory, and as the `hhadmin` user, clone the project (you may need approve adding a Github IP to the list of known hosts):
```bash
hhadmin@vagrant:/var/www$ git clone git@github.com:Healthy-Hearing/HH-CakePHP-4x.git hh
Cloning into ‘hh’...
Warning: Permanently added the ECDSA host key for IP address ‘140.82.114.3’ to the list of known hosts.
remote: Enumerating objects: 1481, done.
remote: Counting objects: 100% (782/782), done.
remote: Compressing objects: 100% (521/521), done.
remote: Total 1481 (delta 456), reused 542 (delta 225), pack-reused 699
Receiving objects: 100% (1481/1481), 641.23 KiB | 282.00 KiB/s, done.
Resolving deltas: 100% (1052/1052), done.
```

### Make `tmp` and `logs` directories in `hh` directory
```bash
hhadmin@vagrant:/var/www/hh$ mkdir tmp logs
```
After creating those two directories, re-run the Vagrant "`shell`" provisioner _from your computer_ in the directory where your environment files are located:
```bash
Your-Computer-Name:HH-CakePHP4x-DevEnv user.name$ vagrant provision --provision-with shell
```
This will set the proper permissions on the newly created directories.

### Install composer-defined dependencies
From within your VM and as the `hhadmin` user, run the following command:
```bash
hhadmin@vagrant:/var/www/hh$ composer install
```
When asked about folder permissions, select/enter the _yes_ option.

### Set up local development database connections
Update `config/app_local.php` to include the username, password, and database name for your local application database and test database:
```php
    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => '***',
            'password' => '*****',
            'database' => '*****',
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => 'localhost',
            'username' => '***',
            'password' => '*****',
            'database' => '*****',
        ],
```


### Set up MySQL Workbench connection to your VM
This has been tested with MySQL Workbench version 8.0.27.

Beside _MySQL Connections_, click the plus sign button.

Add/modify the following settings:
> ###### _Connection Name_: `Vagrant - CakePHP 4.x`
>
> ###### _Connection Method_: `Standard TCP/IP over SSH`
>
> ###### _SSH Hostname_: `127.0.0.1:2223`
>
> ###### _SSH Username_: `vagrant`
>
> ###### _SSH Password_: Select _Store in Keychain..._ and add the vagrant ssh password (`vagrant`)
>
> ###### _MySQL Hostname_: `127.0.0.1`
>
> ###### _MySQL Server Port_: `3307`
>
> ###### _Username_: `root`
>
> ###### _Password_: Select _Store in Keychain..._ and add the MySQL password (hidden in our Ansible vault, `hhvault`)

Click _Test Connection_; hopefully you get a positive result (MySQL Workbench can be finicky)!

If you have made a successful connection, you should now be able to access the MySQL server from the main _MySQL Connections_ list.

### Check status of and run database migrations
It's possible that you will need to run migrations after importing a copy of the database. You can check the status of and run database migrations with the following commands:
```bash
hhadmin@vagrant:/var/www/hh$ bin/cake migrations status
hhadmin@vagrant:/var/www/hh$ bin/cake migrations migrate
```

### Add local SMTP server settings
Update `config/app_local.php` to include the following `use` statement and settings for your local SMTP server (MailHog):
```php
<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
use Cake\Mailer\Transport\SmtpTransport;

return [
.
.
.
    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'className' => SmtpTransport::class,
            'host' => 'localhost',
            'port' => 1025,
        ],
    ],
```
This SMTP server/email inbox can be accessed from your browser at the VM's IP address at port 8025 (e.g. `http://192.168.56.10:8025`). You can also add a custom URL in your development machine's `/etc/hosts` file if you like:
```bash
192.168.56.10 local.mailbox (access mailbox with http://local.mailbox:8025)
```
Whatever you decide, bookmarking your local mailbox's URL is a good idea.

### Add symlink for DebugKit plugin
You will likely need to add a `webroot` symlink to see the CakePHP DebugKit plugin toolbar. You can add this symlink with the following command:
```bash
hhadmin@vagrant:/var/www/hh$ bin/cake plugin assets symlink
```
