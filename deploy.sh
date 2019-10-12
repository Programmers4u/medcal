# Change to the project directory
cd /var/www/yourcalendar

# Turn on maintenance mode
 php artisan down

# Pull the latest changes from the git repository
git pull origin production 

# Install/update composer dependecies
# composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear

# Clear expired password reset tokens
php artisan auth:clear-resets

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Optimize
php artisan clear-compiled
php artisan optimize 

# Turn off maintenance mode
php artisan up