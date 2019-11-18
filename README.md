# Rss reader and popular word remover

Rss reader and popular word remover is application that is built on **Laravel** that takes Rss feed and removes top 50 most popular words in english from it

-   Rss feed: https://www.theregister.co.uk/software/headlines.atom
-   Most popular word list: https://en.wikipedia.org/wiki/Most_common_words_in_English

## Preparation

You will need to set up the package manager **[composer](https://getcomposer.org/download/)** and set up laravel on it.

```bash
composer global require laravel/installer
```

As well you will need **[npm](https://nodejs.org/en/)** package manager and **MySQL 5.6+**

## Project setup

First you will need to clone the project locally

```bash
git clone https://github.com/RobertsKemps/RSS_reader.git
```

After cloning you will need cd into the project directory and run these commands in sequence

```bash
composer install
composer update
npm install
cp .env.example .env
php artisan key:generate
```

When the commands have been ran you will need to set up new database and edit **.env** file and set
there your new database name

```bash
DB_DATABASE=example_name_of_db
```

After creating database you will need to clear configuration cache and run migration

```bash
php artisan config:cache
php artisan migrate
```

When this is done open two new terminal or cmd windows to run these commands

```bash
php artisan serve
npm run watch
```

Now open up browser and type in 
```
http://127.0.0.1:8000/
```
And you should be up and running