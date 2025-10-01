#!/bin/bash

# Start PHP built-in web server
# Default port is 8080, but Railpack may set PORT environment variable
PORT=${PORT:-8080}

echo "Starting PHP server on port $PORT..."
php -S 0.0.0.0:$PORT -t . mailler.php
