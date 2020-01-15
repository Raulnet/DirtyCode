Dirtycode
==========
### Description:
Labs Project for test pattern :
```php
if ($idClient == ?) {
    $yolo = true;
}
```
### Details:
- Symfony:5
- php:7.4
- Lua: 5.3
- sqlite3
- Redis: 5.0.5
- NodeJs: 12.4

### Requirement:
Docker machine

### Install:
- update your '/etc/hosts' file
```shell script
...
127.0.0.1 dirtycode.wip
...
```
- install App
```shell script
$ make install
$ make start
$ make qa
```
- App DirtyCode should be running on [dirtycode.wip](http://dirtycode.wip/)
### Help:
```shell script
$ make
```
```shell script
#-------------------------#  
#      Project            #  
#-------------------------#  
install                        Install and start the project
reset                          Stop and start a fresh install of the project
start                          Start the project
stop                           Stop the project
#-------------------------#  
#      Tools              #  
#-------------------------#  
bash-php                       go to docker app bash
clear                          Remove all the cache, the logs and the built assets
clean                          clean and remove vendor and node_modules
#-------------------------#  
#      Databases          #  
#-------------------------#  
db                             Build DBdatabase and load fixtures
db-reset                       Reset the database and load fixtures
db-diff                        Generate a new doctrine migration
db-migrate                     Migrate a new doctrine migration
db-validate-schema             Validate the doctrine ORM mapping
#-------------------------#  
#      Node               #  
#-------------------------#  
assets                         Run Webpack Encore to compile assets
watch                          Run Webpack Encore in watch mode
#-------------------------#  
#          QA             #  
#-------------------------#  
qa                             launch analys php-cs-fixer && phpunit
tu                             launch phpunit
cs                             analys php-cs-fixer (http://cs.sensiolabs.org)
csfix                          fix php-cs-fixer (http://cs.sensiolabs.org)
```
