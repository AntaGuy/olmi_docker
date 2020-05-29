`docker-compose up` => yarn encore dev --watch will be launched

create .env.local and add:
```
DATABASE_URL=mysql://antadis:antadis@olmi_mysql:3306/olmi
MAILER_DSN=smtp://olmi_maildev:25
DELIVERY_ADDRESS=youremail@email.fr
```

Connect to web container
`docker-compose exec web bash` 

`composer install` to update dependencies

`php bin/console` to see available commands

`php bin/console doctrine:migrations:migrate` to update database schema
 
If it's the first time you can load :
`php bin/console doctrine:fixture:load` you will have a super admin user : hebergement@antadis.com / antadis78
