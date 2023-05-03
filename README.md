# ToolKit Test Task

With this project, you can create statements :)
## Requirements

* PHP 8.1.10
* Composer
* MySQL
* Laravel 9.19
##

## Installation

1. Clone the repository to your local machine:
```bash
git clone https://github.com/ashushanyan/ToolKitTest
```
2. Clone the repository to your local machine:
```bash
cd laravel-project (ToolKitTest)
composer install
```
2.1 Also you can run project with Docker::
```bash
compose -f myapp-docker-compose.yml up
```
3. Create a new database and update the `.env` file with your database credentials:
```makefile
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
4. Create a new database and update the `.env` file with your database credentials and seed the database with sample data:
```bash
php artisan migrate --seed

```
5. Start the development server:
```bash
php artisan serve
```
6. Generate the Swagger documentation by running the following command:
```bash
php artisan l5-swagger:generate
```
7. Generate the Swagger documentation by running the following command:
```makefile
http://localhost:8000/api/documentation

```
## Built With

* Laravel

## Author

* Ashot Shushanyan
* Linkdin - https://www.linkedin.com/in/ashot-shushanyan/
