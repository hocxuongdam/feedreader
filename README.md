## How to start

* cp /code/.env.example -> /code/.env

* Make "run" file executable:
    - chmod u+x run

* Install dependencies:
 docker run --rm --interactive --tty -v $(pwd):/app -w /app composer install

* Start server:
    - docker-compose up 

* Change folder permissions:
    - chmod 777 storage --recursive
    
* Generate key:
    - ./run key:generate
* Migrate database:
    - ./run migrate

* Setup a local domain name:
    - Edit /etc/hosts file: append "127.0.0.1 {{your_local_domain_name}}"
    - Open  {{your_local_domain_name}}. It should shows homepage

* Compile assets:
    - docker-compose exec php bash
    - npm run watch
    