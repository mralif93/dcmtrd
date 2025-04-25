
# DCMTRD Microservices

DCMTRD Microservices is a system designed to gather and process data from various sources, primarily focusing on BIX (Business Information Exchange) and real estate data. The system aims to provide accurate, real-time data for analysis and decision-making in industries like finance and property management.

The microservices architecture ensures scalability and maintainability, making it ideal for handling large amounts of data while keeping the system flexible and adaptable to future needs.

![Logo](public/images/art_logo.png)

## Installation

## Run Locally

Clone the project

```bash
git clone git@bitbucket.org:digital_artb/dcmtrd.git
```

Go to the project directory

```bash
cd dcmtrd
```

Start the server using Docker

```bash
docker-compose up -d
```

Access the application container

```bash
docker exec -it <container_name> bash
```

Replace `<container_name>` with the name of your application container.

Install dependencies using npm

```bash
npm install
```

Install PHP dependencies using Composer

```bash
composer install
```

Run database migrations

```bash
php artisan migrate
```

Seed the database

```bash
php artisan db:seed
```

Generate the application key

```bash
php artisan key:generate
```

## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

```env
DB_HOST=dcmtrd-mariadb
QUEUE_CONNECTION=redis
REDIS_HOST=dcmtrd-redis
```

## Tech Stack

**Frontend:** Alpine.js, Blade, TailwindCSS  
**Backend:** Laravel  
**Database:** MariaDB  
**Cache/Queue:** Redis  
**Containerization:** Docker, Docker Compose  

## Authors

- [@octokatherine](https://github.com/mralif93)
- [@octokatherine](https://github.com/matkmin)