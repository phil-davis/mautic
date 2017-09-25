## Travis CI on Mautic

### 1. Overview

Basic CI is done on Travis and is being expanded to run UI tests as well as unit tests.

### 2. mySQL Database and Unit Tests

The mySQL database is created by an explicit ``before_install`` command in the ``.travis.yml``:
```
mysql -e 'CREATE DATABASE mautictest;'
```

Some unit tests make use of this database. The database user ``travis`` with no password is created by default by Travis-CI:
https://docs.travis-ci.com/user/database-setup/#MySQL

So that is the "majic" that allows those unit tests to work.

### 3. UI Tests and Mautic setup

ToDo
