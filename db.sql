CREATE DATABASE PhoneBook;
GO
USE PhoneBook
CREATE TABLE users(	
id int NOT NULL identity,	
username varchar(50) NOT NULL UNIQUE,
email varchar(50) NOT NULL UNIQUE,	
password char(96) NOT NULL,		
PRIMARY KEY(id)
); 

CREATE TABLE phoneNumber(	
id int NOT NULL identity,
name varchar(50) NOT NULL,
user_id int NOT NULL,	
number varchar(20) NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(user_id) REFERENCES users(id)
);