SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NULL,
  `last_name` VARCHAR(100) NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(45) NULL DEFAULT 'user' COMMENT 'admin, user',
  `created_dt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `language`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `language` (
  `id` VARCHAR(2) NOT NULL,
  `name` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dictionary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dictionary` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NULL,
  `description` TEXT NULL,
  `lang_source` VARCHAR(2) NULL,
  `lang_translation` VARCHAR(2) NULL,
  `created_dt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NULL,
  `type` INT NULL DEFAULT 0 COMMENT '0 - private, 1 - common',
  PRIMARY KEY (`id`),
  INDEX `fk_dictionary_user_idx` (`user_id` ASC),
  INDEX `fk_dictionary_langsource_idx` (`lang_source` ASC),
  INDEX `fk_dictionary_langtranslat_idx` (`lang_translation` ASC),
  CONSTRAINT `fk_dictionary_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_dictionary_langsource`
    FOREIGN KEY (`lang_source`)
    REFERENCES `language` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_dictionary_langtranslat`
    FOREIGN KEY (`lang_translation`)
    REFERENCES `language` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `word`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `word` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `word` VARCHAR(100) NULL,
  `translation` VARCHAR(100) NULL,
  `dictionary_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_word_dictionary_idx` (`dictionary_id` ASC),
  CONSTRAINT `fk_word_dictionary`
    FOREIGN KEY (`dictionary_id`)
    REFERENCES `dictionary` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `learned`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `learned` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `word_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_learned_word_idx` (`word_id` ASC),
  INDEX `fk_learned_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_learned_word`
    FOREIGN KEY (`word_id`)
    REFERENCES `word` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_learned_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
