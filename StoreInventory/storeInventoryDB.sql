drop database if exists storeInventory;
drop user if exists 'user'@'localhost';
create database storeInventory;
use storeInventory;

create user 'user'@'localhost' identified by 'pass';
grant all on storeInventory.* to 'user'@'localhost';

USE storeInventory

CREATE TABLE storeInventory(
    storeInventoryID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    storeID INT NOT NULL FOREIGN KEY NOT NULL,
    itemID INT NOT NULL FOREIGN KEY NOT NULL,
    inStock VARCHAR(500) NOT NULL,
    storeItemQuantity INT(100) NOT NULL
);