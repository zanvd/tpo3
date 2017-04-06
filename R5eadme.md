# Homestead installation
[Homestead Reference]https://laravel.com/docs/5.4/homestead

## Clone TPO repo:
[tpo3](https://github.com/zanvd/tpo3)

## Install:
* Virtualbox (or VmWare - will have to modify configuration files on your own)
* Vagrant 1.9.0 (has to be this version as 1.9.3 doesn't work)

## Install Homestead:
1. clone repo: [homestead](https://github.com/laravel/homestead.git)
2. cd into folder
3. checkout to latest stable (see [Releases](https://github.com/laravel/homestead/releases))
4. run init script (Linux: init.sh, Windows: init.bat)
5. copy Homestead.yaml from TPO repo (virt-conf/Homestead.yaml) to root
6. _(optional) Modify configuration to suite your needs._
7. copy .env-dev from TPO repo (virt-conf/.evn-dev) to root and rename to .env

## Post installation:
1. start virtual machine `vagrant up`
2. ssh into machine `vagrant ssh`
3. update machine with `sudo apt-get update` and `upgrade`.
5. run `composer install`
6. check on URL: [https://patronaza.si](https://patronaza.si)
