### Antes de comenzar

Para compilar los assets del proyecto es necesario contar con lo siguiente:

1. Un servidor Apache / Nginx o similar.
2. [NPM](https://www.npmjs.com/)
3. Servidor MySQL
4. Redis

### Instrucciones 

Una vez clonado el proyecto es necesario cambiar el nombre al archivo **.env.example** a **.env**.

Lineas a tener en cuenta:

``` 
DB_CONNECTION=mysql                     # Modificar conexión MySQL según corresponda
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chat
DB_USERNAME=root
DB_PASSWORD=root

``` 

Luego de modificar este archivo, ejecutar las siguientes lineas de código

```
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install
npm run production

laravel-echo-server start                                                                                            
redis-server

php artisan serve
```