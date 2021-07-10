CREATE TABLE Student (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username varchar(50) not null ,
    email VARCHAR(50) NOT NULL ,
    pass VARCHAR(255) NOT NULL,
    contact_number bigint not null ,
    addr varchar(100),
    gender varchar(10) not null,
    guardian_name varchar(50),
    guardian_phone bigint,
    class int,
    board varchar(50),
    medium varchar(50),
    subjects varchar(500),
    link varchar(500),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);