# LaravelOLXNotifier

Цей проєкт створено для відслідковування оновлення цін в оголошенні OLX через Email-підписку.
- Створено за допомогою Laravel
- Unit Tests
- Контейнеризація за допомогою Docker, використовуючи Laravel Sail
- Swagger-документація

Сервіс кожну годину проходить по всім оголошенням, на які було здійснено підписку, за допомогою планувальника Laravel, і відправляє користувачам повідомлення на пошту про зміну ціни.

## Requirements

Щоб запустити проєкт, вам знадобиться Docker Desktop

- Docker Desktop: [Download Docker](https://www.docker.com/products/docker-desktop)
- Або при бажанні можна запустити локально, без Docker контейнеру

## Getting Started (Docker)

1. Зклонуйте репозиторій:
   ```bash
   git clone https://github.com/yourusername/your-laravel-project.git
2. Встановіть залежності за допомогою Composer
    ```bash
   composer install
3. Створіть .env файл
    ```
    cp .env.example .env
    php artisan key:generate
    
4. Сконфігуруйте підключення до бази даних, а також SMTP-сервер для відправки повідомлення на пошту
    ```
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=test
    DB_USERNAME=sail
    DB_PASSWORD=password
    
    ```
        MAIL_MAILER=smtp
        MAIL_HOST=sandbox.smtp.mailtrap.io
        MAIL_PORT=2525
        MAIL_USERNAME=25e6fb33377d32
        MAIL_PASSWORD=9e29747073ca41
        MAIL_ENCRYPTION=null
        MAIL_FROM_ADDRESS="hello@example.com"
        MAIL_FROM_NAME="${APP_NAME}"
5. Сконфігуруйте Laravel Sail
    ```
    php artisan sail:install
6. Запустіть Docker контейнер
    ```
    ./vendor/bin/sail up
7. Запустіть міграції
    ```
    ./vendor/bin/sail php artisan migrate
8. Запустіть Database seeders
    ```
    ./vendor/bin/sail php artisan db:seed
9. Запустіть Laravel Scheduler, для регулярної перевірки цін. Кожне оголошення додається у Laravel Job Queue, для виконання у фоновому режимі, щоб уникнути блокування основного потоку виконання.
    ```
    ./vendor/bin/sail php artisan schedule:work
10. Відправте запит на підписку
    ```
    curl -X 'POST' \
      'http://localhost/api/subscribe' \
      -H 'accept: application/json' \
      -H 'Content-Type: application/json' \
      -H 'X-CSRF-TOKEN: ' \
      -d '{
      "email": "test@gmail.com",
      "url": "https://www.olx.ua/d/uk/obyavlenie/povorotnyy-kulak-kamaz-4310-43114-43118-v-sbore-IDU61PK.html?reason=hp%7Cpromoted"
    }'
11. Підтвердіть електронну адресу, і чекайте повідомлення :)
    
## Getting Started (Local)
1. Виконайте все з розділу з Docker до 5 пункту
2. Виконайте міграції
   ```
   php artisan migrate
3. Виконайте сідери
   ```
   php artisan db:seed
4. Запустіть планувальник
   ```
   php artisan schedule:work
5. Відправте запит на підписку
## API Endpoints

| Endpoint             | Description                        |
|----------------------|------------------------------------|
| `/api/subscribe`     | Підписка на оголошення             |
| `/api/documentation` | Swagger-документація               |

## Запуск Unit-тестів
   ```
   ./vendor/bin/sail php artisan test --testsuite Feature
   php artisan test --testsuite Feature
