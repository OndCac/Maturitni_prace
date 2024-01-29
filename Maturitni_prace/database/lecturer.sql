-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- Create the database
CREATE DATABASE IF NOT EXISTS TeacherDigitalAgency;
USE TeacherDigitalAgency;

-- Create the Lecturer table
CREATE TABLE IF NOT EXISTS Lecturer (
    UUID INT auto_increment PRIMARY KEY,
    TitleBefore VARCHAR(10),
    FirstName VARCHAR(50),
    MiddleName VARCHAR(50),
    LastName VARCHAR(50),
    TitleAfter VARCHAR(10),
    PictureURL VARCHAR(255),
    Location VARCHAR(50),
    Claim TEXT,
    Bio TEXT,
    PricePerHour DECIMAL(10, 2)
    -- PRIMARY_CONTACT_UUID INT,
    -- FOREIGN KEY (PRIMARY_CONTACT_UUID) REFERENCES Contact(UUID)
);

-- Create the Contact table
CREATE TABLE IF NOT EXISTS Contact (
    UUID INT(36) auto_increment PRIMARY KEY,
    LecturerUUID INT,
    TelephoneNumbers JSON,
    Emails JSON,
	FOREIGN KEY (LecturerUUID) REFERENCES Lecturer(UUID)
);

-- Create the Tag table
CREATE TABLE IF NOT EXISTS Tag (
    UUID INT(36) auto_increment PRIMARY KEY,
    Name VARCHAR(50)
);

-- Create the LecturerTag table
CREATE TABLE if not exists LecturerTag (
    LecturerUUID INT(36),
    TagUUID INT(36),
    PRIMARY KEY (LecturerUUID, TagUUID),
    FOREIGN KEY (LecturerUUID) REFERENCES Lecturer(UUID),
    FOREIGN KEY (TagUUID) REFERENCES Tag(UUID)
);

-- Create the User table

CREATE TABLE if not exists User (
    UUID int not null auto_increment primary KEY ,
    UserName VARCHAR(50) not null,
    Email VARCHAR(50) not null unique,
    Password VARCHAR(50) not null
);

alter table User
drop column LoggedIn;