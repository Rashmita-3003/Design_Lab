CREATE TABLE fees (
 id int(11) NOT NULL AUTO_INCREMENT primary key,
 image longblob,
 email VARCHAR(50) NOT NULL,
 uploaded DATETIME DEFAULT CURRENT_TIMESTAMP
);