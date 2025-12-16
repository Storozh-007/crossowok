# Sneakershop

Оновлений інтернет-магазин із потужною адмінкою (статистика, замовлення, продукти/категорії) та кабінетом користувача з історією покупок.

## Швидкий старт на macOS + Herd
1. Покладіть папку `sneakershop` у директорію, яку паркує Herd (типово `~/Herd`) або додайте її в Herd UI (`Sites` → `+` → оберіть папку).
2. Скопіюйте `.env.example` у `.env` та виставте з’єднання з БД MySQL (Herd піднімає MySQL/MariaDB локально). Приклад:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sneakershop
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Встановіть залежності в корені проєкту:
   ```
   composer install
   npm install
   ```
4. Зберіть фронт:
   ```
   npm run build   # або npm run dev для дев-сервера
   ```
5. Підготуйте Laravel:
   ```
   php artisan key:generate
   php artisan migrate        # включає нову міграцію статусів замовлень
   php artisan storage:link
   ```
6. Відкрийте сайт. Якщо проект запарковано в Herd, він буде доступний за адресою `http://sneakershop.test`. Альтернатива без Herd: `php artisan serve` і перейти на `http://127.0.0.1:8000`.

## Ролі та вхід в адмінку
- Після реєстрації всі користувачі отримують роль `user`.
- Щоб призначити адміністратора, оновіть роль у БД вручну або через tinker:
  ```
  php artisan tinker
  \App\Models\User::where('email', 'you@example.com')->update(['role' => 'admin']);
  ```
- Для суперкористувача можна виставити роль `god` (доступ до /god для керування ролями).
