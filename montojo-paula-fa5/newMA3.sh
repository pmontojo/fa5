#!/bin/bash

sudo apt-get -y update  1>/tmp/01.out 2>/tmp/01.err
sudo apt-get -y install apache2 wget php5 php5-curl curl php5-mysql git 1>/tmp/02.out 2>/tmp/02.err
sudo service apache2 restart

sudo chmod 777 /var/www/html
sudo curl -sS https://getcomposer.org/installer | php


wget http://ec2-54-232-209-127.sa-east-1.compute.amazonaws.com/composer.json
sudo php composer.phar install
wget http://ec2-54-232-209-127.sa-east-1.compute.amazonaws.com/indexfinal.php
wget http://ec2-54-232-209-127.sa-east-1.compute.amazonaws.com/index4.php
wget http://ec2-54-232-209-127.sa-east-1.compute.amazonaws.com/layout2.php
wget http://ec2-54-232-209-127.sa-east-1.compute.amazonaws.com/resultfinal.php
wget http://ec2-54-232-209-127.sa-east-1.compute.amazonaws.com/result4.php
wget http://ec2-54-232-209-127.sa-east-1.compute.amazonaws.com/gallery.php

sudo mv composer.phar /var/www/html
mv /composer.lock /var/www/html
mv /composer.json /var/www/html
mv /indexfinal.php /var/www/html
mv /index4.php /var/www/html
mv /layout2.php /var/www/html
mv /resultfinal.php /var/www/html
mv /result4.php /var/www/html
mv /gallery.php /var/www/html
sudo mv vendor /var/www/html



