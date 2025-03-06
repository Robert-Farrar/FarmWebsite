drop database if exists Warehouse;
drop user if exists 'user'@'localhost';
create database Warehouse;
use Warehouse;

create user 'user'@'localhost' identified by 'pass';
grant all on Warehouse.* to 'user'@'localhost';

USE Warehouse;

CREATE TABLE Warehouse(
    warehouseID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    itemID INT NOT NULL FOREIGN KEY NOT NULL
);