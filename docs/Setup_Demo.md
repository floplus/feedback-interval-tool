Steps to setup demo data for testing purposes
=============================================

```
bin/console doctrine:schema:create --force
bin/console fos:user:create --super-admin admin admin@fit.app secret
```
