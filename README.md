# # FarmWebsite

## Overview
FarmWebsite is a full-stack application using a microservices architecture, where each major table has its own container, along with a FastAPI-based API and a MariaDB database instance.

## Architecture
The application consists of multiple containers, each responsible for managing a specific database table and providing API endpoints for interaction. Below is a breakdown of the containers and their respective tables:

### **1. Customers Container**
- **Table:** Customers
- **Fields:**
  - `customerID` (Primary Key) - `INT NOT NULL AUTO_INCREMENT`
  - `userName` (Unique) - `VARCHAR(50)`
  - `password` - `VARCHAR(50)`
  - `address` - `VARCHAR(100)`
  - `phoneNumber` - `VARCHAR(20)`
  - `email` - `VARCHAR(50)`
  - `fullName` - `VARCHAR(50)`
- **API Functionality:**
  - Create new customers
  - Retrieve customer details
  - Update customer information
  - Delete customer records

### **2. Warehouse Inventory Container**
- **Table:** Warehouse Inventory
- **Fields:**
  - `itemQuantity` - `INT(1000)`
  - `itemID` (Primary Key) - `INT NOT NULL AUTO_INCREMENT`
  - `storageID` - `INT NOT NULL AUTO_INCREMENT`
  - `itemName` - `VARCHAR(100)`
  - `itemDescription` - `VARCHAR(150)`
- **API Functionality:**
  - Add new inventory items
  - Update inventory quantity
  - Retrieve inventory details
  - Delete inventory records

### **3. Warehouse Container**
- **Table:** Warehouse
- **Fields:**
  - `warehouseID` (Primary Key) - `INT NOT NULL AUTO_INCREMENT`
  - `itemID` (Foreign Key) - `INT NOT NULL`
  - `warehouseLocation` (Optional) - `VARCHAR`
- **API Functionality:**
  - Manage warehouse storage locations
  - Track item movements
  - Retrieve warehouse item details

### **4. Orders Container**
- **Table:** Orders
- **Fields:**
  - `orderID` (Primary Key) - `INT NOT NULL AUTO_INCREMENT`
  - `customerID` (Foreign Key) - `INT NOT NULL`
  - `orderStatus` - `VARCHAR(25)`
  - `orderDateCreated` - `DATETIME NOT NULL`
- **API Functionality:**
  - Create new orders
  - Update order status
  - Retrieve order history
  - Delete orders

### **5. OrderList Container**
- **Table:** OrderList
- **Fields:**
  - `orderID` (Foreign Key) - `INT NOT NULL`
  - `itemID` (Foreign Key) - `INT NOT NULL`
- **API Functionality:**
  - Add items to an order
  - Retrieve items from an order
  - Remove items from an order

### **6. Store Container**
- **Table:** Store
- **Fields:**
  - `storeID` (Primary Key) - `INT NOT NULL AUTO_INCREMENT`
  - `storeLocation` - `VARCHAR(100) NOT NULL`
- **API Functionality:**
  - Add new store locations
  - Retrieve store details
  - Update store information
  - Delete stores

### **7. Store Inventory Container**
- **Table:** Store Inventory
- **Fields:**
  - `storeInventoryID` (Primary Key) - `INT NOT NULL`
  - `storeID` (Foreign Key) - `INT NOT NULL`
  - `itemID` (Foreign Key) - `INT NOT NULL`
  - `inStock` - `CHAR`
  - `storeItemQuantity` - `INT(100)`
- **API Functionality:**
  - Track store inventory levels
  - Update inventory stock
  - Retrieve inventory details for a store

## Deployment
- The project uses **Docker Compose** to manage all containers.
- Each microservice runs its own MariaDB database and FastAPI instance.
- Communication between containers is handled via Docker networking.

## Getting Started
### **Prerequisites**
- Install [Docker](https://www.docker.com/)
- Install [Docker Compose](https://docs.docker.com/compose/)

### **Setup and Run**
1. Clone this repository:
   ```sh
   git clone https://github.com/yourusername/FarmWebsite.git
   cd FarmWebsite
   ```
2. Build and start the containers:
   ```sh
   docker-compose up --build
   ```
3. Access API endpoints via:
   ```sh
   http://localhost:<assigned-port>
   ```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
This project is licensed under the MIT License.

