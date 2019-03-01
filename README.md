# BileMo API [![Codacy Badge](https://api.codacy.com/project/badge/Grade/f489483284e5493ea3800e8b51b2d5db)](https://www.codacy.com/app/amelie.haladjian/BileMoApi?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Dzov/BileMoApi/&amp;utm_campaign=Badge_Grade)

A web service exposing an API allowing BileMo's clients to access BileMo's mobile phone catalog. 
The client will also be able to access his customer list, see a customer's detail information, add a customer and delete a customer.

## Getting Started

### Requirements

PHP 7.2

MySQL 5.7.8 

### Installation

Install the project on your computer.
```
git clone git@github.com:Dzov/BileMoApi.git
```

Install the dependencies using composer.
```
composer install
``` 

#### JWT
Set up JWT by executing the following commands 
```
mkdir -p config/jwt # For Symfony3+, no need of the -p option
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

Copy the `.env` file at the root of the project and rename it to `.env.local`.

In the `.env.local` file, replace the value of the variable `JWT_PASSPHRASE` with your passphrase.

For more information on JWT's set up, please checkout the [LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation) documentation.

#### Database and fixtures
In the `.env.local` file, adapt the `DATABASE_URL` variable by replacing the parameters `db_user`, `db_password` and `db_name` with your own configuration.

Create a new database by executing the command `php bin/console doctrine:database:create`. 
Then, execute the command `php bin/console doctrine:schema:update --force` in order to create the different tables based on the entity mapping. 

If your MySQL version is inferior to 5.7.8, run the command `php bin/console doctrine:migrations:migrate` in order to create the tables.

Once your database has been properly set up, run the following command in order to import the data fixtures : `php bin/console doctrine:fixtures:load
`

## Resources 
The API documentation can be accessed through the route `api/doc`

Diagrams can be found here : [UML Diagrams](https://github.com/Dzov/BileMoApi/tree/master/resources)

Code quality has been analyzed with [Codacy](https://app.codacy.com/project/amelie.haladjian/BileMoApi/dashboard)

The different issues can be found on [Github](https://github.com/Dzov/BileMoApi/issues?q=is%3Aissue+is%3Aclosed)

## Versioning

I used [GitHub](https://github.com/Dzov/BileMoApi) for versioning. 

## Authors

**Amélie-Dzovinar Haladjian** 

## Acknowledgments

Many thanks to my mentor Sébastien Duplessy
