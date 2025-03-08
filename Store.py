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

class Store(BaseModel):
    storeID: int
    storeLocation: str


class Stores(Base):
    __tablename__ = "Stores"
    storeID:  Mapped[int] = mapped_column(Integer, primary_key=True,index=True)
    storeLocation:   Mapped[str] = mapped_column(String(100), index=True)

mariadbCon = "mariadb://pmaUser:pma@127.0.0.1/Store"
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
@app.post("/storeItem/storeID/{storeID}/storeLocation/{storeLocation}")
def insertStore(storeID: int, storeLocation: str,db:Session = Depends(getSession)):

    store = Stores()
    store.storeID = storeID
    store.storeLocation = storeLocation
   
    db.add(store)
    db.commit()
    db.refresh(store)
    return store
    
#working
@app.get("/store/storeLocation/{storeLocation}")
def getID(storeLocation:str, db: Session = Depends(getSession)):
    store = db.query(Stores).filter(Stores.storeLocation == storeLocation).first()
    print(store.storeID)
    return store.storeID

