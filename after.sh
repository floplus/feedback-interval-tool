#!/usr/bin/env bash

echo 'Installing RabbitMQ';

echo 'deb http://www.rabbitmq.com/debian/ stable main' |
        sudo tee /etc/apt/sources.list.d/rabbitmq.list

wget -O- https://www.rabbitmq.com/rabbitmq-signing-key-public.asc |
        sudo apt-key add -

sudo apt-get -y update
sudo apt-get -y install rabbitmq-server

sudo apt-get -y install php-bcmath
sudo apt-get -y install php-intl
