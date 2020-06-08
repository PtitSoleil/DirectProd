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
  `password` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `canton` VARCHAR(50) NOT NULL,
  `postCode` VARCHAR(50) NOT NULL,
  `streetAndNumber` VARCHAR(100) NOT NULL,
  `isAdmin` TINYINT NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`idUser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DirectProdDB`.`ADVERTISEMENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DirectProdDB`.`ADVERTISEMENT` (
  `idAdvertisement` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL,
  `organic` TINYINT NOT NULL,
  `isValid` TINYINT NOT NULL,
  `idUser` INT NOT NULL,
  PRIMARY KEY (`idAdvertisement`),
  INDEX `fk_ADVERTISEMENT_USER_idx` (`idUser` ASC) VISIBLE,
  CONSTRAINT `fk_ADVERTISEMENT_USER`
    FOREIGN KEY (`idUser`)
    REFERENCES `DirectProdDB`.`USER` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DirectProdDB`.`PICTURE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DirectProdDB`.`PICTURE` (
  `idPicture` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(75) NOT NULL,
  `idAdvertisement` INT NOT NULL,
  PRIMARY KEY (`idPicture`),
  INDEX `fk_PICTURE_ADVERTISEMENT1_idx` (`idAdvertisement` ASC) VISIBLE,
  CONSTRAINT `fk_PICTURE_ADVERTISEMENT1`
    FOREIGN KEY (`idAdvertisement`)
    REFERENCES `DirectProdDB`.`ADVERTISEMENT` (`idAdvertisement`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DirectProdDB`.`rate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DirectProdDB`.`rate` (
  `rating` INT NOT NULL,
  `comment` TEXT NOT NULL,
  `date` DATE NOT NULL,
  `idUser` INT NOT NULL,
  `idAdvertisement` INT NOT NULL,
  INDEX `fk_rate_USER1_idx` (`idUser` ASC) VISIBLE,
  INDEX `fk_rate_ADVERTISEMENT1_idx` (`idAdvertisement` ASC) VISIBLE,
  CONSTRAINT `fk_rate_USER1`
    FOREIGN KEY (`idUser`)
    REFERENCES `DirectProdDB`.`USER` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rate_ADVERTISEMENT1`
    FOREIGN KEY (`idAdvertisement`)
    REFERENCES `DirectProdDB`.`ADVERTISEMENT` (`idAdvertisement`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
