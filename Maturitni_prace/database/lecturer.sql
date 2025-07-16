-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

drop database if exists TeacherDigitalAgency;
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
    Location VARCHAR(50) not null,
    Claim TEXT not null,
    Bio TEXT not null,
    PricePerHour DECIMAL(10, 2) not null,
    TelephoneNumber varchar(20),
    Email varchar(50) not null unique
);


-- Create the Tag table
CREATE TABLE IF NOT EXISTS Tag (
    UUID INT not null auto_increment PRIMARY KEY,
    Name VARCHAR(50) not null unique
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
    Email varchar(50) not null unique,
    Password char(64) not null,
    role enum("host", "admin") not null
);


-- Create the ProfPic table

CREATE TABLE if not exists ProfPic (
   UUID INT AUTO_INCREMENT PRIMARY KEY,
   Name VARCHAR(255) NOT NULL,
   LecturerUUID int not null unique,
   unique (Name)
);
