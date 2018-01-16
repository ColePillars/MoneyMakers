#!/bin/bash
#
#Run:
#sudo chmod +x lamp.sh
#sudo ./lamp.sh

sudo apt-get update

sudo apt-get -y install apache2 php libapache2-mod-php php-mcrypt php-mysql

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password Temp12345'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password Temp12345'
sudo apt-get -y install mysql-server

sudo service apache2 restart