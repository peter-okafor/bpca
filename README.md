# PESTS.org

A comprehensive pest control provider directory and management platform built with Laravel, React, and Inertia.js. This application allows users to search for pest control providers based on location, view provider details, and manage provider information through an admin panel.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Development](#development)
- [Testing](#testing)
- [Deployment](#deployment)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

## Features

- **Location-based Search**: Find pest control providers within a specified distance using Google Maps integration
- **Interactive Maps**: Visualize provider locations with Leaflet and Google Maps
- **Provider Management**: Comprehensive admin panel powered by Laravel Nova
- **Responsive Design**: Built with Tailwind CSS for mobile and desktop experiences
- **Real-time Updates**: Redux state management for seamless user experience
- **Spatial Queries**: Efficient location-based searches using Laravel Eloquent Spatial
- **Blog Integration**: Connected blog platform for pest control tips and information

## Tech Stack

### Backend
- **Laravel 9.x** - PHP framework
- **Laravel Nova 4.x** - Admin panel
- **Laravel Sanctum** - API authentication
- **Laravel Vapor** - Serverless deployment platform
- **MySQL** - Primary database
- **Redis** - Caching and queue management

### Frontend
- **React 17** - UI library
- **TypeScript** - Type-safe JavaScript
- **Inertia.js** - Modern monolith approach
- **Tailwind CSS 3** - Utility-first CSS framework
- **Redux Toolkit** - State management
- **Google Maps API** - Location services
- **Leaflet** - Interactive maps

### Development Tools
- **Laravel Mix** - Asset compilation
- **Pest PHP** - Testing framework
- **Laravel Telescope** - Debug assistant
- **Laravel Debugbar** - Debugging toolbar
- **PHP CS Fixer** - Code style fixer

## Requirements

- **PHP**: ^8.0.2
- **Composer**: Latest version
- **Node.js**: 14.x or higher
- **NPM**: 6.x or higher
- **MySQL**: 5.7 or higher
- **Redis**: 5.x or higher (for caching and queues)
- **Google Maps API Key**: Required for location features

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/bpca.git
cd bpca
```

### 2. Create Database

Create a new MySQL database and user:

```sql
CREATE DATABASE bpca;
CREATE USER 'bpca_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON bpca.* TO 'bpca_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Install PHP Dependencies

```bash
composer install
```

### 4. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Install Node Dependencies

```bash
npm install
```

### 6. Configure Environment Variables

Edit the `.env` file and configure the following (see [Configuration](#configuration) section for details):

- Database credentials
- Google Maps API keys
- Redis configuration
- Mail settings (if applicable)

### 7. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

This will create all necessary database tables and populate them with initial data.

### 8. Build Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run production
```

### 9. Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Configuration

### Required Environment Variables

#### Application Settings
```env
APP_NAME=PESTS.org
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

#### Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bpca
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

#### Redis Configuration
```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=predis
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### Google Maps Integration
```env
GOOGLE_MAPS_KEY=your_google_maps_api_key
MIX_GOOGLE_MAPS_KEY=your_google_maps_api_key
```

**Important**: You need to obtain a Google Maps API key from the [Google Cloud Console](https://console.cloud.google.com/) with the following APIs enabled:
- Maps JavaScript API
- Geocoding API
- Places API

#### Location Settings
```env
LOCATION_DISTANCE=5000
```
Sets the default search radius in meters (5000m = 5km)

#### UI Configuration
```env
MIX_LRT_OR_RTL=ltr
```
Set text direction (ltr = left-to-right, rtl = right-to-left)

#### Blog Integration
```env
MIX_BLOG_URL=http://localhost:8000/blog
```
URL of the integrated blog platform

#### Mail Configuration (Optional)
```env
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@pests.org
MAIL_FROM_NAME="${APP_NAME}"
```

## Development

### Running Development Server

```bash
# Start Laravel development server
php artisan serve

# In another terminal, watch for asset changes
npm run watch

# Or use hot module replacement
npm run hot
```

### Laravel Nova Admin Panel

Access the admin panel at `http://localhost:8000/nova` (credentials set during seeding)

### Code Style

Format PHP code:
```bash
./vendor/bin/php-cs-fixer fix
```

### Debugging

- **Laravel Telescope**: Available at `/telescope` when `APP_DEBUG=true`
- **Laravel Debugbar**: Automatically displayed at the bottom of pages in debug mode

## Testing

The project uses Pest PHP for testing.

### Run All Tests
```bash
php artisan test
```

Or using Pest directly:
```bash
./vendor/bin/pest
```

### Run Specific Test Suite
```bash
php artisan test --filter=ProviderTest
```

### Generate Code Coverage
```bash
./vendor/bin/pest --coverage
```

## Deployment

### Laravel Vapor Deployment

This project is configured for deployment using Laravel Vapor.

1. Install Vapor CLI:
```bash
composer require laravel/vapor-cli
```

2. Login to Vapor:
```bash
vapor login
```

3. Deploy to staging:
```bash
vapor deploy staging
```

4. Deploy to production:
```bash
vapor deploy production
```

### Docker Deployment

Docker configuration files are included:

```bash
# Build Docker image
docker-compose build

# Start containers
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate --seed
```

### Manual Deployment

1. Clone repository on server
2. Run `composer install --optimize-autoloader --no-dev`
3. Run `npm install && npm run production`
4. Configure `.env` for production
5. Run `php artisan migrate --force`
6. Set up proper file permissions for `storage` and `bootstrap/cache`
7. Configure web server (Nginx/Apache) to point to `public` directory

## Project Structure

```
bpca/
├── app/                    # Application code
│   ├── Http/              # Controllers, middleware, requests
│   ├── Models/            # Eloquent models
│   ├── Nova/              # Laravel Nova resources
│   └── Services/          # Business logic services
├── config/                # Configuration files
├── database/              # Migrations, seeders, factories
├── public/                # Public assets
├── resources/             # Views, React components, assets
│   ├── js/               # React/TypeScript components
│   ├── css/              # Stylesheets
│   └── views/            # Blade templates
├── routes/                # Route definitions
│   ├── web.php           # Web routes
│   ├── api.php           # API routes
│   └── nova.php          # Nova routes
├── storage/               # Logs, cache, uploads
├── tests/                 # Test files
└── vendor/                # Composer dependencies
```

## Key Packages

### Backend Packages
- `laravel/nova` - Admin panel
- `laravel/sanctum` - API authentication
- `laravel/vapor-core` - Vapor serverless integration
- `inertiajs/inertia-laravel` - Server-side Inertia adapter
- `matanyadaev/laravel-eloquent-spatial` - Spatial data types
- `bensampo/laravel-enum` - PHP enumerations
- `tightenco/ziggy` - JavaScript route helper

### Frontend Packages
- `@inertiajs/inertia-react` - Inertia React adapter
- `@reduxjs/toolkit` - State management
- `@heroicons/react` - Icon library
- `@googlemaps/react-wrapper` - Google Maps wrapper
- `leaflet` - Interactive maps
- `react-router-dom` - Client-side routing
- `tailwindcss` - CSS framework

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For issues, questions, or contributions, please visit the [GitHub repository](https://github.com/your-username/bpca/issues).

---

Built with Laravel, React, and Inertia.js
