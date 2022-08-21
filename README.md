# Bilemo
Projet 7 of OpenClassrooms

## Context
BileMo is a company offering a whole selection of high-end mobile phones.

You are in charge of the development of the BileMo company's mobile phone showcase. BileMo's business model is not to sell its products directly on the website, but to provide all the platforms that want access to the catalog via an API (Application Programming Interface). It is therefore a sale exclusively in B2B (business to business).

You will need to expose a number of APIs for applications on other web platforms to perform operations.

## About the api
[![SymfonyInsight](https://insight.symfony.com/projects/39942026-0c17-43ae-9bf0-92a3d5ad61a3/big.svg)](https://insight.symfony.com/projects/39942026-0c17-43ae-9bf0-92a3d5ad61a3)

![alt text](https://img.shields.io/badge/php-8.1-blue) ![alt text](https://img.shields.io/badge/Symfony-6.1.3-black) ![alt text](https://img.shields.io/badge/HateoasBundle-2.4.0-green) ![alt text](https://img.shields.io/badge/LexikJWTAuthenticationBundle-2.16-green)


## Getting started
Install the dependencies
```sh
composer install
```
Create you own database "bilemo" and edit the .env file.
Update your database schema 
```bash
php bin/console doctrine:migrations:migrate
```

Install the fixtures 
```bash
php bin/console doctrine:fixtures:load
```


### Importants informations
 You can access to the API documentation at /api/doc
