To install Laravel on an AWS EC2 instance, you must configure a web server environment (LEMP stack with Nginx is highly recommended).Here is the complete step-by-step guide assuming you are using an Ubuntu 24.04 / 22.04 LTS instance.1. Update Server and Install System DependenciesConnect to your EC2 instance via SSH and update the core package repositories. Then, install Nginx, Git, Unzip, and PHP along with all required extensions for modern Laravel versions:bashsudo apt update && sudo apt upgrade -y

sudo apt install nginx git unzip curl -y

sudo apt install php php-fpm php-mysql php-xml php-mbstring php-curl php-zip php-bcmath -y
Usa el código con precaución.2. Install Composer GloballyLaravel uses Composer to manage its application dependencies. Download and move the installer binaries to your local executable path:bashcd ~
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
Usa el código con precaución.3. Deploy the Laravel ProjectNavigate to the default web directory. You can either generate a blank Laravel installation or clone your existing repository from GitHub:Option A: Create a fresh Laravel appbashcd /var/www
sudo composer create-project laravel/laravel my-laravel-app
Usa el código con precaución.Option B: Clone an existing projectbashcd /var/www
sudo git clone https://github.com my-laravel-app
cd my-laravel-app
sudo composer install --no-dev --optimize-autoloader
Usa el código con precaución.4. Configure Environment and App Security KeysCreate your configuration .env file from the placeholder template, then trigger the secure key generator:bashcd /var/www/my-laravel-app
sudo cp .env.example .env
sudo php artisan key:generate
Usa el código con precaución.(Make sure to use nano .env later to specify your live database or Amazon RDS connection parameters).5. Set Correct Directory PermissionsThe Nginx web user (www-data) requires ownership permissions over your Laravel working directory to write caches, compile views, and record runtime logs:bashsudo chown -R www-data:www-data /var/www/my-laravel-app
sudo chmod -R 775 /var/www/my-laravel-app/storage
sudo chmod -R 775 /var/www/my-laravel-app/bootstrap/cache
Usa el código con precaución.6. Configure Nginx Virtual HostCreate an isolated server block config file for your website deployment:bashsudo nano /etc/nginx/sites-available/laravel
Usa el código con precaución.Paste the configuration structure below, substituting example.com with your public IP address or domain name. Note: Update your fastcgi_pass PHP version string depending on what your system installed (e.g., php8.2-fpm.sock or php8.3-fpm.sock):nginxserver {
    listen 80;
    server_name example.com;
    root /var/www/my-laravel-app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
Usa el código con precaución.Enable the site configuration by linking it to the active path, drop the baseline default configuration, and restart Nginx:bashsudo ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default
sudo systemctl restart nginx
Usa el código con precaución.7. Update AWS Security GroupsFor your application to successfully respond to web visitors, verify your EC2 security group allows traffic on the following inbound rules:HTTP: Port 80 from 0.0.0.0/0HTTPS: Port 443 from 0.0.0.0/0SSH: Port 22 restricted to your local IPWould you like help setting up a local MySQL database directly on this server, configuring a managed Amazon RDS database, or generating free SSL certificates via Let's Encrypt?