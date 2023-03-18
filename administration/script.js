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
            .then(drawCanvasUpdateWord)
            .then(()=>{
                showElementsCanvasUpdate();
                hideLoadingCanvasUpdate();
                hideCheckCanvasUpdate();
            });

    } else if (functionTag == "delete") {
        let canvas = new bootstrap.Offcanvas(tagCanvasConfigWordsDelete);
        canvas.show()

        fetchWord(id_word_click)
            .then(drawCanvasDeleteWord)
            .then(()=>{
                showElementsCanvasDelete();
                hideLoadingCanvasDelete();
                hideCheckCanvasDelete();
            })
    }

    return true;
});

// =============================
// Canvas de Actualización
// =============================

const hideElementsCanvasUpdate = () => {
    Array.from(tagCanvasConfigWordsUpdate.children).forEach((el) =>
        el.classList.add("d-none")
    );
};

const showElementsCanvasUpdate = () => {
    Array.from(tagCanvasConfigWordsUpdate.children).forEach((el) =>
        el.classList.remove("d-none")
    );
};

const hideLoadingCanvasUpdate = () => {
    tagloadingFormUpdate.classList.add("d-none");
};

const showLoadingCanvasUpdate = () => {
    tagloadingFormUpdate.classList.remove("d-none");
};

const showCheckCanvasUpdate = () =>{
    document.querySelector('#confirmQueryUpdate').classList.remove('d-none');
}

const hideCheckCanvasUpdate = () =>{
    document.querySelector('#confirmQueryUpdate').classList.add('d-none');
}

const   tagCanvasConfigWordsUpdate = document.querySelector("#canvasConfigWordsUpdate"),
        tagFormConfigWordsUpdate = document.querySelector("#formConfigWordsUpdate"),
        tagConfigWordsUpdateWord = document.querySelector("#configWordsUpdateWord"),
        tagConfigWordsUpdatePronunciation = document.querySelector("#configWordsUpdatePronunciation"),
        tagConfigWordsUpdateSignificanse = document.querySelector("#configWordsUpdateSignificanse"),
        tagloadingFormUpdate = document.querySelector("#loadingFormUpdate");

const tagsCloseCanvasUpdate = Array.from(document.querySelectorAll('.btnCloseCanvasUpdate'));

const drawCanvasUpdateWord = (data) => {
    tagConfigWordsUpdateWord.setAttribute("placeholder", data.WORD);
    tagConfigWordsUpdateWord.value = '';

    tagConfigWordsUpdatePronunciation.setAttribute("placeholder",data.PRONUNCIATION);
    tagConfigWordsUpdatePronunciation.value = '';

    tagConfigWordsUpdateSignificanse.setAttribute("placeholder",data.SIGNIFICANSE);
    tagConfigWordsUpdateSignificanse.value = '';

    tagCanvasConfigWordsUpdate.querySelector("h3 > spam").textContent = data.WORD;

    return true;
};

const closeCanvasUpdate = () => {
    setTimeout(() => {
        hideElementsCanvasUpdate();
        hideCheckCanvasUpdate();
        showLoadingCanvasUpdate();            
    }, 1000);
}

tagsCloseCanvasUpdate.forEach((el)=>el.addEventListener('click',closeCanvasUpdate))


const updateWord = (id_word, word, pronunciation, significanse) => {
    return fetch(
        `/API/admin/word-update.php?id_word=${id_word}&word=${word}&pronunciation=${pronunciation}&significanse=${significanse}`
    ).then((response) => response.text());
};

tagFormConfigWordsUpdate.addEventListener("submit", (e) => {
    e.preventDefault();
    hideElementsCanvasUpdate();
    showLoadingCanvasUpdate();

    const id_word = id_word_click,
        word = tagConfigWordsUpdateWord.value,
        pronunciation = tagConfigWordsUpdatePronunciation.value,
        significanse = tagConfigWordsUpdateSignificanse.value;

    updateWord(id_word, word, pronunciation, significanse)
        .then(showCheckCanvasUpdate)
        .then(hideLoadingCanvasUpdate);        
});

// =============================
// Canvas de Eliminación
// =============================

const   tagCanvasConfigWordsDelete = document.querySelector("#canvasConfigWordsDelete"),
        tagFormConfigWordsDelete = document.querySelector("#formConfigWordsDelete"),
        tagloadingFormDelete = document.querySelector("#loadingFormDelete");

const hideElementsCanvasDelete = () => {
    Array.from(tagCanvasConfigWordsDelete.children).forEach((el) =>
        el.classList.add("d-none")
    );
};

const showElementsCanvasDelete = () => {
    Array.from(tagCanvasConfigWordsDelete.children).forEach((el) =>
        el.classList.remove("d-none")
    );
};

const hideLoadingCanvasDelete = () => {
    tagloadingFormDelete.classList.add("d-none");
};

const showLoadingCanvasDelete = () => {
    tagloadingFormDelete.classList.remove("d-none");
};

const showCheckCanvasDelete = () =>{
    document.querySelector('#confirmQueryDelete').classList.remove('d-none');
}

const hideCheckCanvasDelete = () =>{
    document.querySelector('#confirmQueryDelete').classList.add('d-none');
}

const closeCanvasDelete = () => {
    setTimeout(() => {
        hideElementsCanvasDelete();
        hideCheckCanvasDelete();
        hideLoadingCanvasDelete();            
    }, 1000);
}

const drawCanvasDeleteWord = (data) => {
    tagCanvasConfigWordsDelete.querySelector("p > spam").textContent = data.WORD;

    return true;
}

const deleteWord = (id_word) => {
    return fetch(
        `/API/admin/word-delete.php?id_word=${id_word}`
    ).then((response) => response.text());
};

tagFormConfigWordsDelete.addEventListener("submit", (e) => {
    e.preventDefault();
    hideElementsCanvasDelete();
    showLoadingCanvasDelete();

    const id_word = id_word_click;

    deleteWord(id_word)
        .then(showCheckCanvasDelete)
        .then(hideLoadingCanvasDelete);        
});