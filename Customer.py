from fastapi import FastAPI, Depends, HTTPException
from pydantic import BaseModel, Field
from sqlalchemy import Column, Integer, String, create_engine
from sqlalchemy.orm import Session, declarative_base, sessionmaker
from typing import Optional


base = declarative_base()

class Customers(base):
    __tablename__ = "Customers"
    customerID = Column(Integer, primary_key=True, index=True)
    username = Column(String)
    passwrd = Column(String)
    fullName = Column(String)
    email = Column(String)
    customerAddress = Column(String)
    phoneNumber = Column(String)

class Customer(BaseModel):
    customerID: Optional[int] = None
    username: str = Field(max_length=255)
    passwrd: str = Field(max_length=255)
    fullName: str= Field(max_length=255)
    email: str= Field(max_length=255)
    customerAddress: str= Field(max_length=255)
    phoneNumber: str= Field(max_length=255)


app = FastAPI()

databaseURL = "mariadb://user:pass@localhost/Customer"
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

@app.get("/{id}")

def getCustomersByID(id: int, db:Session = Depends(getSession)):
    return db.query(Customers).filter(Customers.customerID == id).first()

@app.get("/username/{username}")

def getCustomerID(username: str, db: Session = Depends(getSession)):
    customer = db.query(Customers).filter(Customers.username == username).first()
    print(customer.customerID)
    return customer.customerID

@app.post("/username/{username}/password/{passwrd}")

def checkCredentials(username: str, passwrd: str, db: Session = Depends(getSession)):
    return db.query(Customers).filter(Customers.username == username, Customers.passwrd == passwrd).first()

@app.post("/username/{username}/password/{passwrd}/fullName/{fullName}/email/{email}/customerAddress/{customerAddress}/phoneNumber/{phoneNumber}")

def insertCustomer(username: str, passwrd: str, fullName: str, email: str, customerAddress: str, phoneNumber: str, db: Session = Depends(getSession)):
    customer = Customers()

    customer.username = username
    customer.passwrd = passwrd
    customer.fullName = fullName
    customer.email = email
    customer.customerAddress = customerAddress
    customer.phoneNumber = phoneNumber

    db.add(customer)
    db.commit()

    return customer