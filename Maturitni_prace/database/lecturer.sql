-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- drop database if exists TeacherDigitalAgency;
-- Create the database
CREATE DATABASE IF NOT EXISTS TeacherDigitalAgency;
USE TeacherDigitalAgency;

-- Create the Lecturer table
CREATE TABLE IF NOT EXISTS Lecturer (
    UUID INT not null auto_increment PRIMARY KEY,
    TitleBefore VARCHAR(10),
    FirstName VARCHAR(50) not null,
    MiddleName VARCHAR(50),
    LastName VARCHAR(50) not null,
    TitleAfter VARCHAR(10),
    PictureURL VARCHAR(255),
    Location VARCHAR(50) not null,
    Claim TEXT not null,
    Bio TEXT not null,
    PricePerHour DECIMAL(10, 2) not null
    -- PRIMARY_CONTACT_UUID INT,
    -- FOREIGN KEY (PRIMARY_CONTACT_UUID) REFERENCES Contact(UUID)
);

/*
alter table Lecturer
drop column PictureURL;
add TelephoneNumber varchar(20);
add Email varchar(50) not null;*/

-- Create the Contact table
/*CREATE TABLE IF NOT EXISTS Contact (
    UUID INT not null auto_increment PRIMARY KEY,
    LecturerUUID INT not null,
    TelephoneNumbers JSON,
    Emails JSON not null,
	FOREIGN KEY (LecturerUUID) REFERENCES Lecturer(UUID)
);*/

drop table Contact;

-- Create the Tag table
CREATE TABLE IF NOT EXISTS Tag (
    UUID INT not null auto_increment PRIMARY KEY,
    Name VARCHAR(50)
);

-- Create the LecturerTag table
CREATE TABLE if not exists LecturerTag (
    LecturerUUID INT not null,
    TagUUID INT not null,
    PRIMARY KEY (LecturerUUID, TagUUID),
    FOREIGN KEY (LecturerUUID) REFERENCES Lecturer(UUID),
    FOREIGN KEY (TagUUID) REFERENCES Tag(UUID)
);

-- Create the User table
-- admin password = 12345

CREATE TABLE if not exists User (
    UUID int not null auto_increment primary KEY ,
    UserName VARCHAR(50) not null,
    Email VARCHAR(50) not null unique,
    Password VARCHAR(50) not null
);

alter table user
modify column Password char(64) not null;

alter table user
add role enum("host", "admin");

CREATE TABLE if not exists ProfPic (
   UUID INT AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(255) NOT NULL,
   LecturerUUID int not null,
   unique (name)
);
