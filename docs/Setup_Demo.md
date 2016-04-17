Steps to setup demo data for testing purposes
=============================================

```
bin/console doctrine:schema:create --force
```

Collect all feeback with missing appointed dates in future
```
bin/console fit:collect:unappointed-feedback 30
```

Run php consumer
```
bin/console rabbitmq:consumer -m 5 unappointed_feedback -v
```
