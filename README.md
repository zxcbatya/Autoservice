# Автосервис

Веб-приложение для автосервиса на **Laravel 10** + **PostgreSQL** + **Docker**: публичный лендинг, админ-панель (AdminLTE) и модуль учёта **СТО** (заказы, мастера, клиенты, расходы, зарплаты, запчасти, отчёты).

## Документация

**[Полная документация проекта → docs/DOCUMENTATION.md](docs/DOCUMENTATION.md)**

В ней описаны: архитектура, установка, все маршруты, база данных, роли, API СТО, Telegram-заявки, сидеры, команды Make и расширение системы.

## Quickstart

1. [Install Docker Desktop](https://docs.docker.com/install/)
2. Скопировать `.env`: `cp .env.example .env` (или `make cp-env`)
3. Убедиться, что `PROJECT_NAME` в `.env` совпадает с именем в `docker/nginx/default.conf` (`fastcgi_pass`, формула `<PROJECT_NAME>-php`)

При изменении `PROJECT_NAME` в `.env` измените имя контейнера PHP в `docker/nginx/default.conf` (строка 48, `fastcgi_pass`).

### Локальный запуск (без Traefik)

Сайт: **http://localhost:8080** (порт `DOCKER_HTTP_PORT`).

```bash
docker build -t autoservice/php:8.3.12-fpm-bullseye --build-arg PHP_BASE_IMAGE_VERSION=8.3.12-fpm-bullseye ./docker/php/
docker compose up -d
docker compose exec --user=www-data php php artisan migrate --force
docker compose exec --user=www-data php php artisan db:seed --force
```

Полная установка (Linux/macOS):

```bash
make install-dev
```

## Демо-аккаунты

| Email | Пароль | Роль |
|-------|--------|------|
| admin@example.com | admin | Администратор (полный доступ) |
| manager@example.com | manager | Менеджер (модуль СТО) |

## Основные разделы админки

| URL | Назначение |
|-----|------------|
| `/login` | Вход |
| `/admin` | Дашборд |
| `/admin/sto/orders` | Заказы СТО |
| `/admin/service` | Услуги на сайте |
| `/admin/reviews` | Отзывы |

Меню настраивается в `config/admin-menu.php`.

## Make-команды

| Команда | Описание |
|---------|----------|
| `make install-dev` | Полная dev-установка |
| `make up` / `make down` | Docker |
| `make env` | Shell в PHP-контейнере |
| `make migrate` | Миграции |
| `make artisan-seed` | Сиды |
| `make yarn-prod` | Сборка фронтенда |

Подробный список — в [документации](docs/DOCUMENTATION.md#команды-разработки).

## Yarn / Vite

```bash
make yarn-install
make yarn-dev      # или make yarn-watch
make yarn-prod
```

## Стек

- PHP 8.3, Laravel 10, PostgreSQL 17
- AdminLTE 3, Spatie Permission, Vite
- Docker Compose (`docker-compose.v2.yml`)
