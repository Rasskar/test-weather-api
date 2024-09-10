git clone git@github.com:Rasskar/test-weather-api.git

cd test-weather-api

docker run --rm \
-u "$(id -u):$(id -g)" \
-v $(pwd):/var/www/html \
-w /var/www/html \
laravelsail/php83-composer:latest \
composer install --ignore-platform-reqs

cp .env.example .env

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate

http://localhost
