# WaiverFlow - Laravel Digital Waiver System

## Overview

WaiverFlow is a digital waiver management system built on Laravel. This MVP application allows businesses to create, manage, and store digital waivers. The system is designed to be a component of a larger business management platform.

## Features

- **Waiver Template Management**: Create and customize waiver templates
- **Digital Signing**: Capture electronic signatures for legal documents
- **PDF Generation**: Convert signed waivers to downloadable PDFs
- **User Roles**: Admin, Staff, and Customer access levels
- **Customer Portal**: Self-service waiver signing and management
- **Mobile Responsive**: Works on all devices for in-person or remote signing

## Getting Started

1. Clone this repository
2. Install dependencies with `composer install`
3. Set up your environment file
4. Run migrations with `php artisan migrate`
5. Seed the database with `php artisan db:seed --class=RolesAndPermissionsSeeder`
6. Start the server with `php artisan serve`

## Test Accounts

- **Admin**: admin@example.com / password
- **Staff**: staff@example.com / password
- **Customer**: customer@example.com / password

## Tech Stack

- **Framework**: Laravel 10
- **Database**: MySQL
- **PDF Generation**: DomPDF
- **Authorization**: Spatie Laravel-Permission
- **Frontend**: Tailwind CSS
- **Signature Capture**: Signature Pad JS

## Project Structure

The project follows Laravel's MVC architecture:

- **Models**: User, WaiverTemplate, SignedWaiver, CustomerProfile
- **Controllers**: WaiverTemplateController, SignedWaiverController, CustomerPortalController
- **Views**: Organized by feature (waiver-templates, signed-waivers, customer)

## Future Development

This MVP focuses on waiver functionality. Future plans include:
- Integration with appointment scheduling
- Payment processing
- Staff management
- Business reporting
- Customer communications

## License

[MIT License](LICENSE)

## Setup Instructions

Detailed setup instructions can be found in [SETUP.md](SETUP.md).
