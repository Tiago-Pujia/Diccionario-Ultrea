-- ================
-- DATABASE
-- ================

DROP DATABASE IF EXISTS db_dictionaries;
CREATE DATABASE IF NOT EXISTS db_dictionaries CHARACTER SET utf8;
USE db_dictionaries;

-- ================
-- Users
-- ================

DROP USER IF EXISTS 'user_api'@'localhost';
CREATE USER IF NOT EXISTS 'user_api'@'localhost' IDENTIFIED BY 'peluza';
GRANT select,insert,update,EXECUTE ON db_dictionaries.* TO 'user_api'@'localhost';
FLUSH PRIVILEGES;


-- ================
-- BOARDS
-- ================

CREATE TABLE tbl_dictionaries (
  `ID_DICTIONARY` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `NAME` CHAR(70) NOT NULL,
  -- `DESCRIPTION` VARCHAR(10000)
  `DATE_CREATION` DATETIME NOT NULL DEFAULT now(),
  `DATE_DISABLED` DATETIME
) ENGINE = InnoDB;

CREATE TABLE tbl_type_word (
    `ID_TYPE` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `NAME` CHAR(70) NOT NULL,
    -- `DESCRIPTION` VARCHAR(10000),
    `DATE_CREATION` DATETIME NOT NULL DEFAULT now()
) ENGINE = InnoDB;

CREATE TABLE tbl_words (
    `ID_WORD` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `ID_DICTIONARY` INT UNSIGNED NOT NULL,

    `WORD` CHAR(70) NOT NULL,
    `PRONUNCIATION` CHAR(70),
    `SIGNIFICANCE` CHAR(70),
    `ID_TYPE_WORD` INT UNSIGNED,

    `DATE_CREATION` DATETIME NOT NULL DEFAULT now(),
    `DATE_DISABLED` DATETIME,

    Foreign Key (ID_DICTIONARY) REFERENCES tbl_dictionaries(ID_DICTIONARY),
    Foreign Key (ID_TYPE_WORD) REFERENCES tbl_type_word(ID_TYPE)
) ENGINE = InnoDB;