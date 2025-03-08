from fastapi import FastAPI, Depends, HTTPException
from pydantic import BaseModel, Field
from sqlalchemy import Column, Integer, String, DateTime, create_engine
from sqlalchemy.orm import Session, declarative_base, sessionmaker
from typing import Optional
from datetime import datetime

base = declarative_base()

class Orders(base):
    __tablename__ = "Orders"
    orderID = Column(Integer, primary_key = True, index = True)
    customerID = Column(Integer)
    orderStatus = Column(String)
    orderDateCreated = Column(DateTime)

class OrderLists(base):
    __tablename__ = "OrderList"
    orderID = Column(Integer, primary_key = True, index = True)
    storeInventoryItemID = Column(Integer, primary_key = True)

class Order(BaseModel):
    orderID: Optional[int] = None
    customerID: int
    orderStatus: str = Field(max_length=255)
    orderDateCreated: datetime

class OrderList(BaseModel):
    orderID: int
    storeInventoryItemID: int


app = FastAPI()

databaseURL = "mariadb://user:pass@localhost/Orders"
engine = create_engine(databaseURL)
sessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)
base.metadata.create_all(bind=engine)

def getSession():
    db = sessionLocal()
    try:
        yield db
    except:
        print("failed to start session")
    finally:
        db.close()

@app.get("/customerID/{customerID}/orderDateCreated/{orderDateCreated}")

def getOrderID(customerID: int, orderDateCreated: str, db:Session = Depends(getSession)):

    dateFormat = "%Y-%m-%d"
    date = datetime.strptime(orderDateCreated, dateFormat)

    results = db.query(Orders).filter(Orders.customerID == customerID and Orders.orderDateCreated == date).first()

    return results

@app.post("/customerID/{customerID}/orderStatus/{orderStatus}/orderDateCreated/{orderDateCreated}/")

def createOrder(customerID: int, orderStatus: str, orderDateCreated: str, db:Session = Depends(getSession)):

    dateFormat = "%Y-%m-%d"
    date = datetime.strptime(orderDateCreated, dateFormat)

    order = Orders()

    order.customerID = customerID
    order.orderStatus = orderStatus
    order.orderDateCreated = date

    db.add(order)
    db.commit()

#avoid identical calls so orders is without grouping
@app.get("/{orderID}")

def getOrder(orderID: int, db:Session = Depends(getSession)):

   return db.query(Orders).filter(Orders.orderID == orderID).first()

@app.get("/orderID/{orderID}")

def getOrderList(orderID: int, db:Session = Depends(getSession)):

    return db.query(OrderLists).filter(OrderLists.orderID == orderID).all()

@app.get("orderID/{orderID}/storeInventoryItemID/{storeInventoryItemID}")

def createOrderList(orderID: int, storeInventoryItemID: int, db:Session = Depends(getSession)):

    orderList = OrderLists()

    orderList.orderID = orderID
    orderList.storeInventoryItemID = storeInventoryItemID

    db.add(orderList)
    db.commit()