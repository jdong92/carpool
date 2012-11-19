CREATE TABLE IF NOT EXISTS `users` (

`username` CHAR(100) NOT NULL,
`firstname` CHAR(100) NOT NULL,
`lastname` CHAR(100) NOT NULL,
`age` INT(10) NOT NULL,
`email` CHAR(100) NOT NULL,
`gender` CHAR(1) NOT NULL,
`passhash` CHAR(100) NOT NULL,

PRIMARY KEY(`username`)

);

CREATE TABLE IF NOT EXISTS `cars` (

`car_id` INT(50) NOT NULL AUTO_INCREMENT,
`cartype` CHAR(50),
`neatness` CHAR(50),
`color` CHAR(50),
`seats` INT(50),

PRIMARY KEY(`car_id`)

);

CREATE TABLE IF NOT EXISTS `carpool` (

`car_id` INT(50),
`carpool_id` INT(50) NOT NULL AUTO_INCREMENT,
`datetime` CHAR(50),
`duration` CHAR(50),
`numberofpassengers` INT(10),
`startingtime` CHAR(50) NOT NULL,
`endingtime` CHAR(50) NOT NULL,
`recurrencelevel` INT(10),

PRIMARY KEY(`carpool_id`),
FOREIGN KEY(`car_id`) REFERENCES cars ON DELETE SET NULL ON UPDATE CASCADE

);

CREATE TABLE IF NOT EXISTS `driver` (

`username` CHAR(50) NOT NULL,
`carpool_id` INT(50) NOT NULL,

FOREIGN KEY (`username`) REFERENCES account ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (`carpool_id`) REFERENCES carpool ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `passenger` (

`username` CHAR(50) NOT NULL,
`carpool_id` INT(50) NOT NULL,

FOREIGN KEY (`username`) REFERENCES account ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (`carpool_id`) REFERENCES carpool ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `startinglocation` (

`startinglocation_id` INT(100) NOT NULL AUTO_INCREMENT,
`address` VARCHAR(200) NOT NULL,
`zipcode` CHAR(50) NOT NULL,
`city` CHAR(50) NOT NULL,
`state` CHAR(50) NOT NULL,
`longitude` FLOAT(10) NOT NULL,
`latitude` FLOAT(10) NOT NULL,

PRIMARY KEY(`startinglocation_id`)

);

CREATE TABLE IF NOT EXISTS `endinglocation` (

`endinglocation_id` INT(100) NOT NULL AUTO_INCREMENT,
`address` VARCHAR(200) NOT NULL,
`zipcode` CHAR(50) NOT NULL,
`city` CHAR(50) NOT NULL,
`state` CHAR(50) NOT NULL,
`longitude` FLOAT(10) NOT NULL,
`latitude` FLOAT(10) NOT NULL,

PRIMARY KEY(`endinglocation_id`)
);

