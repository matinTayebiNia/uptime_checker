# uptime checker

-----------------

## installation

after download project, run this command in terminal.

```
compoer install 
```
 create database and migrate the migrations.
```
php artisan init:db  
php artisan migrate 
```
after that run this command for generate jwt secret key.
```
php artisan jwt:secret
```
and then run the project 

```
php artisan serv
```
----------

## run schedule system 
if you want to run uptime website checker,
run this commands in terminal.
```
php artisan schedule:work
php artisan queue:work 
```
uptime checker is checking website hourly

----------

if you want to get postman collection download
`uptimeCollections.json`
