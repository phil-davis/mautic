## Setting up an Ubuntu VM to run Mautic for Unit, API and UI tests

This document describes how to make an Ubuntu VM and setup everything needed
in it so that you can run a local Mautic server and run the API and UI tests
locally.

This document includes the necessary packages to support running Apache and MySQL.
But you can choose to use just the PHP dev server setup (not Apache).

### 1. Create an Ubuntu VM with VirtualBox

Note: you could use whatever VM environment you have (ESXi, VMware etc)
but this uses VirtualBox on Windows10 as an example.

Download the Ubuntu installation image,
e.g. ubuntu-16.04.2-desktop-amd64 from https://www.ubuntu.com/download/desktop

Start VirtualBox and create a new VirtualBox VM, select Ubuntu 64 bit with 4GB
memory (if you have enough real memory on your host system) and 20GB storage.
You can choose dynamically allocated or fixed size for the storage.
Let it create the virtual disk image.

In the VirtualBox VM Settings:

General - Advanced - Shared clipboard - choose bidirectional

Network - Bridged Adapter - pick the network device your laptop is using
(e.g. the wired or WiFi as appropriate) if you want to be able to reach it
on the local network that the laptop is on. Otherwise leave it as "NAT" or
sort out having it on "intnet" with a pfSense VM running as a route to the
internet.

Storage - on the empty "DVD" choose the Ubuntu image that you downloaded.

Start the VM and go through the regular Ubuntu install steps:
- click the Install Ubuntu button
- choose Download updates while installing Ubuntu, and continue
- choose Erase disk and install Ubuntu, and Install Now, Continue
- choose where you are (e.g. Kathmandu) and continue
- choose a keyboard (mostly English US is good) and continue
- fill in the "who are you?" page (your name, computer name, user name, password) and continue

It will install, then click to reboot. It will tell you when to remove the
installation ISO so it can boot from the installed disk image. Actually you
will probably find that it has removed it itself.

When the VM boots up, login to Ubuntu. Then go to the VM outer window Devices menu,
Insert Guest Additions CD image...

Allow to run when prompted, and put in the root password.

Get all the standard Ubuntu software up-to-date:

```
sudo apt-get update
sudo apt-get upgrade
sudo apt-get dist-upgrade
```

If the VM is on a LAN that has some IPv6 set up (e.g. for local testing) but the IPv6 does not
work to the public internet, then change settings to prefer IPv4. Edit ``/etc/gai.conf`` and find
the comment "For sites which prefer IPv4 connections change the last line to". Follow the instruction
and make the last "precedence" line be:
```
precedence ::ffff:0:0/96 100
```

Reboot (just for fun, and to get the guest additions running properly with the
shared clipboard)

Now you have a basic working Ubuntu VM. You could keep a copy of this for
other future purposes if you like, by making a separate clone of it in
VirtualBox.

### 2. Install an IDE like PHPstorm

PHPstorm student licenses are available, so you can easily sign up for a licenses
at Jetbrains.

Go to https://www.jetbrains.com/phpstorm/download/#section=linux 
It will download a file like PhpStorm-2017.2.4.tar.gz
```
mv Downloads/PhpStorm-2017.2.4.tar.gz .
tar -xzf PhpStorm-2017.2.4.tar.gz
```

To run it:
```
./PhpStorm-172.4155.41/bin/phpstorm.sh
```

### 3. Install things that are needed underneath to support Mautic

Install the following:

```
sudo apt install git
sudo apt install php
sudo apt install npm
sudo apt install composer
sudo apt install apache2
sudo apt install libapache2-mod-php
sudo apt install php-curl
sudo apt install php-mysql
sudo apt install php-zip
sudo apt install mysql-server
(enter a password for the MySQL root user when asked)
sudo apt install php-xml
sudo apt install php-mcrypt
sudo apt install php-imap
sudo apt install php-xdebug
sudo apt install php-mbstring
sudo apt install php-intl
```

Note: the above will get you PHP7.0. To get PHP 5.6:
```
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php5.6
sudo apt-get install php5.6-curl
sudo apt-get install php5.6-mysel
sudo apt-get install php5.6-zip
sudo apt-get install php5.6-xml
sudo apt-get install php5.6-mcrypt
sudo apt-get install php5.6-imap
sudo apt-get install php5.6-xdebug
sudo apt-get install php5.6-mbstring
sudo apt-get install php5.6-intl
```

And set the system to start Apache and MySQL:

```
sudo systemctl start apache2
sudo systemctl start mysql
sudo systemctl enable apache2
sudo systemctl enable mysql
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Set some commonly-needed ``git`` settings for name, email,
to by default just push the current branch, and to remember
your ``git`` password for an hour:
```
git config --global user.name "My Name"
git config --global user.email "me@somewhere.com"
git config --global push.default simple
git config --global credential.helper cache
git config --global credential.helper 'cache --timeout=3600'
```

### 4. Install Selenium and Chrome to use for testing

Get Google Chrome from:
https://www.google.com/intl/en-US/chrome/browser/

Choose the Linux 64-bit "deb".

Let it "Open with software install".

Alternatively, install Google Chrome from the command line:
```
sudo apt-get install libxss1 libappindicator1 libindicator7
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i google-chrome-stable_current_amd64.deb
```

(see https://askubuntu.com/questions/79280/how-to-install-chrome-browser-properly-via-command-line )

Click the "Install" button and enter the root password.

Install Java:
```
sudo apt-get install default-jre
```

Get the current Selenium jar file from:
http://docs.seleniumhq.org/download/
e.g. At the time of writing it was:
```
selenium-server-standalone-3.5.3.jar
```

In your home dir:
```
mkdir selenium
```
and copy the jar file into there.

Get the chromedriver from:
https://sites.google.com/a/chromium.org/chromedriver/
You will have `chromedriver_linux64.zip` in your downloads folder.
Copy it into the selenium folder. In file explorer you can right-click
the chromedriver zip file and choose "Extract here..."

You will end up with a selenium folder like:

```
total 34600
-rwxr-xr-x 1 phil2 phil2  8909200 अगस्त  30 13:07 chromedriver
-rw-rw-r-- 1 phil2 phil2  4073520 सितम्ब 24 15:29 chromedriver_linux64.zip
-rw-rw-r-- 1 phil2 phil2 22440420 सितम्ब 24 15:23 selenium-server-standalone-3.5.3.jar
```

### 5. Install and Setup Mautic

Setup a MySQL database for Mautic to use:

```
mysql -u root -p
CREATE DATABASE mauticdb;
CREATE USER 'mauticuser'@'localhost' IDENTIFIED BY 'dev123pwd';
GRANT ALL PRIVILEGES ON *.* TO 'mauticuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

On GitHub, go to https://github.com/mautic/mautic and press the "fork" button to
make a forked copy of the repo. Get a clone of the forked Mautic repo.
```
git clone https://github.com/phil-davis/mautic.git
cd mautic
git remote add upstream https://github.com/mautic/mautic.git
composer install
```

``composer`` will pull down all other dependencies that are needed.
It will take some time to run.

If using the PHP dev server (as described in this document) then edit 
``/etc/php/5.6/cli/php.ini`` and set the timezone to something valid, e.g.:
```
; Defines the default timezone used by the date functions
; http://php.net/date.timezone
date.timezone = 'Asia/Kathmandu'
```

If using/testing on PHP 5.6 then you must also set:
```
; Always populate the $HTTP_RAW_POST_DATA variable. PHP's default behavior is
; to disable this feature and it will be removed in a future version.
; If post reading is disabled through enable_post_data_reading,
; $HTTP_RAW_POST_DATA is *NOT* populated.
; http://php.net/always-populate-raw-post-data
always_populate_raw_post_data = -1
```
(see https://github.com/mautic/mautic/pull/1860/files for some detail)

You can also setup a the database that the unit tests will use. These expect a
MySQL user called ``travis`` with no password:
```
mysql -u root -p
CREATE DATABASE mautictest;
CREATE USER 'travis'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON *.* TO 'travis'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Here are some hints on manipulating MySQL users and databases:
```
ALTER USER user IDENTIFIED BY 'auth_string';
DROP USER 'username'@'localhost';
SELECT user FROM mysql.user;
DESCRIBE mysql.user;
SHOW DATABASES;
```

### 6. Startup Mautic and Selenium

To run tests, you need the Mautic server running and Selenium
(which will provide the support to run the chrome browser and
automagically drive it with the tests).

In a separate terminal, start Selenium:

```
cd selenium
java -jar selenium-server-standalone-3.5.3.jar -port 4445
```

In another terminal, start the Mautic PHP development server.
You can make a script like:
```
#!/bin/bash
cd mautic
export SRV_HOST_NAME=localhost
export SRV_HOST_URL=""
export SRV_HOST_PORT=8080
export BROWSER=chrome
bash tests/start_php_dev_server.sh
```

Note: The first time go to http://localhost:8080 and try to login manually.
It will take you through 3 pages of setup:

Mautic Installation - Database Setup page:

MySQL PDO (Recommended)
Database Host: localhost
Database Port: 3306
Database Name: mauticdb
Database Table Prefix: -
Database Username: mauticuser
Database Password: dev123pwd
Backup existing tables? No

Mautic Installation - Administrative User :

Admin Username: mauticadmin
Admin Password: admin123
First name: Mautic
Last name: Admin
E-mail address: me@somewhere.com

Mautic Installation - Email Configuration 

Take the default settings

### 7. Run the Behat UI tests

```
bash tests/start_ui_tests.sh
```

You should see it start chrome and automagically drive the browser and do
all the browser actions to perform the tests.

You can run tests for just a single feature by specifying the feature file:
```
bash tests/start_ui_tests.sh --feature tests/ui/features/basic/navsidebar.feature
```

Or a particular scenario, by specifying the scenario line number in the feature file:
```
bash tests/start_ui_tests.sh --feature tests/ui/features/basic/navsidebar.feature:46
```

You can run tests with a particular tag by specifying the tag:
```
bash tests/start_ui_tests.sh --tags skip
```

### 7. Run the Unit tests

Make sure that the ``mautictest`` database and ``travis`` user have been setup.
Then run the unit tests from the ``mautic`` git repo folder:
```
bin/phpunit --bootstrap vendor/autoload.php --configuration app/phpunit.xml.dist
```
