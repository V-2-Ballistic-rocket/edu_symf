![Диаграмма без названия drawio](https://github.com/V-2-Ballistic-rocket/edu_symf/assets/91071360/4c1d9a55-dfee-4f2e-959e-c734d3e2d143)


--------------------- Оглавление ---------------------------------------------------

    1. Установка и запуск

    2. Использование
        2.1. Регистрация нового пользователя
        2.2. Подтверждение регистрации через почту
        2.3. Вывод всех пользователей в json формате

    3. Стек используемых технологий

    4. Послесловие


------------------ 1. УСТАНОВКА И ЗАПУСК -------------------------------------------

    Вся разработка велась на Windows WSL Ubuntu с использованием Docker Desktop.
    Как запустить и протестировать проект на других платформах - ¯\_(ツ)_/¯

    Для установки и запуска можно использовать команду:
        make install-n-start
        в конце установки скрипт попросит вас нажать
        enter для выполнения инициализирующей миграции в бд

    что при этом будет сделано:
        - запустятся докер-контейнеры
        - установятся пакеты composer
        - запустится symfony server
    после этого проект можно спокойно использовать

    Для просто установки можно использовать:
        make install

    Для просто запуска проекта можно использовать
        make start

    Настройки подключения к бд:
        База данных:   PostgreSql
        Хост:          localhost
        Название бд:   app
        Логин:         postgres
        Пароль:        postgres


------------------ 2. ИСПОЛЬЗОВАНИЕ ------------------------------------------------

    2.1. Регистрация нового пользователя

        Запрос на регистрацию можно отправить из консоли:
            curl --location 'http://localhost/users' \
            --form 'login="login"' \
            --form 'password="password"' \
            --form 'email="email@email.com"' \
            --form 'phone_number="88001111111"' \
            --form 'first_name="firstname"' \
            --form 'last_name="lastName"' \
            --form 'age="20"' \
            --form 'path_to_avatar="path"' \
            --form 'country="country"' \
            --form 'city="city"' \
            --form 'street="street"' \
            --form 'house_number="14a"'
        Выполнится метод контроллера
        edu_symf/src/Requester/Controller/UserController.php createUser()

        Или тоже самое сделать через постман:
           Метод POST, адрес http://localhost/users
                body->form-data:
                  "login" => "some login"
                  "password" => "some password"
                  "email" => "email@email.com"
                  "phone_number" => "88001111111"
                  "first_name" => "firstname"
                  "last_name" => "lastName"
                  "age" => "20"
                  "path_to_avatar" => "path"
                  "country" => "country"
                  "city" => "city"
                  "street" => "street"
                  "house_number" => "123a"
        Выполнится метод контроллера
        edu_symf/src/Requester/Controller/UserController.php createUser()


        На результат можно посмотреть в самой бд,
        там должен появиться новый неподтвержденный аккаунт.


    2.2. Подтверждение регистрации через почту

        Для подтверждения регистрации мною был выбран mailhog

        Подтвердить регистрацию через почту
        Письмо со ссылкой будет лежать по адресу:
            http://localhost:8025/

        Ссылка будет такого вида:
            http://localhost:80/users/registration/confirm/{$token}

        Она выполнит edu_symf/src/Requester/Controller/UserController.php confirmRegistration()

        Результат будет в бд


    2.3. Вывод всех пользователей в json формате:

        через консоль:
            curl --location 'http://localhost/users'
        через постман:
            метод GET, аддрес: http://localhost/users


------------------ 3. СТЕК ТЕХНОЛОГИЙ ----------------------------------------------

    - docker
    - php 8.2
    - symfony 6.3
    - docktrine 2.17
    - postgreSql 15
    - mailhog
    - phpUnit 9.5

    Более подробно можно посмотреть в edu_symf/composer.json


------------------ 4. ПОСЛЕСЛОВИЕ --------------------------------------------------

    В разработке старался придерживаться DDD
    Всю бизнес-логику изолировал в папке edu_symf/src/DomainLayer/

    TDD в этом проекте я не придерживался,
    поэтому не все тесты на момент написания выполняются без ошибок ¯\_(ツ)_/¯

    Полностью рабочих тестов пока нет, но вы держитесь!
    Тесты обязательно будут, но позже!

    Запустить тесты можно войдя в контейнер:
        docker exec -it php-fpm-sr /bin/sh
    И вводя там:
        php bin/phpunit
    Для выхода из контейнера пропишите:
        exit

    Спасибо за внимание! :-D
