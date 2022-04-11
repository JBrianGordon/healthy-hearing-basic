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

### Set up local development database
Update `config/app_local.php` to include the username, password, and database name for your local application database:
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

### Check status of and run database migrations
It's possible that you will need to run migrations after importing a copy of the database. You can check the status of and run database migrations with the following commands:
```bash
hhadmin@vagrant:/var/www/hh$ bin/cake migrations status
hhadmin@vagrant:/var/www/hh$ bin/cake migrations migrate
```
