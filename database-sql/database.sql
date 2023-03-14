-- ================
-- DATABASE
-- ================
DROP DATABASE IF EXISTS db_dictionaries;
CREATE DATABASE IF NOT EXISTS db_dictionaries;
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
CREATE TABLE tbl_words_ultrea (
    `ID_WORD` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    
    `WORD` CHAR(70) CHARACTER SET LATIN2,
    `PRONUNCIATION` CHAR(70) CHARACTER SET UTF16,
    `SIGNIFICANSE` CHAR(70) CHARACTER SET UTF8,

    `DATE_CREATION` DATETIME NOT NULL DEFAULT now(),
    `DATE_DISABLED` DATETIME
) ENGINE = InnoDB;


-- ================
-- TEST
-- ================


/*
-- ================
-- Obtención de datos Word
-- ================
const getData = () => {
    let table = document.querySelector(".MsoNormalTable");
    let response = [];

    Array.from(table.querySelectorAll("tr")).forEach((tagTr) => {
        let query = [];

        Array.from(tagTr.querySelectorAll("td")).forEach((tagTd) => {
            let text = tagTd.textContent.trim();

            text = text.replace("[", "");
            text = text.replace("]", "");
            text = text.replace("\n", "");

            text = '"' + text + '"';

            query.push(text);
        });

        query = "\n(" + query.join(",") + ")";

        response.push(query);
    });

    response = response.join(",") + ";";

    return response;
};

getData();

*/