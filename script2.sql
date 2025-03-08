drop database if exists Orders;
drop user if exists 'user'@'localhost';
create database Orders;
use Orders;

create user 'user'@'localhost' identified by 'pass';
grant all on Orders.* to 'user'@'localhost';

USE Orders;

CREATE TABLE Orders(
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    customerID INT NOT NULL,
    orderStatus VARCHAR(255) NOT NULL,
    orderDateCreated DATETIME NOT NULL
);

CREATE TABLE OrderList(
    orderID INT NOT NULL,
    storeInventoryItemID INT NOT NULL,
    PRIMARY KEY(orderID, storeInventoryItemID)
);

INSERT INTO Orders(customerID, orderStatus, orderDateCreated) VALUES (
    1,"active", "2025-03-07"
);

Insert INTO OrderList(orderID, storeInventoryItemID) VALUES (
    1, 1
)

