Create database tables with these SQL queries:
'''
CREATE TABLE users (
idUsers int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
uidUsers TINYTEXT NOT NULL,
emailUsers TINYTEXT NOT NULL,
pwdUsers LONGTEXT NOT NULL,
userType TINYTEXT NOT NULL
);

CREATE TABLE classes (
    idClasses int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nameClasses TEXT NOT NULL
);

CREATE TABLE enrollments (
    idEnrollments int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    uidUsers TINYTEXT NOT NULL,
    userType TINYTEXT NOT NULL,
    nameClasses TEXT NOT NULL
);

CREATE TABLE profileimg (
	id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idUsers int(11) NOT NULL,
    status int(11) NOT NULL
);
'''
