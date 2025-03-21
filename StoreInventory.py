from fastapi import FastAPI, Depends, HTTPException
from pydantic import BaseModel, Field
from sqlalchemy import Column, Integer, String, create_engine, select
from sqlalchemy.orm import Mapped,mapped_column,Session, DeclarativeBase, sessionmaker
from typing import Optional
from pymysql import install_as_MySQLdb
from sqlalchemy_utils import database_exists, create_database

install_as_MySQLdb()

class Base(DeclarativeBase):
    pass

class Item(BaseModel):
    storeItemID: Optional[int]
    storeID: int
    itemID: int 
    inStock: str 
    storeItemQuantity: int 


class StoreInventoryItem(Base):
    __tablename__ = "StoreInventory"
    storeItemID: Mapped[int] = mapped_column(Integer, primary_key=True, autoincrement=True)
    storeID:  Mapped[int] = mapped_column(index=True)
    itemID:   Mapped[int] = mapped_column(Integer)
    inStock: Mapped[str] = mapped_column(String(1))
    storeItemQuantity: Mapped[int]= mapped_column(Integer)
    
mariadbCon = "mariadb://pmaUser:pma@127.0.0.1/StoreInventory"
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
@app.post("/storeItem/storeID/{storeID}/itemID/{itemID}/inStock/{inStock}/storeItemQuantity/{storeItemQuantity}")
def insertStoreItem(storeID: int, itemID: int, inStock: str, storeItemQuantity:int,db:Session = Depends(getSession)):

    item = StoreInventoryItem()
    item.storeID = storeID
    item.itemID = itemID
    item.inStock = inStock
    item.storeItemQuantity = storeItemQuantity
   
    db.add(item)
    db.commit()
    db.refresh(item)
    return item

#working
@app.get("/store/storeID/{storeID}")
def readStoreInventory(storeID:int,db:Session = Depends(getSession)):
    stmt = select(StoreInventoryItem)
    result = db.query(StoreInventoryItem).filter(StoreInventoryItem.storeID == storeID)
    inventory = []
    [inventory.append(row.__dict__) for row in result]
    return inventory
    
#working
@app.get("/store/storeID/{storeID}/itemID/{itemID}")
def getItem(storeID: int,itemID: int, db: Session = Depends(getSession)):
    item = db.query(StoreInventoryItem).filter(StoreInventoryItem.storeID == storeID).filter(StoreInventoryItem.itemID == itemID).first()

    return item.__dict__

@app.put("/storeItem/storeID/{storeID}/itemID/{itemID}/storeItemQuantity/{storeItemQuantity}")
def updateItemQty(storeID: int,itemID: int, storeItemQuantity: int, db: Session = Depends(getSession)):
     item = db.query(StoreInventoryItem).filter(StoreInventoryItem.storeID == storeID).filter(StoreInventoryItem.itemID == itemID).first()
     if storeItemQuantity == 0:
        item.inStock = 'N'
        item.storeItemQuantity =storeItemQuantity
     else:
        item.inStock = 'Y'
        item.storeItemQuantity =storeItemQuantity
    
     return item.__dict__
