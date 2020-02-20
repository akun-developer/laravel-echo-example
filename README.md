INSTALLATION
============
1. install redis
2. npm install -g laravel-echo-server
3. composer require predis/predis
4. laravel-echo-server init
5. migrate db

SETUP REALTIME
==============
1. create json response / api
2. create event | php artisan make:event ExampleEvent
3. set event on observer | php artisan make:observer ExampleObserver

START PROGRAM
=============
1. laravel-echo-server start / use pm2 (npm install pm2 -g)
2. php artisan queue:work / use supervisor
