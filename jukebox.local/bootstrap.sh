#!/usr/bin/env bash

PASSWORD='w3dding'

# nginx
sudo apt-get update
sudo apt-get install -y nginx php5-fpm mpd


sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
sudo apt-get -y install mysql-server
sudo apt-get install php5-mysql

# set up nginx server

sudo cp /home/vagrant/jukebox/.provision/nginx/nginx.conf /etc/nginx/sites-available/site.conf
sudo rm -rf /etc/nginx/sites-available/default
sudo chmod 644 /etc/nginx/sites-available/site.conf

if [ -f "/etc/nginx/sites-enabled/site.conf" ]
then
	echo "site already enabled"
else
    sudo ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf
fi

# clean /var/www
sudo rm -Rf /var/www

# symlink /var/www => /vagrant
ln -s /home/vagrant/jukebox /var/www

sudo service nginx restart
