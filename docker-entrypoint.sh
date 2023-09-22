#!/bin/bash

# Migrate & seed
php artisan migrate
php artisan serve --host 0.0.0.0 --port 82

# CHMOD folder storage
chmod -R 777 storage
php artisan storage:link

# Start
supervisord


