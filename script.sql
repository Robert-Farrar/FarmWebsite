drop database if exists Customer;
drop user if exists 'user'@'localhost';
create database Customer;
use Customer;

create user 'user'@'localhost' identified by 'pass';
grant all on Customer.* to 'user'@'localhost';

USE Customer;

CREATE TABLE Customers(
    customerID INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(255) NOT NULL UNIQUE,
    passwrd     VARCHAR(255) NOT NULL,
    fullName    VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    customerAddress     VARCHAR(255) NOT NULL,
    phoneNumber VARCHAR(255) NOT NULL

);

INSERT INTO Customers(username, passwrd, fullName, email, customerAddress, phoneNumber) VALUES (
    "jSmith", "pass", "John Smith", "email@email.com", "419 East West dr.", "4794794790"
);

