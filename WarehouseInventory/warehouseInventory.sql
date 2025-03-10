drop database if exists warehouseInventory;
drop user if exists 'user'@'localhost';
create database warehouseInventory;
use warehouseInventory;

create user 'user'@'localhost' identified by 'pass';
grant all on warehouseInventory.* to 'user'@'localhost';

USE warehouseInventory;

CREATE TABLE warehouseInventory(
    itemQuanity INT(1000),
    itemID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    storageID INT AUTO_INCREMENT NOT NULL,
    itemName VARCHAR(100) NOT NULL,
    itemDescription VARCHAR(150) NOT NULL
);
