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
   itemImage: str
   itemImageType: str



class WareHouseItem(Base):
    __tablename__ = "WareHouseInventory"
    itemID: Mapped[int] = mapped_column(Integer, primary_key=True, autoincrement=True)
    storageID:  Mapped[int] = mapped_column(index=True)
    itemName: Mapped[str] = mapped_column(String(255))
    itemDescription: Mapped[str] = mapped_column(String(255))
    itemQuantity: Mapped[int]= mapped_column(Integer)
    itemImage: Mapped[bytes] = mapped_column(LargeBinary)
    itemImageType: Mapped[str] = mapped_column(String(100))
    
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


app = FastAPI()
@app.on_event("startup")
def on_startup():
    createDbAndTables()

#Should be done 
@app.post("wareHouseItem/storageID/{storageID}/itemName/{itemName}/itemDescription/{itemDescription}/itemQuantity/{itemQuantity}/itemImage/{itemImage}/itemImageType/{itemImageType}")
def insertWareHouseItem(storageID: str, itemName: str,itemDescription:str, itemQuantity:int,itemImage:str,db:Session = Depends(getSession)):

    item = wareHouseItem()
    item.storageID = storageID
    item.itemName = itemName
    item.itemDescription = itemDescription
    item.itemQuantity = itemQuantity
    item.itemImage = itemImage
    item.itemImageType = itemImageType
   
    db.add(item)
    db.commit()
    db.refresh(item)
    return item
    
#working
@app.get("warehouse/itemID/{itemID}")
def getItem(itemID: int, db: Session = Depends(getSession)):
    item = db.query(wareHouseItem).filter(wareHouseItem.itemID() == itemID).first()

    return item.__dict__

@app.put("wareHouseItem/itemID/{itemID}/itemQuantity/{itemQuantity}")
def updateItemQty(itemID: int, itemQuantity: int, db: Session = Depends(getSession)):
     item = db.query(wareHouseItem).filter(wareHouseItem.itemID == itemID).first()
     item.itemQuantity = itemQuantity
    
     return item.__dict__