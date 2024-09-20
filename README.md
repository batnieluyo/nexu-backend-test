# Nexu API on Laravel 11.x

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

* **Docker Desktop:** Laravel Sail requires Docker for containerization.

## Step-by-Step Guide

### 1. Clone the Project

```bash
git clone https://github.com/batnieluyo/laravel-nexu.git

cd laravel-nexu
```

### 2. Install Dependencies

Install the PHP dependencies required by Laravel via Composer. If Composer is not installed globally, you can run it through Docker using Sail:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

This command will install all necessary dependencies in the Docker environment.

### 3. Create a .env File

Copy the .env.example file to .env and set your environment variables, such as database connection details, application key, etc.

```bash
cp .env.example .env
```

### 4. Start Laravel Sail
You can bring up the Laravel Sail environment by running:

```bash
FORWARD_DB_PORT=3307 APP_PORT=89 ./vendor/bin/sail up

# FORWARD_DB_PORT=3307 APP_PORT=89 ./vendor/bin/sail up -d
```
* The -d flag will run Sail in detached mode, which allows the containers to run in the background.

### Step: Running migrations and seeder
You need run the migrations and populate the database running the next commands:

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan app:import-models
```

### Step 5: Accessing the Application
Once Sail is up, your Laravel application should be running at http://0.0.0.0:89].

**important:** sails always return the internal port at 80 as default on console.

Visit http://0.0.0.0:89 on your browser

## Disclaimer

### Rebuilding Sail Images

Sometimes you may want to completely rebuild your Sail images to ensure all of the image's packages and software are up to date. You may accomplish this using the build command:

```bash
docker compose down -v

./vendor/bin/sail build --no-cache
 
FORWARD_DB_PORT=3307 APP_PORT=89 ./vendor/bin/sail up

# FORWARD_DB_PORT=3307 APP_PORT=89 ./vendor/bin/sail up -d
```

## Troubleshooting

### Docker Not Running
Ensure Docker is running on your machine before executing any Sail commands. If Docker is not running, Sail will fail to start.

### Missing .env Variables
Ensure that all the required environment variables are set up in your .env file, particularly APP_KEY, DB_CONNECTION, and DB_HOST.