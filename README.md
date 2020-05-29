# ENR'CERT OLMI project

## Components
1. Apache 2
2. PHP 7.3 
3. Mariadb 10.4
4. Symfony 5
5. Node 10
6. PhpMyAdmin
7. Maildev

## Setting up DEV environment
1. Clone this repository from GitHub

   `git clone https://github.com/AntaGuy/olmi_docker`


2. Setting up DEV environment

   2.1. Set another APP_SECRET for application in .env.
   (You can get unique secret key for example [here](http://nux.net/secret).)

   2.2. Create .env.local and add:

      ```
      DATABASE_URL=mysql://olmi:olmi@olmi_mysql:3306/olmi
      MAILER_DSN=smtp://olmi_maildev:25
      DELIVERY_ADDRESS=youremail@email.fr
      ```

   2.3. Add domain to local 'hosts' file:

      ```bash
      127.0.0.1    olmi.local
      ``` 

   2.3. Configure Xdebug:
      Configure docker/xdebug.ini
      Uncomment lines in docker/php7.3/Dockerfile

3. Create and start containers

   `docker-compose build`
   `docker-compose up` 
   =>  yarn encore dev-server will be launched

4. Connect to web container

   `docker-compose exec web bash` 

5. Install Symfony & components

   `composer install`

   `php bin/console` to see available commands

6. Update database schema

   `php bin/console doctrine:migrations:migrate`
   
   If it's the first time you can load :
   `php bin/console doctrine:fixture:load` you will have a super admin user : admin@olmi.com / olmi

7. In order to use this application, please open in your browser next url: [http://olmi.local](http://olmi.local).
  
   Enjoy !
