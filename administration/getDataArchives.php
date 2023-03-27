<?php 
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