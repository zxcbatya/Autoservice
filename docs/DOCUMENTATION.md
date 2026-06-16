# Документация проекта «Автосервис»

Полное описание веб-приложения для автосервиса: публичный сайт, админ-панель и модуль учёта СТО (заказы, мастера, финансы).

---

## Содержание

1. [Обзор](#обзор)
2. [Технологический стек](#технологический-стек)
3. [Архитектура](#архитектура)
4. [Структура проекта](#структура-проекта)
5. [Установка и запуск](#установка-и-запуск)
6. [Переменные окружения](#переменные-окружения)
7. [Маршрутизация](#маршрутизация)
8. [Публичный сайт](#публичный-сайт)
9. [Админ-панель](#админ-панель)
10. [Модуль СТО (учёт автосервиса)](#модуль-сто-учёт-автосервиса)
11. [Backend-панель (отдельный домен)](#backend-панель-отдельный-домен)
12. [База данных](#база-данных)
13. [Аутентификация и права доступа](#аутентификация-и-права-доступа)
14. [JSON API модуля СТО](#json-api-модуля-сто)
15. [Сервисный слой](#сервисный-слой)
16. [Изображения сайта](#изображения-сайта)
17. [Уведомления Telegram](#уведомления-telegram)
18. [Сидеры и демо-аккаунты](#сидеры-и-демо-аккаунты)
19. [Сборка фронтенда](#сборка-фронтенда)
20. [Меню админ-панели](#меню-админ-панели)
21. [Команды разработки](#команды-разработки)
22. [Расширение проекта](#расширение-проекта)

---

## Обзор

Проект — монолитное Laravel-приложение с тремя логическими зонами:

| Зона | Назначение | Доступ |
|------|------------|--------|
| **Публичный сайт** | Лендинг автосервиса: услуги, отзывы, заявка, sitemap | Без авторизации |
| **Админ-панель** (`/admin/*`) | Управление контентом и модулем СТО | `admin`, `manager`, `is_admin` |
| **Backend** (поддомен `ADMIN_DOMAIN`) | CRUD пользователей и страниц (legacy AdminLTE) | Роль `admin` + permission `use-backend-panel` |

Основной бизнес-модуль — **СТО** (станция технического обслуживания): заказы, клиенты, мастера, расходы, выплаты зарплат, склад запчастей, отчёты.

---

## Технологический стек

| Компонент | Версия / пакет |
|-----------|----------------|
| PHP | ^8.3 |
| Laravel | ^10 |
| PostgreSQL | 17 (Docker) |
| Nginx | 1.27 (Docker) |
| Node | 22 (Docker, сборка ассетов) |
| UI админки | [AdminLTE 3](https://adminlte.io/) (`almasaeed2010/adminlte`) |
| Права | [spatie/laravel-permission](https://github.com/spatie/laravel-permission) |
| Файловый менеджер | `barryvdh/laravel-elfinder` |
| Уведомления | `laravel-notification-channels/telegram` |
| Сборка CSS/JS | Vite 5 + Laravel Vite Plugin |
| Контейнеризация | Docker Compose (`docker-compose.v2.yml`) |

---

## Архитектура

```
┌─────────────────────────────────────────────────────────────────┐
│                         Браузер                                  │
└────────────┬───────────────────────────────┬────────────────────┘
             │                               │
    localhost:8080                   backend.* (ADMIN_DOMAIN)
             │                               │
             ▼                               ▼
┌────────────────────────┐      ┌────────────────────────┐
│  Nginx → PHP-FPM       │      │  Те же контейнеры       │
│  routes/web.php        │      │  routes/backend.php     │
│  Публичный + /admin    │      │  + routes/auth.php      │
└────────────┬───────────┘      └────────────┬───────────┘
             │                               │
             └───────────────┬───────────────┘
                             ▼
                    ┌─────────────────┐
                    │   PostgreSQL    │
                    └─────────────────┘
```

**Слои приложения:**

- **Controllers** — HTTP-запросы, валидация, ответы (View / Redirect / JSON).
- **Services** (`app/Services/Sto/`) — бизнес-логика заказов, выплат, отчётов.
- **Models** (`app/Models/`, `app/Models/Sto/`) — Eloquent, связи.
- **UseCases** (`app/UseCases/`) — сценарии для User/Page в backend-части.
- **Views** — Blade-шаблоны (публичные + `resources/views/admin/`).

---

## Структура проекта

```
Autoservice/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/Sto/          # CRUD модуля СТО
│   │   │   ├── Admin/Sto/Api/      # JSON API СТО
│   │   │   ├── Backend/            # Панель на поддомене
│   │   │   ├── AdminController.php # Логин и дашборд /admin
│   │   │   ├── SiteController.php  # Главная, sitemap
│   │   │   ├── ServiceController.php
│   │   │   ├── ReviewController.php
│   │   │   └── LeadController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php    # Только admin/manager
│   │   │   └── EnsureStoAccess.php # Доступ к /admin/sto/*
│   │   └── Requests/               # Form requests
│   ├── Models/
│   │   ├── Sto/                    # StoOrder, StoWorker, ...
│   │   ├── Service.php, Review.php, Page.php, Setting.php, User.php
│   ├── Services/Sto/               # StoOrderService, StoPaymentService, StoReportService
│   ├── Support/SiteImages.php      # URL картинок лендинга
│   └── View/Components/WidgetAdminMenu.php
├── config/
│   ├── admin-menu.php              # Боковое меню админки
│   └── site.php                    # Пути изображений лендинга
├── database/
│   ├── migrations/
│   └── seeders/
├── docker/                         # PHP, Nginx, DB init
├── public/
│   ├── images/site/                # Статичные фото лендинга
│   └── vendor/                     # AdminLTE (publish script)
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php       # Главная
│   │   ├── admin/                  # Админ-панель
│   │   └── backend/                # Backend на поддомене
│   ├── css/, js/
├── routes/
│   ├── web.php                     # Основные маршруты
│   ├── backend.php                 # Поддомен ADMIN_DOMAIN
│   └── auth.php
├── docs/                           # Эта документация
├── docker-compose.v2.yml
├── Makefile
└── vite.config.js
```

---

## Установка и запуск

### Требования

- [Docker Desktop](https://docs.docker.com/install/)
- (опционально) `make` — для целей из Makefile

### Быстрый старт

1. Скопировать окружение:
   ```bash
   cp .env.example .env
   # или: make cp-env
   ```

2. **Важно:** `PROJECT_NAME` в `.env` должен совпадать с именем PHP-контейнера в `docker/nginx/default.conf` (строка `fastcgi_pass`): формула `<PROJECT_NAME>-php`.

3. Собрать образ PHP и поднять контейнеры:
   ```bash
   docker build -t autoservice/php:8.3.12-fpm-bullseye --build-arg PHP_BASE_IMAGE_VERSION=8.3.12-fpm-bullseye ./docker/php/
   docker compose up -d
   ```

4. Миграции и сиды:
   ```bash
   docker compose exec --user=www-data php php artisan migrate --force
   docker compose exec --user=www-data php php artisan db:seed --force
   ```

5. Сайт: **http://localhost:8080** (порт `DOCKER_HTTP_PORT` в `.env`).

### Полная установка (Linux/macOS)

```bash
make install-dev
```

Выполняет: `.env`, сборку, `composer install`, `up`, `key:generate`, `yarn install`, миграции, сиды, `yarn build`, `storage:link`.

### Локальный доступ без Traefik

Для `localhost` / `127.0.0.1` в `AppServiceProvider` сбрасываются `session.domain` и принудительно выставляется `APP_URL` из текущего хоста — сессии работают на порту 8080.

---

## Переменные окружения

Ключевые переменные из `.env.example`:

| Переменная | Описание |
|------------|----------|
| `PROJECT_NAME` | Префикс имён Docker-контейнеров (`laravel-kit-php`, …) |
| `DOCKER_HTTP_PORT` | Порт HTTP (по умолчанию `8080`) |
| `APP_URL` | Базовый URL (`http://localhost:8080`) |
| `ADMIN_DOMAIN` | Поддомен backend-панели (`backend.laravel-kit.localhost`) |
| `DB_*` | PostgreSQL: хост `db`, БД `laravel` |
| `FORCE_HTTPS` | Принудительный HTTPS для URL |
| `TELEGRAM_BOT_TOKEN` | Токен бота для заявок |
| `TELEGRAM_CHAT_ID` | ID чата для уведомлений о лидах |

Для заявок с сайта нужно задать Telegram-переменные (см. [Уведомления Telegram](#уведомления-telegram)).

---

## Маршрутизация

Файл: `routes/web.php`.

### Публичные маршруты

| Метод | URL | Имя | Контроллер |
|-------|-----|-----|------------|
| GET | `/` | `/` | `SiteController@index` |
| GET | `/sitemap.xml` | `sitemap` | `SiteController@sitemap` |
| GET | `/services` | `services` | `SiteController@services` (заглушка) |
| POST | `/reviews` | `reviews.store` | `ReviewController@store` |
| POST | `/lead` | `lead.store` | `LeadController@store` |
| GET | `/login` | `login` | `AdminController@index` |
| POST | `/login` | — | `AdminController@login` |

### Админ-панель (`middleware: auth`)

Префикс `/admin`. Middleware `Authenticate` пропускает только пользователей с `is_admin = true` или ролями `admin` / `manager`.

| Раздел | Префикс | Описание |
|--------|---------|----------|
| Дашборд | `/admin` | Статистика, последние отзывы |
| Отзывы | `/admin/reviews` | Модерация отзывов |
| Услуги | `/admin/service` | CRUD услуг на сайте |
| **СТО** | `/admin/sto/*` | + middleware `sto.access` |

### Backend на поддомене

В `web.php`:

```php
Route::domain(env('ADMIN_DOMAIN'))
    ->group(function () {
        require __DIR__ . '/auth.php';
        require __DIR__ . '/backend.php';
    });
```

Маршруты backend требуют `can:use-backend-panel` и роль/права Spatie.

---

## Публичный сайт

### Главная страница (`SiteController@index`)

- Увеличивает счётчик просмотров в таблице `settings` (`key = view_count`).
- Загружает все услуги (`Service`), отзывы (`Review`, новые первые).
- Передаёт в шаблон `welcome` массив URL изображений через `SiteImages::all()`.

### Отзывы (`POST /reviews`)

Поля: `name`, `car` (опционально), `rating` (1–5), `message`.

- При AJAX/JSON — ответ JSON с созданным отзывом.
- Иначе — редирект назад с flash `success`.

### Заявка (`POST /lead`)

Поля: `name`, `phone`, `car` (опционально), `message`.

Отправляет уведомление в Telegram (`NewLeadNotification`). Ответ всегда JSON.

### Sitemap (`GET /sitemap.xml`)

XML из шаблона `sitemap.blade.php` на основе `Page` и `Service`.

### Изображения услуг

`SiteImages::forService()`:

1. Если у услуги есть загруженное изображение в `storage` — используется оно.
2. Иначе — подбор по ключевым словам в названии (`config/site.php` → `service_placeholders`).
3. Иначе — `default`.

---

## Админ-панель

### Вход

- URL: `/login`
- После успешного входа — редирект на `admin.dashboard`.
- Пользователь без роли `admin`/`manager` и без `is_admin` получает ошибку «Нет доступа в админ-панель».

### Дашборд

Показывает:

- Количество пользователей, услуг, отзывов.
- Счётчик просмотров сайта.
- «Здоровье сайта»: услуги без описания, страницы без текста, наличие `robots.txt`.
- 5 последних отзывов.

### Услуги (`ServiceController`)

| Действие | Маршрут |
|----------|---------|
| Список | `GET /admin/service` |
| Создание | `GET/POST /admin/service/create`, `store` |
| Редактирование | `GET/PATCH /admin/service/edit/{id}`, `update` |
| Удаление | `DELETE /admin/service/delete/{id}` |

Изображения сохраняются на диск `public` в каталог `images/`.

### Отзывы (`Backend\ReviewController`)

Resource только: `index`, `edit`, `update`, `destroy`. Имена маршрутов: `admin.review.*`.

---

## Модуль СТО (учёт автосервиса)

Доступ: middleware `sto.access` (`EnsureStoAccess`) — те же роли, что и для админки (`admin`, `manager`, `is_admin`).

### Заказы

**Статусы** (`StoOrder::STATUSES`):

| Код | Подпись |
|-----|---------|
| `new` | Новый |
| `in_progress` | В работе |
| `ready` | Готов |
| `completed` | Завершён |
| `cancelled` | Отменён |

**Номер заказа** генерируется автоматически: `ORD-YYYYMMDD-0001` (см. `StoOrderService::generateOrderNumber()`).

**Создание заказа:**

1. Выбирается клиент, описание услуги, сумма, статус.
2. Опционально — список мастеров с суммой выплаты за заказ.
3. Для каждого мастера создаётся:
   - запись в `sto_order_workers`;
   - запись в `sto_worker_payments` со статусом `pending`.

**Маршруты:**

| Метод | URL | Действие |
|-------|-----|----------|
| GET | `/admin/sto/orders` | Список (фильтр `?status=`) |
| GET | `/admin/sto/orders/create` | Форма создания |
| POST | `/admin/sto/orders` | Сохранение |
| PATCH | `/admin/sto/orders/{order}/status` | Смена статуса |
| DELETE | `/admin/sto/orders/{order}` | Удаление |

### Мастера (`sto_workers`)

| Поле | Описание |
|------|----------|
| `name` | ФИО |
| `phone` | Телефон |
| `payment_type` | `percent` или `fixed` (тип оплаты, для справки) |
| `rate` | Ставка |
| `is_active` | Активен ли мастер |

CRUD: список, добавление, удаление (без редактирования в UI).

### Клиенты (`sto_clients`)

Поля: `name`, `phone`, `email`. Добавление и удаление из списка.

### Расходы (`sto_expenses`)

| Поле | Описание |
|------|----------|
| `description` | Описание |
| `amount` | Сумма |
| `category` | Категория |
| `expense_date` | Дата расхода |

### Выплаты мастерам (`sto_worker_payments`)

Связь: мастер ↔ заказ (опционально) ↔ сумма ↔ статус (`pending` / `paid`) ↔ `paid_at`.

| Действие | Маршрут |
|----------|---------|
| Список выплат | `GET /admin/sto/payments` |
| Выплатить все pending мастеру | `POST .../payments/worker/{worker}/pay-all` |
| Выплатить одну запись | `POST .../payments/{payment}/pay` |

Логика в `StoPaymentService`: массовая выплата обновляет все `pending` записи мастера; одиночная — одну запись, дата `paid_at` = сегодня.

### Запчасти (`sto_parts`)

Склад: `name`, `article`, `quantity`, `price`, `min_quantity` (минимальный остаток для контроля).

### Отчёты

`StoReportService::buildReport($dateFrom, $dateTo)`:

- По умолчанию период — **текущий месяц**.
- **Выручка** — сумма `amount` заказов со статусом `completed` за период (по `created_at`).
- **Расходы** — сумма `sto_expenses` по `expense_date`.
- **Зарплаты** — сумма выплаченных `sto_worker_payments` (`status = paid`) по `paid_at`.
- **Прибыль** = выручка − расходы − зарплаты.
- **Количество заказов** — все кроме `cancelled` за период.
- Список завершённых заказов за период.

Фильтр на странице: `?date_from=&date_to=`.

---

## Backend-панель (отдельный домен)

Работает на домене из `ADMIN_DOMAIN` (например `backend.laravel-kit.localhost`). Требует настройки hosts / Traefik в dev.

| Маршрут | Permission | Описание |
|---------|------------|----------|
| `backend./` | `use-backend-panel` | Главная backend |
| `backend.user.*` | `use-crud` | CRUD пользователей |
| `backend.page.*` | `use-crud` | CRUD страниц |

Elfinder (файловый менеджер) защищён middleware `can:use-admin-panel`.

---

## База данных

### Основные таблицы (сайт)

| Таблица | Назначение |
|---------|------------|
| `users` | Пользователи (+ `is_admin`) |
| `services` | Услуги на лендинге |
| `reviews` | Отзывы посетителей |
| `pages` | Статические страницы (sitemap, backend) |
| `settings` | Ключ-значение (`view_count`, …) |
| `roles`, `permissions`, … | Spatie Permission |

### Таблицы модуля СТО

```
sto_clients ──┐
                ├── sto_orders ──┬── sto_order_workers ── sto_workers
                │                └── sto_worker_payments
sto_expenses (отдельно)
sto_parts (склад)
```

**Связи при удалении:**

- Удаление клиента → каскадное удаление заказов.
- Удаление заказа → каскад `sto_order_workers`; у платежей `order_id` → `nullOnDelete`.

### Миграции

Выполнить:

```bash
make migrate
# или
docker compose exec --user=www-data php php artisan migrate
```

Порядок важен: сначала `users`, `permissions`, затем `services`, `reviews`, `settings`, `sto_*`.

---

## Аутентификация и права доступа

### Роли (Spatie)

| Роль | Permissions |
|------|-------------|
| `admin` | `use-crud`, `use-admin-panel`, `use-sto-panel` |
| `manager` | `use-sto-panel` |

`AuthServiceProvider`: пользователь с ролью `admin` проходит любую проверку Gate (`Gate::before` → `true`).

### Флаги и middleware

- **`is_admin`** — legacy-флаг; даёт доступ в админку наравне с ролью `admin`.
- **`Authenticate`** — для всех маршрутов с `auth` в `/admin`: без `is_admin` и без ролей `admin`/`manager` — logout и редирект на login.
- **`EnsureStoAccess`** — для `/admin/sto/*`: то же правило + `403` при отказе.

### Демо-аккаунты (после `db:seed`)

| Email | Пароль | Роль | is_admin |
|-------|--------|------|----------|
| admin@example.com | admin | admin | да |
| manager@example.com | manager | manager | нет |

---

## JSON API модуля СТО

Префикс: `/admin/sto/api`. Требуется сессия авторизованного пользователя (те же cookie, CSRF для POST/PATCH).

| Метод | URL | Описание |
|-------|-----|----------|
| GET | `/admin/sto/api/orders` | Список заказов (`?status=`, `?per_page=15`) |
| POST | `/admin/sto/api/orders` | Создание заказа (JSON body) |
| PATCH | `/admin/sto/api/orders/{order}/status` | Смена статуса |
| POST | `/admin/sto/api/payments/worker/{worker}` | Выплатить все pending мастеру |
| POST | `/admin/sto/api/payments/{payment}` | Выплатить одну запись |

Пример создания заказа (тело запроса):

```json
{
  "client_id": 1,
  "service": "Замена масла",
  "amount": 3500,
  "status": "new",
  "workers": [
    { "worker_id": 1, "amount": 1500 }
  ]
}
```

Ответы: JSON с полями `success`, сущности или ошибки валидации (422).

---

## Сервисный слой

### `StoOrderService`

- `generateOrderNumber()` — уникальный номер на день.
- `createOrder($data, $workers)` — транзакция: заказ + мастера + pending-платежи.
- `updateStatus($order, $status)` — обновление статуса.

### `StoPaymentService`

- `payWorker($worker)` — все pending → paid.
- `payPayment($payment)` — одна выплата.

### `StoReportService`

- `buildReport($dateFrom, $dateTo)` — агрегаты и список заказов (см. [Отчёты](#отчёты)).

---

## Изображения сайта

Файлы: `public/images/site/` (`hero.jpg`, `workshop.jpg`, …).

Конфиг: `config/site.php`:

- `images` — фиксированные блоки лендинга.
- `service_placeholders` — сопоставление подстрок в названии услуги с картинкой-заглушкой.

Класс `App\Support\SiteImages` — единая точка получения URL через `asset()`.

---

## Уведомления Telegram

1. Создать бота через [@BotFather](https://t.me/BotFather), получить `TELEGRAM_BOT_TOKEN`.
2. Узнать `TELEGRAM_CHAT_ID` чата/канала.
3. Добавить в `.env`:
   ```
   TELEGRAM_BOT_TOKEN=...
   TELEGRAM_CHAT_ID=...
   ```
4. Конфиг канала: `config/services.php` → `telegram.token`.

Класс: `App\Notifications\NewLeadNotification`.

---

## Сидеры и демо-аккаунты

`DatabaseSeeder` вызывает:

1. **UserSeeder** — admin и manager.
2. **RolesAndPermissionsSeeder** — роли, permissions, привязка к пользователям.
3. **ServiceSeeder** — 8 типовых услуг (диагностика, ТО, двигатель, ходовая, …).

```bash
make artisan-seed
```

---

## Сборка фронтенда

Vite (`vite.config.js`) собирает:

- `resources/css/app.css`
- `resources/css/ionicons.min.css`
- `resources/css/source-sans-pro.css`
- `resources/js/app.js`

Команды (через Docker-контейнер `node`):

```bash
make yarn-install    # зависимости
make yarn-dev        # dev + HMR
make yarn-watch      # alias dev
make yarn-prod       # production build
```

AdminLTE публикуется в `public/vendor` при `composer install` (скрипт `scripts/publish-adminlte-assets.php`).

---

## Меню админ-панели

Файл: `config/admin-menu.php`.

Структура пункта:

```php
[
    'text' => 'Заголовок',
    'icon' => 'fas fa-fw fa-icon',
    'route' => 'admin.dashboard',           // одиночный пункт
    // или:
    'route_prefix' => 'admin.sto.',         // для подменю
    'submenu' => [
        ['text' => '...', 'route' => 'admin.sto.orders.index', 'icon' => 'fa-...'],
    ],
],
```

Компонент `<x-admin-menu :items="config('admin-menu')" />` рендерится в `layouts/_aside.blade.php` через `WidgetAdminMenu`.

---

## Команды разработки

| Make-цель | Действие |
|-----------|----------|
| `make up` / `make down` | Запуск / остановка Docker |
| `make env` | Shell в PHP-контейнере (www-data) |
| `make composer-install` | Composer (prod, --no-dev) |
| `make composer-install-dev` | Composer с dev-зависимостями |
| `make migrate` | Миграции |
| `make artisan-seed` | Сиды |
| `make artisan-storage-link` | `storage:link` |
| `make artisan-cmd cmd="..."` | Произвольная artisan-команда |
| `make generate-ide-helper` | IDE Helper |
| `make create-dump` | Дамп PostgreSQL в `<PROJECT_NAME>.sql` |

---

## Расширение проекта

### Добавить пункт меню СТО

1. Создать контроллер в `app/Http/Controllers/Admin/Sto/`.
2. Зарегистрировать маршруты в `routes/web.php` внутри группы `sto`.
3. Добавить пункт в `config/admin-menu.php`.
4. Создать view в `resources/views/admin/sto/`.

### Добавить permission

1. Добавить имя в `RolesAndPermissionsSeeder`.
2. Привязать к роли через `syncPermissions`.
3. Использовать `middleware('can:permission-name')` или `@can` в Blade.

### Новая публичная страница

1. Маршрут в `web.php`.
2. Метод в `SiteController` или отдельный контроллер.
3. Blade в `resources/views/`.

---

## Связанные файлы

| Тема | Файл |
|------|------|
| Маршруты | `routes/web.php`, `routes/backend.php` |
| Меню | `config/admin-menu.php` |
| Картинки | `config/site.php`, `app/Support/SiteImages.php` |
| СТО миграции | `database/migrations/2025_07_02_100000_create_sto_tables.php` |
| Docker | `docker-compose.v2.yml`, `docker/nginx/default.conf` |
| Быстрый старт | `README.md` |

---

*Документация актуальна для состояния репозитория с модулем СТО, AdminLTE 3 и Laravel 10.*
