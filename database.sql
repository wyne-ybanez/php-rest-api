-- use this on on your dbms
CREATE DATABASE product_db;

CREATE TABLE product (
 id INT NOT NULL AUTO_INCREMENT,
 name VARCHAR(128) NOT NULL,
 size INT NOT NULL DEFAULT 0,
 is_available BOOLEAN NOT NULL DEFAULT FALSE,
 PRIMARY KEY (id)
);
