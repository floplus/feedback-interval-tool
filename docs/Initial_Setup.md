# Setup

Goal symfony3 vagrant box with homestead.

See following URLs for further explanation on the setup steps:

- http://symfony.com/doc/current/cookbook/workflow/homestead.html
- https://laravel.com/docs/5.2/homestead#installation-and-setup

##Basic steps

Setup Symfony3 project:

```
symfony new fit
```

Add Homestead to laravel:

```
composer -vvv require laravel/homestead --dev
```

Initialize Homestead:

```
php vendor/bin/homestead make
```

Configure Homestead.yaml.
