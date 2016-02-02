# Sainsbury’s Software Engineering Test #

To show the ability to consume a web page, process some data and present it via a console scraper application.
URL: http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html

## Pre-Req ##

* PHP v5.6
* Composer

## Installation ##

1. Clone the project.
2. `composer install` to get dependencies

## Usage ##

run in terminal `php scraper sainsburys:items` to scrape all the items from the software engineer test url.

## Unit Testing ##

run in terminal `vendor/bin/phpunit php-app/unit-test/`