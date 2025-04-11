# Currency converter

Currency converter is a Symfony project that helps you to convert one currency to 
another using the latest exchange rates. 

## Requirements
* PHP 8.2 or higher
* Symfony CLI binary
* Redis
* NPM

## Installation
* Clone the repository to your computer
```bash
git clone git@github.com:maxwellzp/currency-converter.git
```
* Change your current directory to the project directory
```bash
cd currency-converter
```
* Install Composer dependencies
```bash
composer install
```
* Install node modules dependencies and build them in dev
```bash
npm install
npm run dev
```
* Start Mercure in Docker container
```bash
docker compose up -d
```
* Update currency prices in Redis
```bash
bin/console app:currency-updater
```
* Start Symfony development server
```bash
symfony server:start -d
```


## Usage
* Access the application in any browser at the given URL https://127.0.0.1:8000/

## Running Tests

To run tests, run the following command

```bash
composer test
```


## License

[MIT](https://choosealicense.com/licenses/mit/)

