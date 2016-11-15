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
DROP TABLE IF EXISTS `Discipline` ;

CREATE TABLE IF NOT EXISTS `Discipline` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Promoter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Promoter` ;

CREATE TABLE IF NOT EXISTS `Promoter` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `mail` VARCHAR(45) NULL,
  `login` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Event` ;

CREATE TABLE IF NOT EXISTS `Event` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `startDate` DATE NULL,
  `endDate` DATE NULL,
  `status` INT(11) NULL,
  `id_promoter` INT NULL,
  `id_discipline` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_event_promoter_idx` (`id_promoter` ASC),
  INDEX `fk_event_discipline_idx` (`id_discipline` ASC),
  CONSTRAINT `fk_event_promoter`
    FOREIGN KEY (`id_promoter`)
    REFERENCES `Promoter` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_discipline`
    FOREIGN KEY (`id_discipline`)
    REFERENCES `Discipline` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Activity`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Activity` ;

CREATE TABLE IF NOT EXISTS `Activity` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `price` DECIMAL NULL,
  `date` DATETIME NULL,
  `id_event` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Activity_Event_idx` (`id_event` ASC),
  CONSTRAINT `fk_Activity_Event`
    FOREIGN KEY (`id_event`)
    REFERENCES `Event` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Participant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Participant` ;

CREATE TABLE IF NOT EXISTS `Participant` (
  `id` INT NOT NULL,
  `mail` VARCHAR(45) NULL,
  `birthDate` DATE NULL,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Participant_Activity`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Participant_Activity` ;

CREATE TABLE IF NOT EXISTS `Participant_Activity` (
  `id_participant` INT NOT NULL,
  `id_activity` INT NOT NULL,
  `score` INT NULL,
  `participant_number` VARCHAR(45) NULL,
  PRIMARY KEY (`id_participant`, `id_activity`),
  INDEX `fk_Participant_Activity__activity_idx` (`id_activity` ASC),
  CONSTRAINT `fk_Participant_Activity_participant`
    FOREIGN KEY (`id_participant`)
    REFERENCES `Participant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Participant_Activity__activity`
    FOREIGN KEY (`id_activity`)
    REFERENCES `Activity` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
