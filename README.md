# Electronic Student Program Advisor 

## Installation

- Download `vendors` and create `.env` file.
    ```bash
        composer install
        cp .env.example .env
        php artisan key:generate
    ```

- Create database eg: `espa`
- Edit `.env` file:
    ```bash
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=espa
        DB_USERNAME=root
        DB_PASSWORD=
    ```

- Migrating sample data:
    ```bash
        php artisan migrate --seed
    ```

- Ready to use:
    ```bash
        php artisan serve
    ```
