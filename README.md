## How to start
* Clone this project and cd into feedreader folder
* cp code/.env.example code/.env

* Make "run" file executable:
    - chmod u+x run

* Install dependencies:
    - cd code
    - docker run --rm --interactive --tty -v $(pwd):/app -w /app composer install

* Back to feedreader directory and start server:
    - docker-compose up -d

* Change folder permissions:
    - chmod 777 code/storage --recursive
    
* Generate key:
    - ./run key:generate
    
* Migrate database:
    - ./run migrate
    
* Go to http://localhost/feed. Currently work best with Vnexpress RSS. Other RSS sources with different formats and structures may not work as expected (can be added later). 

* Hover a page on the left panel to show its corresponding "Remove" button. Click to remove (currently there are no confirmation dialog).

* List all available commands for CLI mode: ./run list

* Command for RSS management:

| Command           | Action                                                                                                                                                  |
|-------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------|
| ./run page:list   | List all fetched RSS pages in database                                                                                                                  |
| ./run page:view   | View feeds of an existing RSS page or from a RSS url. Will return feeds from database if that URL is fetched (We don't fetch a URL in a same day twice) |
| ./run page:remove | Remove a fetched RSS page and its feeds from database                                                                                                   |

* (Optional) Setup a local domain name:
    - Edit /etc/hosts file: append "127.0.0.1 {{your_local_domain_name}}"
    - Open  {{your_local_domain_name}}. It should shows homepage

* (For Dev) Compile assets:
    - docker-compose exec php bash
    - npm run watch
    
