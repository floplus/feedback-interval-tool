CREATE DATABASE fit;
CREATE USER 'fit'@'192.168.99.1' IDENTIFIED BY 'fit';
GRANT ALL ON `fit`.* TO 'fit'@'192.168.99.1';
