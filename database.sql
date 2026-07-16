CREATE DATABASE bank_application;

USE bank_application;

create table account_type(
    id int auto_increment primary key,
    account_type varchar(50)
);

insert into account_type(account_type)
values
('Current'),
('Savings'),
('Fixed Deposit');

create table account(
id int AUTO_INCREMENT PRIMARY KEY,
account_number varchar(12) UNIQUE not null,
account_typeID int not null,
date_created timestamp DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (account_typeID) REFERENCES account_type(id)
);

insert into account(account_number, account_typeID)
values
('1234567890', 1),
('1234567891', 2),
('1234567892', 3);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    balance DECIMAL(10,2) DEFAULT 0.00,
    account_id INT,
    FOREIGN KEY (account_id) REFERENCES account(id)
);

INSERT INTO users (username, password, balance, account_id)
VALUES ('onesmus', MD5('1234'), 5000.00, 1),
        ('nisha', MD5('1234'), 10000.00,2),
        ('victor', MD5('1234'), 2000.00,3);

-- query to get the users and their respective account numbers
SELECT u.username, a.account_number
FROM users u
JOIN account a ON u.account_id = a.id;

-- query to select user and in the respective account types
SELECT u.username, at.account_type
FROM users u
JOIN account a ON u.account_id = a.id
JOIN account_type at ON a.account_typeID = at.id;

-- example of left join
SELECT u.username, a.account_number
FROM users u
LEFT JOIN account a ON u.account_id = a.id;

-- left join between accunttype and users
SELECT u.username, at.account_type
FROM users u
LEFT JOIN account a ON u.account_id = a.id
LEFT JOIN account_type at ON a.account_typeID = at.id;

-- output all accoutypes and users. account types without users return as null
SELECT at.account_type,u.username 
FROM users u
RIGHT JOIN account a ON u.account_id = a.id
RIGHT JOIN account_type at ON a.account_typeID = at.id;

-- redo the above using a left join instead


