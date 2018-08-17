#!/bin/bash
# Install composer
sudo apt-get -y --force-yes install curl php-cli

curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

cd /var/www/task_api/protected

composer update

cd ~