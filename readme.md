## Spartan Weight Lifting Log (http://spartan-weight-lifting-log.herokuapp.com/login)

## Overview
* Rest API for tracking workouts 
    * User authentication with JSON Web Tokens
    * REST principles followed (Documentation coming soon)
        * Appropriate HTTP status codes and responses
        * Paginated results 
        * Sorting 
        * Expansion
        * Filtering 
* Frontend (mainly intended to demonstrate that data is synchronized correctly)
    * Responsive and mobile-ready user interface (Bootstrap)
    * Elixer/Gulp asset pipeline
    * Interactive Graph (ChartJS)
    * Rest Timers (JQuery)

## Installation

    git clone the repository
    composer install
    vagrant up

## The following libraries were used:
* francescomalatesta's jwt api boilerplate 
    * [laravel-api-boilerplate-jwt](https://github.com/francescomalatesta/laravel-api-boilerplate-jwt)
* JWT-Auth - [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
* Dingo API - [dingo/api](https://github.com/dingo/api)
* Laravel-CORS [barryvdh/laravel-cors](http://github.com/barryvdh/laravel-cors)
