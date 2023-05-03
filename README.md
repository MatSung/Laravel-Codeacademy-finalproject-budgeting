# Laravel-Codeacademy-finalproject-budgeting

# Readme file

## Dev setup

Requirements

- Docker
- npm

1. Pull repository
2. In `./src` duplicate `.env.example` and rename it to `.env`.
3. Fill appropriate `.env` values.
4. Run `docker compose up` in the project directory.
5. Inside the php docker container run
    - `composer install` to install dependencies
    - `php artisan migrate` to run migrations (you may optionally populate dummy data by adding `--seed` to the command)
    - `php artisan key:generate` to generate laravel key
6. In `./src` run `npm i` to install dependencies, and `npm run dev` to start dev server.
7. The project should now be reachable through `localhost`
8. To run feature/unit tests run `php artisan test`