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
    let wordSearch = this.value;

    if (el.data) {
        fetchWordsSuggestions(wordSearch).then(drawDataTable);
    }

    return true;
});

// =============================
// Obtener Canvas
// =============================

let id_word_click = null;

const fetchWord = (id_word) => {
    return fetch(`/API/client/word-description.php?id_word=${id_word}`).then(
        (response) => response.json()
    );
};

tagTbody.addEventListener("click", (el) => {
    let functionTag = el.target.getAttribute("function");
    id_word_click = el.target.parentElement.parentElement.getAttribute("idword");

    if (functionTag == "update") {
        let canvas = new bootstrap.Offcanvas(tagCanvasConfigWordsUpdate);
        canvas.show()

        fetchWord(id_word_click)
            .then(drawCanvasConfigWord)
            .then(()=>{
                showElementsCanvas();
                hideLoadingCanvas();
                hideCheckCanvas()
            });

    } else if (functionTag == "delete") {
        // let canvas = new bootstrap.Offcanvas(tagCanvasConfigWordsDelete);
    }

    return true;
});

// =============================
// Canvas de Actualización
// =============================

const hideElementsCanvas = () => {
    Array.from(tagCanvasConfigWordsUpdate.children).forEach((el) =>
        el.classList.add("d-none")
    );
};

const showElementsCanvas = () => {
    Array.from(tagCanvasConfigWordsUpdate.children).forEach((el) =>
        el.classList.remove("d-none")
    );
};

const hideLoadingCanvas = () => {
    tagloadingFormUpdate.classList.add("d-none");
};

const showLoadingCanvas = () => {
    tagloadingFormUpdate.classList.remove("d-none");
};

const showCheckCanvas = () =>{
    document.querySelector('#confirmQuery').classList.remove('d-none');
}

const hideCheckCanvas = () =>{
    document.querySelector('#confirmQuery').classList.add('d-none');
}

const   tagCanvasConfigWordsUpdate = document.querySelector("#canvasConfigWordsUpdate"),
        tagCanvasConfigWordsDelete = document.querySelector("#canvasConfigWordsDelete"),
        tagFormConfigWordsUpdate = document.querySelector("#formConfigWordsUpdate");

const   tagConfigWordsUpdateWord = document.querySelector("#configWordsUpdateWord"),
        tagConfigWordsUpdatePronunciation = document.querySelector("#configWordsUpdatePronunciation"),
        tagConfigWordsUpdateSignificanse = document.querySelector("#configWordsUpdateSignificanse");

const tagsCloseCanvasUpdate = Array.from(document.querySelectorAll('.btnCloseCanvasUpdate'));

const drawCanvasConfigWord = (data) => {
    tagConfigWordsUpdateWord.setAttribute("placeholder", data.WORD);
    tagConfigWordsUpdatePronunciation.setAttribute(
        "placeholder",
        data.PRONUNCIATION
    );
    tagConfigWordsUpdateSignificanse.setAttribute(
        "placeholder",
        data.SIGNIFICANSE
    );

    tagCanvasConfigWordsUpdate.querySelector("h3 > spam").textContent =
        data.WORD;

    return true;
};

const closeCanvasUpdate = () => {
    setTimeout(() => {
        hideElementsCanvas();
        hideCheckCanvas();
        showLoadingCanvas();            
    }, 1000);
}

tagsCloseCanvasUpdate.forEach((el)=>el.addEventListener('click',closeCanvasUpdate))

const tagloadingFormUpdate = document.querySelector("#loadingFormUpdate");

const updateWord = (id_word, word, pronunciation, significanse) => {
    return fetch(
        `/API/admin/word-update.php?id_word=${id_word}&word=${word}&pronunciation=${pronunciation}&significanse=${significanse}`
    ).then((response) => response.text());
};

tagFormConfigWordsUpdate.addEventListener("submit", (e) => {
    e.preventDefault();
    hideElementsCanvas();
    showLoadingCanvas();

    const id_word = id_word_click,
        word = tagConfigWordsUpdateWord.value,
        pronunciation = tagConfigWordsUpdatePronunciation.value,
        significanse = tagConfigWordsUpdateSignificanse.value;

    updateWord(id_word, word, pronunciation, significanse)
        .then(showCheckCanvas)
        .then(hideLoadingCanvas);        
});

// =============================
// Canvas de Eliminación
// =============================