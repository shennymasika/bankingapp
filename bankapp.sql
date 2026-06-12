CREATE DATABASE bank_app;

USE bank_app;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    balance DECIMAL(10,2) DEFAULT 0.00
);

INSERT INTO users (username, password, balance)
VALUES ('Nisha', MD5('1234'), 5000.00),
        ('Masika', MD5('1234'), 10000.00),
        ('Shenny', MD5('1234'), 7000.00);