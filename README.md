<h3>Installasi</h3>
1. Install Dependencies <br/>
   - composer install <br/>
   - npm i

2. Konfigurasi .env
   - php artisan key:generate
   - mailtrap
     MAIL_MAILER=smtp <br/>
     MAIL_HOST=sandbox.smtp.mailtrap.io <br/>
     MAIL_PORT=2525 <br/>
     MAIL_USERNAME= ... isi username ... <br/>
     MAIL_PASSWORD= ... isi password ... 
   - Database
     DB_DATABASE=db_todolist
   - Queue
     QUEUE_CONNECTION=database

3. Generate KEY
   - php artisan key:generate

4. Migrasi dan Seed
   - php artisan migrate <br/>
   - php artisan db:seed --class=User
     
5. Run Server
   - php artisan serve <br/>
   - php artisan queue:work

6. Masuk app
    - email: admin@gmail.com <br/>
    - pass : admin123 
