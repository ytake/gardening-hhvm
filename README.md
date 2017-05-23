# Gardening

pre-packaged Vagrant box that provides you a wonderful development environment  
without requiring you to install HHVM, a web server(Nginx),  
and any other server software on your local machine.

php7 box:
```json
"require-dev": {
  "ytake/gardening-hhvm": "~0.0"
}
```

(supported for virtualbox only)

## Included Software
 - Ubuntu16.04
 - Git
 - HHVM
 - Nginx
 - MySQL
 - Sqlite3
 - PostgreSQL
 - Composer
 - Node.js (Gulp, webpack)
 - Redis
 - Memcached

## MySQL and PostgreSQL
 - user: gardening
 - password: 00:secreT,@

## Install Gardening Box

### case 1, your "home" directory
```bash
$ cd ~
$ git clone https://github.com/ytake/gardening-hhvm.git gardening-hhvm
```

setup.sh(Windows .bat) command from the gardening-hhvm directory to create the vagrant.yaml configuration file.(~/.gardening-hhvm hidden directory)

```bash
$ bash setup.sh
```

### case2, Per Project Installation

To install gardening-hhvm directly into your project, require it using Composer:

```bash
$ composer require ytake/gardening-hhvm --dev
```

use the make command to generate the Vagrantfile and vagrant.yaml(or vagrant.json) file in your project root.

```bash
$ ./vendor/bin/gardening-hhvm gardening-hhvm:setup
```

gardening.json:
```bash
$ ./vendor/bin/gardening-hhvm gardening-hhvm:setup --filetype=json
```

## Configuration

### Configuring Shared Folders

```yaml
folders:
    - map: /path/to/yourProject
      to: /home/vagrant/yourProjectName
```

many shared folders:
```yaml
folders:
    - map: /path/to/yourProject
      to: /home/vagrant/yourProjectName
    - map: /path/to/yourSecondfProject
      to: /home/vagrant/yourSecondProjectName
```

### Configuring Sites
```yaml
sites:
    - map: gardening.app
      to: /home/vagrant/yourProject/public
```

many sites:
```yaml
sites:
    - map: gardening.app
      to: /home/vagrant/yourProject/public
    - map: gardening.second.app
      to: /home/vagrant/yourSecondProject/public
```

### Ports

By default, the following ports are forwarded to your gardening environment:

 - SSH: 2222 → Forwards To 22
 - HTTP: 8000 → Forwards To 80
 - HTTPS: 44300 → Forwards To 443
 - MySQL: 33060 → Forwards To 3306
 - Postgres: 54320 → Forwards To 5432

Forwarding Additional Ports:
```yaml
ports:
    - send: 7777
      to: 777
```
