# Nova Modules v1.0.0 by CmDev
A Laravel Nova Tool helping modularize your application. Often happens that our applications grow a lot and we need a 
lot of models, resources, lenses, actions, migrations etc..
With this package we can divide our nova parts in little chunks (or modules).

## Let's start

To start you you just need to install the composer package
```php
    composer require cmdev/nova-modules
```

In our composer.json we have to add

```json
    "autoload": {
            "psr-4": {
                ... our content
                "NovaModules\\": "nova-modules/"
            }
        },
```

"nova-modules" and "NovaModules" are the default folder and default namespace for the package, but you can change it 
publishing the config file with the command:

```php
    php artisan vendor:publish --tag=nova-modules
```

and changing it on:

```php
    'path' => 'nova-modules',
    'namespace' => 'NovaModules'
```

now we just need to type the command:

```php
    php artisan nova-modules:make {name of our module}
```

and our module will be autocreated with all his subfolders.

## Directory Structure

So we'll have a structure like this :

* NovaModules
  * TestModule
    * Actions
    * Assets
        * js
            * Fields
            * Filters
            * Cards
            * ResourceTools
            * Tools
        * sass
        * views
    * Cards
    * Dashboards
    * Database
        * migrations
        * seeds
    * Fields
    * Filters
    * Lenses
    * Metrics
    * Models
    * Providers
    * Resources
    * ResourcesTools
    * Routes
    * Tools
    
## Commands

NovaModules has an artisan command for almost everything we need:

**For creating new action**
```php
php artisan nova-modules:action {action-name} {module-name}
```
***
**For creating new card**
######note: it will create a folder in our assets with the Vue file so we can integrate it in our main JS file
```php
php artisan nova-modules:card {card-name} {module-name}
```
***
**For creating new custom filter**
######note: this one as well will create a folder in our assets with the Vue file.
```php    
php artisan nova-modules:custom-filter {custom-filter-name} {module-name}
```
***
**For creating new dasboard**
```php
php artisan nova-modules:dashboard {dashboard-name} {module-name}
```
***
**For creating a new Field**
######note: this one will create the 3 different Vue files for each view in our nova application.
```php
php artisan nova-modules:field {field-name} {module-name}
```
***
**For creating a new filter**
```php
php artisan nova-modules:filter {filter-name} {module-name}
```
***
**For creating a new lens**
```php
php artisan nova-modules:lens {lens-name} {module-name}
```
***
**For creating a migration**
```php
php artisan nova-modules:migration {migration-name} {module-name}
```
***
**For creating a new model**
```php    
php artisan nova-modules:model {model-name} {module-name}
```
**For creating a new partition metric**
```php
php artisan nova-modules:partition {partition-name} {module-name}
```
***
**If we need to integrate another service provider in our module**
######note: you need to register it in your main module service provider. 
```php    
php artisan nova-modules:provider {provider-name} {module-name}
```
***
**For creating a new resource**
######note: resources are all auto loaded in your main application and they are grouped by default with the name of your module
```php
php artisan nova-modules:resource {resource-name} {module-name}
```
***
**For creating a new resource-tool**
######note: this will create as weel Vue file inside your assets folder
```php
php artisan nova-modules:resource-tool {resource-tool-name} {module-name}
```
***
**For creating a new tool connected with your module**
######note: this will create as well Vue file inside your assets folder. I don't know if maybe in a future release i will add a system for autoloading
```php
php artisan nova-modules:tool {tool-name} {module-name}
```
***
**For creating a new trend metric**
```php
php artisan nova-modules:trend {trend-name} {module-name}
```
***
**For creating a  new value metric**
```php    
php artisan nova-modules:value {value-name} {module-name}
```

##Thanks
I would like to thank @nWidart for giving me the idea about modular laravel application with his great package
[nwidart/laravel-modules](https://github.com/nWidart/laravel-modules)

