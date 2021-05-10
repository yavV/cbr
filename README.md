# cbr

Реализован вывод курса валюты на выбранную дату с кешированием результатов.

1-запустить docker контейнеры:
    $ docker-compose build
    $ docker-compose up
    
2-в конейнере (docker exec -ti php-fpm-cbr /bin/sh)  
    -выполнить миграцию
        $ php bin/console doctrine:migrations:execute --up DoctrineMigrations\\Version20120507115234
    -выполнить команду
        $ php bin/console app:currencies:import
        
3-в браузере открыть страницу по адресу http://172.210.1.12/