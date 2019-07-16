[![Build Status](https://travis-ci.org/Raywire/book-reviews-api.svg?branch=develop)](https://travis-ci.org/Raywire/book-reviews-api)
[![Maintainability](https://api.codeclimate.com/v1/badges/2797b4b3be08cf5585d7/maintainability)](https://codeclimate.com/github/Raywire/book-reviews-api/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/2797b4b3be08cf5585d7/test_coverage)](https://codeclimate.com/github/Raywire/book-reviews-api/test_coverage)

## Title
Books Review

## Description
 Users will be able to add new books, update books and delete books. Users will also be able to view a list of all books and rate a book. Then an average rating will be computed based on the ratings on a particular book

## Running the API
It's very simple to get the API up and running. First, create the database (and database user if necessary) and add them to the .env file.

```env
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_password
```

Then install, migrate, seed, and run the server:

```php
composer install
php artisan migrate
php artisan db:seed
php artisan serve
```

## Running the Tests
```php
composer test
```

## API Documentation
View all endpoints on [API Docs](https://documenter.getpostman.com/view/6831940/SVSKL8v4?version=latest).

## Heroku Link
[Hosted Here](https://book-review-laravel.herokuapp.com/)

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
