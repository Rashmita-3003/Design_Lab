CREATE TABLE Teacher (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username varchar(50) not null ,
    email VARCHAR(50) NOT NULL ,
    pass VARCHAR(255) NOT NULL,
    contact_number bigint not null ,
    addr varchar(100),
    gender varchar(10) not null,
    class varchar(100),
    board varchar(50),
    medium varchar(50),
    subjects varchar(500),
    qualification varchar(100),
    bank_name varchar(50),
    acc_no bigint,
    IFSC varchar(50),
    Branch varchar(50),
    link varchar(500),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);