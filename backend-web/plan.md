# PawsBank Backend Plan

## Архитектура

**Поток запроса:**
```
Request → Controller → Service → Model → DTO
```

**Слои:**
- `app/Http/Controllers/` — тонкие, только HTTP (принять, вернуть)
- `app/Services/` — вся бизнес-логика
- `app/Data/` — единые DTO для валидации входящих данных и ответов API
- `app/Models/` — Eloquent, только данные

**Правила:**
- Контроллеры без бизнес-логики
- Сервисы с несколькими методами
- Один Data-класс на модель (для входа и выхода), `id`/`created_at` и серверные поля — nullable
- Валидация через spatie/laravel-data (rules() или атрибуты)
- Хранение изображений — local disk

---

## Реализация

### 🔴 Высокий приоритет

- [ ] **Auth API** — register (+ дефолтный аккаунт), login → Sanctum token
- [ ] **Accounts API** — CRUD + управление участниками (invite/remove по ролям)
- [ ] **Receipts API** — CRUD чеков с items и images
- [ ] **AI scan-receipt** — AiService, адаптировать под новую схему

### 🟡 Средний приоритет

- [ ] **Receipt Items API** — CRUD позиций чека
- [ ] **Receipt Images API** — загрузка фото (local disk)
- [ ] **Receipt Categories API** — CRUD

### 🟢 Низкий приоритет

- [ ] **Products API** — справочник продуктов
- [ ] **Item Categories API** — CRUD + переводы
- [ ] **Settings (веб)** — profile, password, 2FA
- [ ] **AI suggest-category** — публичный эндпоинт
- [ ] **AI health** — публичный эндпоинт

---

## Источники в deprecated-backend

- Auth: `app/Http/Controllers/Api/AuthController.php`
- AI: `app/Services/AiService.php`
- Settings: `app/Http/Controllers/Settings/`