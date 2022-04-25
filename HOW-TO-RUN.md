Run migration first


    php bin/console doctrine:migrations:migrate

Then populate the database with fake data:

    php bin/console app:populate-db

The easiest way to run the server is to use symfony cli:

    symfony server:start

Curl example:

    curl "http://127.0.0.1:8000/overtime?hotel-id=1&start-date=2021-04-05%2000:00&end-date=2022-06-25%2000:00"