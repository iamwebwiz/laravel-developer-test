# 64 Robots Laravel Developer Test

## Goal

Please spend no more than 5 hours on this task.  If you cannot complete the entire task in less than 5 hours, please commit what you are able to finish within that time frame. This is an API test only. No frontend component.

## Delivery

Please push your code to a public repository on Github and either PM it to Rob on Slack or email to rob@64robots.com

## Task Description

Please create a new Laravel 8 application that fulfills the following functionality.

**Please note: There is no frontend component to this. These are API routes only. Please create tests for all endpoints to show they are functioning as required by the test.**

1. A user can add people
2. A user can connect people together as families
3. A user can see a family tree to any particular Person in the application 
4. Each time a new person is added, a new Notification should be dispatched to a Slack webhook. Please PM Rob on Slack for the webhook - use Laravel Notifications and this Slack notification package: https://github.com/laravel/slack-notification-channel

## Task Requirements

1. Please use Laravel 8
2. Everything should be done the "Laravel way" and following our coding standards here: https://64robots.notion.site/Backend-f19f189aa0964f4eb5d416785a72ac04
3. Please test as you would in your own applications. PHPUnit or Pest are fine. 

## Task Details

For the sake of the test, you will be evaluated solely on two items:

1. Your PHP code
2. Your tests

The most important part is that we should be able to quickly look at and understand how you write code and how it jives with our coding standards. 

## Setup
- Clone the repository and change current directory to the cloned directory

Copy the contents of `.env.example` to `.env`
```shell
cp .env.example .env
```

Install dependencies
```shell
composer install
```

Generate application key
```shell
php artisan key:generate
```

Update the value of the environment variable `SLACK_INCOMING_WEBHOOK_URI` to actual Slack webhook URL

Update the database configurations to suit your environment
```shell
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Serve the application
```shell
php artisan serve
```

Testing out the endpoints can be done using [Postman](https://postman.com).

## Automated Testing
Tests are written using [PestPHP](https://pestphp.com).

Run the following on your terminal to run the automated tests
```shell
composer test
```
