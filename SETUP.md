# Setting Up the Laravel Waiver System

Follow these step-by-step instructions to get your waiver system up and running locally.

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL or similar database
- Node.js and NPM (optional for frontend assets)

## Step 1: Clone the Repository

```bash
git clone https://github.com/r1c3p1l4f/waiverflow.git
cd waiverflow
```

## Step 2: Install Dependencies

```bash
composer install
```

## Step 3: Environment Setup

1. Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

2. Generate an application key:

```bash
php artisan key:generate
```

3. Update your `.env` file with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=waiverflow
DB_USERNAME=root
DB_PASSWORD=
```

## Step 4: Database Setup

1. Create your database:

```bash
mysql -u root -p
CREATE DATABASE waiverflow;
EXIT;
```

2. Run migrations to set up the database tables:

```bash
php artisan migrate
```

3. Seed the database with initial data:

```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

## Step 5: Install Frontend Dependencies (Optional)

If you want to compile frontend assets:

```bash
npm install
npm run dev
```

## Step 6: Run the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Step 7: Login with Test Accounts

Use the following credentials to test different roles:

- **Admin**: admin@example.com / password
- **Staff**: staff@example.com / password
- **Customer**: customer@example.com / password

## Troubleshooting

### Storage Link Issues

If you encounter issues with file uploads, create a symbolic link for storage:

```bash
php artisan storage:link
```

### Permission Issues

Make sure your storage directory is writable:

```bash
chmod -R 775 storage bootstrap/cache
```

## Next Steps

After successfully setting up the application, you can customize it for your specific business needs by modifying the waiver templates, adding business branding, or extending the functionality.
