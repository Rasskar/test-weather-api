```bash
git clone git@github.com:Rasskar/test-weather-api.git
```
```bash
cd test-weather-api
```
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
```bash
cp .env.example .env
```
```bash
./vendor/bin/sail up -d
```
```bash
./vendor/bin/sail artisan key:generate
```
```bash
./vendor/bin/sail artisan migrate
```
```bash
http://localhost
```
```bash
http://localhost/api/documentation/
```
```bash
./vendor/bin/sail artisan test
```
