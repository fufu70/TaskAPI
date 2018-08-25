-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema TaskAPITestDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema TaskAPITestDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `TaskAPITestDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `TaskAPITestDB` ;

-- -----------------------------------------------------
-- Table `TaskAPITestDB`.`tbl_node`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TaskAPITestDB`.`tbl_node` (
  `node_id` INT NOT NULL AUTO_INCREMENT,
  `node_hash_id` VARCHAR(256) NOT NULL,
  `system` VARCHAR(2048) NULL,
  `cpu` VARCHAR(2048) NULL,
  `hard_disk` VARCHAR(2048) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`node_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TaskAPITestDB`.`tbl_task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TaskAPITestDB`.`tbl_task` (
  `task_id` INT NOT NULL AUTO_INCREMENT,
  `task_hash_id` VARCHAR(256) NOT NULL,
  `install_command` VARCHAR(4096) NULL,
  `start_command` VARCHAR(4096) NULL,
  `end_command` VARCHAR(4096) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`task_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TaskAPITestDB`.`tbl_node_has_task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TaskAPITestDB`.`tbl_node_has_task` (
  `node_has_task_id` INT NOT NULL AUTO_INCREMENT,
  `node_id` INT NOT NULL,
  `task_id` INT NOT NULL,
  PRIMARY KEY (`node_has_task_id`),
  INDEX `fk_tbl_node_has_task_tbl_node_idx` (`node_id` ASC),
  INDEX `fk_tbl_node_has_task_tbl_task1_idx` (`task_id` ASC),
  CONSTRAINT `fk_tbl_node_has_task_tbl_node`
    FOREIGN KEY (`node_id`)
    REFERENCES `TaskAPITestDB`.`tbl_node` (`node_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_node_has_task_tbl_task1`
    FOREIGN KEY (`task_id`)
    REFERENCES `TaskAPITestDB`.`tbl_task` (`task_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TaskAPITestDB`.`tbl_node_moment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TaskAPITestDB`.`tbl_node_moment` (
  `node_moment_id` INT NOT NULL AUTO_INCREMENT,
  `node_id` INT NOT NULL,
  `node_moment_hash_id` VARCHAR(256) NOT NULL,
  `cpu_usage` VARCHAR(2048) NULL,
  `memory_usage` VARCHAR(2048) NULL,
  `hard_disk_usage` VARCHAR(2048) NULL,
  `temperature` VARCHAR(2048) NULL,
  `weather` VARCHAR(2048) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`node_moment_id`),
  INDEX `fk_tbl_node_moment_tbl_node1_idx` (`node_id` ASC),
  CONSTRAINT `fk_tbl_node_moment_tbl_node1`
    FOREIGN KEY (`node_id`)
    REFERENCES `TaskAPITestDB`.`tbl_node` (`node_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
