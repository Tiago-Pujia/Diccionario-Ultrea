// =============================
// Input,imprimir tabla
// =============================

const tagTbody = document.querySelector("#tbody");
const inputSearch = document.querySelector("#search");

const fetchWordsSuggestions = (wordSearch) => {
    return fetch(
        `/API/client/word-for-field.php?words_search=${wordSearch}`
    ).then((response) => response.json());
};

const drawDataTable = (info) => {
    const fragment = document.createDocumentFragment();

    info.forEach((data) => {
        let createTagTr = document.createElement("tr");
        let idword = data.ID_WORD;
        let dataDraw = [
            data.WORD,
            `<a class="btn btn-outline-primary" href="/home/?id_word=${idword}" target="_blanck"><i class="bi bi-box-arrow-up-left"></i></a>`,
            `<i class="bi bi-arrow-repeat btn btn-outline-success" function="update"></i>`,
            `<i class="bi bi-trash3-fill btn btn-outline-danger" function="delete"></i>`,
        ];

        dataDraw.forEach((el) => {
            let createTagTd = document.createElement("td");

            createTagTd.innerHTML += el;
            createTagTr.append(createTagTd);
        });

        createTagTr.setAttribute("idword", idword);
        fragment.append(createTagTr);
    });

    tagTbody.innerHTML = "";
    tagTbody.append(fragment);

    return true;
};

inputSearch.addEventListener("input", function (el) {
    let wordSearch = this.value.trim();

    if (el.data) {
        fetchWordsSuggestions(wordSearch).then(drawDataTable);
    }

    return true;
});

// =============================
// Obtener Canvas
// =============================

let id_word_click = null;

const tagCanvasConfig = document.querySelector("#canvasConfig"),
    tagCanvasConfigHeader = document.querySelector("#canvasConfigHeader"),
    tagCanvasConfigTitle =
        tagCanvasConfigHeader.querySelector(".offcanvas-title"),
    tagCanvasConfigBody = document.querySelector("#canvasConfigBody"),
    tagCanvasConfigConfirm = document.querySelector(
        "#canvasConfigConfirmQuery"
    ),
    tagCanvasConfigLoading = document.querySelector("#canvasConfigLoading");

const fetchWord = (id_word) => {
    return fetch(`/API/client/word-description.php?id_word=${id_word}`).then(
        (response) => response.json()
    );
};

tagTbody.addEventListener("click", (el) => {
    const functionTag = el.target.getAttribute("function");
    const canvas = new bootstrap.Offcanvas(tagCanvasConfig);

    id_word_click =
        el.target.parentElement.parentElement.getAttribute("idword");

    if (functionTag == "update") {
        canvas.show();

        fetchWord(id_word_click)
            .then((response) => {
                drawCanvasConfigUpdate(response);
            })
            .then(() => {
                showElementsCanvasConfig();
                hideLoadingCanvasConfig();
                hideCheckCanvasConfig();
            });
    } else if (functionTag == "delete") {
        canvas.show();

        fetchWord(id_word_click)
            .then((response) => {
                drawCanvasConfigDelete(response);
            })
            .then(() => {
                showElementsCanvasConfig();
                hideLoadingCanvasConfig();
                hideCheckCanvasConfig();
            });
    }

    return true;
});

// =============================
// Mostrar u Ocultor diversos elementos del canvasConfig
// =============================

const hideElementsCanvasConfig = () => {
    Array.from(tagCanvasConfig.children).forEach((el) =>
        el.classList.add("d-none")
    );
};

const showElementsCanvasConfig = () => {
    Array.from(tagCanvasConfig.children).forEach((el) =>
        el.classList.remove("d-none")
    );
};

const hideLoadingCanvasConfig = () => {
    tagCanvasConfigLoading.classList.add("d-none");
};

const showLoadingCanvasConfig = () => {
    tagCanvasConfigLoading.classList.remove("d-none");
};

const showCheckCanvasConfig = () => {
    tagCanvasConfigConfirm.classList.remove("d-none");
};

const hideCheckCanvasConfig = () => {
    tagCanvasConfigConfirm.classList.add("d-none");
};


const fetchCorrect = () => {
    hideLoadingCanvasConfig();
    showCheckCanvasConfig();
    
    document.querySelector(`[idword="${id_word_click}"]`).outerHTML = '';
}

// =============================
// Eliminar Termino
// =============================

const deleteWord = (id_word) => {
    return fetch(`/API/admin/word-delete.php?id_word=${id_word}`).then(
        (response) => response.text()
    );
};

const formSubmitDelete = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    deleteWord(id_word_click)
        .then(fetchCorrect)
    
    return true;
};

const drawCanvasConfigDelete = (response) => {
    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigDelete"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.textContent = "Eliminar Concepto";

    newTemplate.querySelector(".canvasConfigWordDraw").textContent = response.WORD;
    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitDelete;

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    return true;
};

// =============================
// Actualizar Termino
// =============================

const updateWord = (id_word, word, pronunciation, significanse) => {
    return fetch(
        `/API/admin/word-update.php?id_word=${id_word}&word=${word}&pronunciation=${pronunciation}&significanse=${significanse}`
    ).then((response) => response.text());
};

const formSubmitUpdate = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    const   word = document.querySelector('#configWordsUpdateWord').value.trim(),
            pronunciation = document.querySelector('#configWordsUpdatePronunciation').value.trim(),
            significanse = document.querySelector('#configWordsUpdateSignificanse').value.trim();
        
    updateWord(id_word_click, word, pronunciation, significanse)
        .then(fetchCorrect);
    
    return true;
};

const drawCanvasConfigUpdate = (response) => {
    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigUpdate"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.innerHTML = `Modificar Término<br>"<spam class="fst-italic">${response.WORD}</spam>"`;

    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitUpdate;
    newTemplate.querySelector('#configWordsUpdateWord').setAttribute('placeholder',response.WORD);
    newTemplate.querySelector('#configWordsUpdatePronunciation').setAttribute('placeholder',response.PRONUNCIATION);
    newTemplate.querySelector('#configWordsUpdateSignificanse').setAttribute('placeholder',response.SIGNIFICANSE);

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    return true;
};