from fastapi import FastAPI, Depends, HTTPException
from pydantic import BaseModel, Field
from sqlalchemy import Column, Integer, String, LargeBinary, create_engine, select
from sqlalchemy.orm import Mapped,mapped_column,Session, DeclarativeBase, sessionmaker
from typing import Optional
from pymysql import install_as_MySQLdb
from sqlalchemy_utils import database_exists, create_database

install_as_MySQLdb()

class Base(DeclarativeBase):
    pass

class Item(BaseModel):
   itemID: int
   storageID: int
   itemName: str
   itemDescription: str
   itemQuantity: int
   itemImagePath: str



class WareHouseItem(Base):
    __tablename__ = "WareHouseInventory"
    itemID: Mapped[int] = mapped_column(Integer, primary_key=True, autoincrement=True)
    storageID:  Mapped[int] = mapped_column(index=True)
    itemName: Mapped[str] = mapped_column(String(255),index=True, unique=True)
    itemDescription: Mapped[str] = mapped_column(String(255))
    itemQuantity: Mapped[int]= mapped_column(Integer)
    itemImagePath: Mapped[Optional[str]] = mapped_column(String(255))
    
mariadbCon = "mariadb://pmaUser:pma@127.0.0.1/WareHouseInventory"
engine = create_engine(mariadbCon)
if not database_exists(engine.url):
    create_database(engine.url)
    print("Database has been created!\n")
    
sessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

def createDbAndTables():
    Base.metadata.create_all(engine)

def getSession():
    db = sessionLocal()
    try:
        yield db
    except:
        print("failed to start session")
        raise
    finally:
        db.close()


app = FastAPI(max_body_size=52428800)
@app.on_event("startup")
def on_startup():
    createDbAndTables()


#Should be done 
@app.post("/wareHouseItem/storageID/{storageID}/itemName/{itemName}/itemDescription/{itemDescription}/itemQuantity/{itemQuantity}/itemImagePath/{itemImagePath}")
def insertWareHouseItem(storageID: str, itemName: str,itemDescription:str, itemQuantity:int, itemImagePath:str, db:Session = Depends(getSession)):

    item = WareHouseItem()
    item.storageID = storageID
    item.itemName = itemName
    item.itemDescription = itemDescription
    item.itemQuantity = itemQuantity
    item.itemImagePath = itemImagePath
   
    db.add(item)
    db.commit()
    db.refresh(item)
    return {'Message' : "Item was Inserted"}
    
#working
@app.get("/warehouse/itemName/{itemName}")
def getItem(itemName: str, db: Session = Depends(getSession)):
    item = db.query(WareHouseItem).filter(WareHouseItem.itemName == itemName).first()
    return item.__dict__
    

@app.put("/wareHouseItem/itemName/{itemName}/itemQuantity/{itemQuantity}")
def updateItemQty(itemName: str, itemQuantity: int, db: Session = Depends(getSession)):
     item = db.query(WareHouseItem).filter(WareHouseItem.itemName == itemName).first()
     return item.__dict__
     
     
