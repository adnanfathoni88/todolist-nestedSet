<h3>Installasi</h3>
1. Install Dependencies <br/>
    - composer install
    - npm i
    
2. Konfigurasi .env
   - php artisan key:generate
   - mailtrap
     MAIL_MAILER=smtp
     MAIL_HOST=sandbox.smtp.mailtrap.io
     MAIL_PORT=2525
     MAIL_USERNAME= ... isi username ...
     MAIL_PASSWORD= ... isi password ...
   - Database
     DB_DATABASE=db_todolist
   - Queue
     QUEUE_CONNECTION=database

4. Generate KEY
   - php artisan key:generate

6. Migrasi dan Seed
   - php artisan migrate
   - php artisan db:seed --class=User
     
8. Run Server
   - php artisan serve
   - php artisan queue:work
