CREATE SCHEMA IF NOT EXISTS `appthis`;
CREATE USER IF NOT EXISTS 'maja'@'%' IDENTIFIED BY 'adfh376gf7';
GRANT ALL PRIVILEGES ON `appthis`.* TO 'maja'@'%';