-- MySQL Script generated by MySQL Workbench
-- mar 15 nov 2016 14:06:01 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP DATABASE IF EXISTS SportNet;
CREATE DATABASE SportNet;

USE SportNet;
-- -----------------------------------------------------
-- Table `Discipline`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `discipline` ;

CREATE TABLE IF NOT EXISTS `discipline` (
  `id` INT NOT NULL auto_increment,
  `name` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Promoter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `promoter` ;

CREATE TABLE IF NOT EXISTS `promoter` (
  `id` INT NOT NULL auto_increment,
  `name` VARCHAR(255) NULL,
  `mail` VARCHAR(255) NULL,
  `login` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `event` ;

CREATE TABLE IF NOT EXISTS `event` (
  `id` INT NOT NULL auto_increment,
  `name` VARCHAR(255) NULL,
  `description` VARCHAR(500) NULL,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  `status` INT(11) NULL,
  `addresse` varchar(100) NULL,
  `id_promoter` INT NULL,
  `id_discipline` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_event_promoter_idx` (`id_promoter` ASC),
  INDEX `fk_event_discipline_idx` (`id_discipline` ASC),
  CONSTRAINT `fk_event_promoter`
    FOREIGN KEY (`id_promoter`)
    REFERENCES `promoter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_discipline`
    FOREIGN KEY (`id_discipline`)
    REFERENCES `discipline` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Activity`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `activity` ;

CREATE TABLE IF NOT EXISTS `activity` (
  `id` INT NOT NULL auto_increment,
  `name` VARCHAR(255) NULL,
  `description` VARCHAR(500) NULL,
  `price` DECIMAL NULL,
  `date` DATETIME NULL,
  `id_event` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Activity_Event_idx` (`id_event` ASC),
  CONSTRAINT `fk_activity_event`
    FOREIGN KEY (`id_event`)
    REFERENCES `event` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Participant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `participant` ;

CREATE TABLE IF NOT EXISTS `participant` (
  `id` INT NOT NULL auto_increment,
  `mail` VARCHAR(255) NULL,
  `birthDate` DATE NULL,
  `firstName` VARCHAR(255) NULL,
  `lastName` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Participant_Activity`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `participant_activity` ;

CREATE TABLE IF NOT EXISTS `participant_activity` (
  `id_participant` INT NOT NULL,
  `id_activity` INT NOT NULL,
  `score` INT NULL,
  `participant_number` VARCHAR(255) NULL,
  PRIMARY KEY (`id_participant`, `id_activity`),
  INDEX `fk_participant_activity__activity_idx` (`id_activity` ASC),
  CONSTRAINT `fk_participant_activity_participant`
    FOREIGN KEY (`id_participant`)
    REFERENCES `participant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_participant_activity__activity`
    FOREIGN KEY (`id_activity`)
    REFERENCES `activity` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



insert into discipline(name) values('marathon'),('vélo'),('triathlon');
insert into promoter(name, mail, login, password) values
('admin','admin@gmail.com','admin','admin'),('marco','marco@gmail.com','marco','marco');

insert into event(name,description,startDate,endDate,status,id_promoter, id_discipline) values
('Event 1','a nice event','');