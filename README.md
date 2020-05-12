# persistence-object-identifier-bug-showcase

This Repository contains a setup that can reproduce a bug with the Flow/Doctrine persistence and the persistence_object_identifier.

## How to reproduce
To start the project follow the steps in [DOCKER.md](DOCKER.md).

Access the container via
`make dev-ssh`
and use the command
`flow doctrine:migrate`
to migrate the two migrations Version20200511125038 and Version20200511133443 in DistributionPackages/CRON.Test/Migrations/Mysql/.
They should represent the CREATE TABLE's for the Order and Country tables, and the Foo table.
You can access the Database from outside the container using port
`13306`, user `admin`, password `pass`, db `db`.
Please verify that the tables `cron_test_domain_model_foo`, `cron_test_domain_model_order` and `cron_test_domain_model_country` were created successfully.

Within the container you can execute the command

`flow order:createfakeorders`

If the bug was successfully reproduced, you should see:

`Creating 100 orders...
An exception occurred while executing 'INSERT INTO cron_test_domain_model_order (user, created, billingaddress, deliveryaddress, paymentmethod, paymentdata, status, products, shipping, voucher, customercomment, identifier, id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)' with params ["N;", "2020-05-11 21:16:14", "N;", "N;", null, "a:0:{}", 0, "N;", null, null, null, "4255fea1-133d-4855-b03d-3434658b35e1", null]:
SQLSTATE[HY000]: General error: 1364 Field
'persistence_object_identifier' doesn't have a default value`

Flow/Doctrine should fill the field `persistence_object_identifier` automatically, as is implied in https://flowframework.readthedocs.io/en/5.3/TheDefinitiveGuide/PartIII/Persistence.html#differences-between-flow-and-plain-doctrine
