# Start from the official Ubuntu image
FROM ubuntu:latest

# Set environment variable to prevent interactive prompts
ENV DEBIAN_FRONTEND=noninteractive

# Install Nginx, PHP 8.1 FPM, and other utilities
RUN apt update && \
    apt upgrade -y && \
    apt install -y nginx php8.1-fpm nano && \
    apt clean && rm -rf /var/lib/apt/lists/*

# Copy configurations
COPY ./volumes/nginx_config/nginx.conf /etc/nginx/nginx.conf
COPY ./volumes/nginx_config/default /etc/nginx/sites-available/default
COPY ./volumes/html_secure /var/www/html

# Set permissions
RUN chmod -R 755 /var/www/html

# Expose ports 80 (HTTP) and 443 (HTTPS)
EXPOSE 80 443

# Start Nginx and PHP-FPM
CMD service nginx start && /usr/sbin/php-fpm8.1 -R && tail -f /dev/null
