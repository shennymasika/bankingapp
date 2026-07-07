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
        
CREATE TABLE account_type(
    id int auto_increment primary key,
    account_type VARCHAR(50)
);
insert into account_type(account_type)
VALUES
('Current'),
('Savings'),
('Fixed Deposit');

CREATE TABLE account(
id int AUTO_INCREMENT primary key,
account_number varchar(12) UNIQUE not null,
account_typeID int not null,    
date_created timestamp DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (account_typeID) REFERENCES account_type(id)
);

CREATE TABLE transaction(
transaction_id INT AUTO_INCREMENT primary key,
account_id INT not null,
transaction_type ENUM('Deposit','Withdrawal','Transfer'),
amount DECIMAL(12,2) not null,
description VARCHAR(255),
transaction_date timestamp DEFAULT CURRENT_TIMESTAMP,
);

CREATE TABLE beneficiaries(
beneficiary_id int AUTO_INCREMENT primary key,
user_id int not null,
beneficiary_name VARCHAR(100),
beneficiary_account VARCHAR(20),
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);