-- ================
-- DATABASE
-- ================
DROP DATABASE IF EXISTS db_dictionary;
CREATE DATABASE IF NOT EXISTS db_dictionary;
USE db_dictionary;


-- ================
-- Users
-- ================
DROP USER IF EXISTS 'user_api'@'localhost';
CREATE USER IF NOT EXISTS 'user_api'@'localhost' IDENTIFIED BY 'peluza';

GRANT select,insert,update,EXECUTE ON db_dictionary.* TO 'user_api'@'localhost';
FLUSH PRIVILEGES;


-- ================
-- BOARDS
-- ================
CREATE TABLE tbl_words (
    `ID_WORD` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `WORD` CHAR(70) CHARACTER SET LATIN2,
    `PRONUNCIATION` CHAR(70) CHARACTER SET UTF16,
    `MEANING` VARCHAR(10000) CHARACTER SET UTF8,
    `DESCRIPTION` VARCHAR(10000) CHARACTER SET UTF8,
    `TRANSLATION` CHAR(70) CHARACTER SET UTF8,
    `DATE_CREATION` DATETIME NOT NULL DEFAULT now()
) ENGINE = InnoDB;


-- ================
-- TEST
-- ================
/*
INSERT INTO tbl_words
    (WORD,PRONUNCIATION,MEANING,DESCRIPTION,TRANSLATION)
VALUES
    ('Achatrë',"a-'t͡ʃa-tɾə",'Cerebro','si','Cerebro');
SELECT * FROM tbl_words;
*/