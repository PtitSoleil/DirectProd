-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema DirectProdDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema DirectProdDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `DirectProdDB` DEFAULT CHARACTER SET utf8 ;
USE `DirectProdDB` ;

-- -----------------------------------------------------
-- Table `DirectProdDB`.`USER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DirectProdDB`.`USER` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `canton` VARCHAR(45) NOT NULL,
  `postCode` VARCHAR(45) NOT NULL,
  `streetAndNumber` VARCHAR(45) NOT NULL,
  `admin` TINYINT NOT NULL,
  `description` TEXT(100) NOT NULL,
  PRIMARY KEY (`idUser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DirectProdDB`.`ADVERTISEMENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DirectProdDB`.`ADVERTISEMENT` (
  `idAdvertisement` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NOT NULL,
  `organic` TINYINT NOT NULL,
  `isValid` TINYINT NOT NULL,
  `USER_idUser` INT NOT NULL,
  PRIMARY KEY (`idAdvertisement`),
  INDEX `fk_ADVERTISEMENT_USER_idx` (`USER_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_ADVERTISEMENT_USER`
    FOREIGN KEY (`USER_idUser`)
    REFERENCES `DirectProdDB`.`USER` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DirectProdDB`.`PICTURE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DirectProdDB`.`PICTURE` (
  `idPicture` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(45) NOT NULL,
  `ADVERTISEMENT_idAdvertisement` INT NOT NULL,
  PRIMARY KEY (`idPicture`),
  INDEX `fk_PICTURE_ADVERTISEMENT1_idx` (`ADVERTISEMENT_idAdvertisement` ASC) VISIBLE,
  CONSTRAINT `fk_PICTURE_ADVERTISEMENT1`
    FOREIGN KEY (`ADVERTISEMENT_idAdvertisement`)
    REFERENCES `DirectProdDB`.`ADVERTISEMENT` (`idAdvertisement`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DirectProdDB`.`rate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DirectProdDB`.`rate` (
  `rating` INT NOT NULL,
  `comment` VARCHAR(45) NOT NULL,
  `date` VARCHAR(45) NOT NULL,
  `USER_idUser` INT NOT NULL,
  `ADVERTISEMENT_idAdvertisement` INT NOT NULL,
  INDEX `fk_rate_USER1_idx` (`USER_idUser` ASC) VISIBLE,
  INDEX `fk_rate_ADVERTISEMENT1_idx` (`ADVERTISEMENT_idAdvertisement` ASC) VISIBLE,
  CONSTRAINT `fk_rate_USER1`
    FOREIGN KEY (`USER_idUser`)
    REFERENCES `DirectProdDB`.`USER` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rate_ADVERTISEMENT1`
    FOREIGN KEY (`ADVERTISEMENT_idAdvertisement`)
    REFERENCES `DirectProdDB`.`ADVERTISEMENT` (`idAdvertisement`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
