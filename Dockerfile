# Use an official base image (you should change this to your appropriate language/runtime)
FROM php:7.4-apache

# Install dependencies (example: Python, Node, C++ compilers, etc.)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY ./src/ /var/www/html/
COPY ./assets/ /var/www/html/assets/
COPY ./vendor/ /var/www/html/vendor/

# Expose the port the app runs on (If required)
EXPOSE 80

# Example: Install Node.js deps
# RUN npm install

# Example: Install Python deps
# RUN pip install -r requirements.txt

# Default command (you should change this)
CMD ["echo", "Hello from Docker! Customize me in Dockerfile."]
