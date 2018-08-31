

## How to install Laravel on VPS
Dev marketer tutorial


•	sudo apt-get update
•	sudo apt-get install nginx
•	sudo apt-get install software-properties-common
•	sudo add-apt-repository ppa:ondrej/php
•	sudo apt update
•	sudo apt install php7.2-fpm php7.2-common php7.2-mbstring php7.2-xmlrpc php7.2-soap php7.2-gd php7.2-xml php7.2-intl php7.2-mysql php7.2-cli php7.2-zip php7.2-curl
•	sudo nano /etc/php/7.2/fpm/php.ini
a.	make it like it: cgi.fix_pathinfo=0
•	sudo apt-get install mysql-server
•	sudo mysql_secure_installation
•	sudo nano /etc/nginx/sites-available/default
a.	root /var/www/laravel/public;
 index index.php index.html index.htm index.nginx-debian.html;
b.	server_name 107.191.44.91;
c.	 Edit and uncomment:


location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.2-fpm.sock;
    }


    location ~ /\.ht {
        deny all;
    } 
	
try_files $uri $uri/ /index.php?$query_string;

d.	Add this code
location /phpmyadmin {
               root /usr/share/;
               index index.php index.html index.htm;
               location ~ ^/phpmyadmin/(.+\.php)$ {
                       try_files $uri =404;
                       root /usr/share/;
                       fastcgi_pass unix:/run/php/php7.2-fpm.sock;
                       fastcgi_index index.php;
                       fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                       include /etc/nginx/fastcgi_params;
               }
               location ~* ^/phpmyadmin/(.+\.(jpg|jpeg|gif|css|png|js|ico|html|xml|txt))$ {
                       root /usr/share/;
               }
        }
        location /phpMyAdmin {
               rewrite ^/* /phpmyadmin last;
        }

•	sudo systemctl reload nginx
•	sudo systemctl restart php7.2-fpm.service
•	sudo apt-get update
•	sudo apt-get install phpmyadmin

•	sudo mkdir -p /var/www/laravel
•	sudo service nginx restart

Composer:
•	cd ~
•	curl -sS https://getcomposer.org/installer | php
•	sudo mv composer.phar /usr/local/bin/composer
Git:
•	cd /var
•	mkdir repo && cd repo
•	mkdir site.git && cd site.git
•	git init –bare
•	sudo nano post-receive
•		#!/bin/sh
o	git --work-tree=/var/www/laravel --git-dir=/var/repo/site.git checkout –f
•	sudo chmod +x post-receive      

•	sudo chown -R :www-data /var/www/laravel
•	sudo chmod -R 775 /var/www/laravel/storage
•	sudo chmod -R 775 /var/www/laravel/bootstrap/cache
•	composer install --no-dev
•	php artisan key:generate


