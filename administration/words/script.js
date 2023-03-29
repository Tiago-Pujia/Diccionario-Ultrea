const inputSearch = document.querySelector("#search");

// =============================
// Juego de Botones
// =============================

const tagbtnGroupConfig = document.querySelector('#btnGroupConfig');
const tagShowModify = document.querySelector('#showModify');
const tagShowDeletedes = document.querySelector('#showDeletedes');

const tagTableModify = document.querySelector('#tableModify');
const tagTableRemoved = document.querySelector('#tableRemoved');

const hideTables = () => {
    Array.from(tagbtnGroupConfig.querySelectorAll('button')).forEach((tag)=>tag.classList.remove('active'));
    inputSearch.value = '';
}

const showConfigModify = () => {
    fetchWordsSuggestions().then(drawDataTableModify);
    drawPaginationTableModify();
    hideTables();

    tagShowModify.classList.add('active');
    tagTableModify.classList.remove('d-none');
    tagTableRemoved.classList.add('d-none')
    tagPaginationTableModify.classList.remove('d-none');
    tagPaginationTableDeletedes.classList.add('d-none')

    return true;
}

const showConfigDeteletes = () => {
    fetchWordsDisabled().then(drawDataTableRemoved);
    drawPaginationDeletedes();
    hideTables();

    tagShowDeletedes.classList.add('active');
    tagTableRemoved.classList.remove('d-none');
    tagTableModify.classList.add('d-none');
    tagPaginationTableDeletedes.classList.remove('d-none')
    tagPaginationTableModify.classList.add('d-none');

    return true;
}

tagbtnGroupConfig.addEventListener('click',function(el){
    el.target.classList.add('active');
})

tagShowModify.addEventListener('click',showConfigModify)
tagShowDeletedes.addEventListener('click',showConfigDeteletes)

window.addEventListener('DOMContentLoaded',()=>tagShowModify.click());

// =============================
// Input,imprimir tabla de modificaciones
// =============================

const fetchWordsSuggestions = (wordSearch = '',page = 0) => {
    return fetch(
        `/API/client/word-for-field.php?words_search=${wordSearch}&page=${page}&id_dictionary=${idDictionary}`
    ).then((response) => response.json());
};

const drawDataTableModify = (info) => {
    const tagTbody = tagTableModify.querySelector("tbody");
    const fragment = document.createDocumentFragment();

    info.forEach((data) => {
        let createTagTr = document.createElement("tr");
        let idword = data.ID_WORD;
        let dataDraw = [
            data.WORD,
            `<a class="btn btn-outline-primary" href="/home/?id_word=${idword}&id_dictionary=${idDictionary}" target="_blank"><i class="bi bi-box-arrow-up-left"></i></a>`,
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
    tagTbody.onclick = eventTagTBodyClick;
    tagTbody.append(fragment);

    return true;
};

// =============================
// Input,imprimir tabla de deshabilitados
// =============================

const fetchWordsDisabled= (wordSearch = '', page = 0) => {
    return fetch(
        `/API/admin/word-listing-disabled.php?words_search=${wordSearch}&page=${page}&id_dictionary=${idDictionary}`
    ).then((response) => response.json());
};

const drawDataTableRemoved = (info) => {
    const tagTbody = tagTableRemoved.querySelector("tbody");
    const fragment = document.createDocumentFragment();

    info.forEach((data) => {
        let createTagTr = document.createElement("tr");
        let idword = data.ID_WORD;
        let dataDraw = [
            data.WORD,
            data.SIGNIFICANCE,
            data.DATE_DISABLED,
            `<i class="bi bi-archive-fill btn btn-outline-primary" function="enable"></i>`
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
    tagTbody.onclick = eventTagTBodyClick;
    tagTbody.append(fragment);

    return true;
};

inputSearch.addEventListener("input", function (el) {
    let wordSearch = this.value.trim();

    if (el.data) {
        let idBtnActive = tagbtnGroupConfig.querySelector('.active').id;

        switch (idBtnActive) {
            case 'showModify':
                fetchWordsSuggestions(wordSearch).then(drawDataTableModify); 
                drawPaginationTableModify();
                break;
        
            case 'showDeletedes':
                fetchWordsDisabled(wordSearch).then(drawDataTableRemoved)
                drawPaginationDeletedes();
                break;
        }
    }

    return true;
});

// =============================
// Obtener Canvas
// =============================

let id_word_click = null;

const   tagCanvasConfig = document.querySelector("#canvasConfig"),
        tagCanvasConfigHeader = document.querySelector("#canvasConfigHeader"),
        tagCanvasConfigTitle = tagCanvasConfigHeader.querySelector(".offcanvas-title"),
        tagCanvasConfigBody = document.querySelector("#canvasConfigBody"),
        tagCanvasConfigConfirm = document.querySelector("#canvasConfigConfirmQuery"),
        tagCanvasConfigLoading = document.querySelector("#canvasConfigLoading"),
        canvasConfig = new bootstrap.Offcanvas(tagCanvasConfig);

const fetchWord = (id_word) => {
    return fetch(
        `/API/client/word-description.php?id_word=${id_word}&id_dictionary=${idDictionary}`
    ).then(
        (response) => response.json()
    );
};

const fetchWordDisabled = (id_word) => {
    return fetch(
        `/API/admin/word-description-disabled.php?id_word=${id_word}&id_dictionary=${idDictionary}`
    ).then(
        (response) => response.json()
    );
};

const eventTagTBodyClick = (el) => {
    const functionTag = el.target.getAttribute("function");

    id_word_click = el.target.parentElement.parentElement.getAttribute("idword");

    switch (functionTag) {
        case 'update':
            canvasConfig.show();
            fetchWord(id_word_click)
                .then(drawCanvasConfigUpdate)
                .then(showBody);
            break;

        case 'delete':
            canvasConfig.show();
            fetchWord(id_word_click)
                .then(drawCanvasConfigDelete)
                .then(showBody);
            break;

        case 'enable':
            canvasConfig.show();
            fetchWordDisabled(id_word_click)
                .then(drawCanvasConfigEnable)
                .then(showBody);
            break;
    }

    return true;
};

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
}

const showBody = () => {
    showElementsCanvasConfig();
    hideLoadingCanvasConfig();
    hideCheckCanvasConfig();    
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
        .then(()=>document.querySelector(`[idword="${id_word_click}"]`).outerHTML = '');
    
    return true;
};

const drawCanvasConfigDelete = (response) => {
    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigDelete"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.textContent = "Eliminar Concepto";
    tagCanvasConfigHeader.style.color = 'var(--bs-red)';

    newTemplate.querySelector(".canvasConfigWordDraw").textContent = response.WORD;
    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitDelete;

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    return true;
};

// =============================
// Actualizar Termino
// =============================

const updateWord = (id_word, word, pronunciation, significance, type) => {
    return fetch(
        `/API/admin/word-update.php?id_word=${id_word}&word=${word}&pronunciation=${pronunciation}&significance=${significance}&id_type_word=${type}`
    ).then((response) => response.text());
};

const formSubmitUpdate = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    const   word = document.querySelector('#configWordsUpdateWord').value.trim(),
            pronunciation = document.querySelector('#configWordsUpdatePronunciation').value.trim(),
            significance = document.querySelector('#configWordsUpdateSignificance').value.trim();
    let     type = document.querySelector('#configWordsUpdateType');
            type = type.options[type.selectedIndex].value;
        
    updateWord(id_word_click, word, pronunciation, significance, type)
        .then(fetchCorrect);
    
    return true;
};

const drawCanvasConfigUpdate = (response) => {
    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigUpdate"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.innerHTML = `Modificar Término<br>"<spam class="fst-italic">${response.WORD}</spam>"`;
    tagCanvasConfigHeader.style.color = 'var(--bs-green)';

    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitUpdate;
    newTemplate.querySelector('#configWordsUpdateWord').setAttribute('placeholder',response.WORD);
    newTemplate.querySelector('#configWordsUpdatePronunciation').setAttribute('placeholder',response.PRONUNCIATION);
    newTemplate.querySelector('#configWordsUpdateSignificance').setAttribute('placeholder',response.SIGNIFICANCE);

    const tagNewTemplateTypeSelect = newTemplate.querySelector('#configWordsUpdateType');

    tagNewTemplateTypeSelect.querySelector('[selected]').removeAttribute('selected');
    (Array.from(tagNewTemplateTypeSelect.children)
        .filter((el)=>el.textContent == response.TYPE_WORD)[0]
        || 
        tagNewTemplateTypeSelect.firstElementChild)
        .setAttribute('selected','');

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    return true;
};

// =============================
// Insertar Nuevos Terminos
// =============================

const tagCreateNewWord = document.querySelector('#createNewWord');

const createWord = (word, pronunciation, significance,type) => {
    return fetch(
        `/API/admin/word-create.php?word=${word}&pronunciation=${pronunciation}&significance=${significance}&id_type_word=${type}&id_dictionary=${idDictionary}`
    ).then((response) => response.text());
};

const formSubmitInsert = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    const   word = document.querySelector('#configWordsInsertWord').value.trim(),
            pronunciation = document.querySelector('#configWordsInsertPronunciation').value.trim(),
            significance = document.querySelector('#configWordsInsertSignificance').value.trim();
    let     type = document.querySelector('#configWordsInsertType');
            type = type.options[type.selectedIndex].value;

    createWord(word, pronunciation, significance,type)
        .then(()=>{
            hideLoadingCanvasConfig();
            showCheckCanvasConfig();
        })
        .then(()=>{
            tagShowModify.click();
        });
    
    return true;
}

const drawCanvasConfigInsert = (e) => {
    e.preventDefault();
    canvasConfig.show();

    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigInsert"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.innerHTML = `Crear Nuevo Termino`;
    tagCanvasConfigHeader.style.color = 'var(--bs-blue)';
    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitInsert;

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    showBody();

    return true;
}

tagCreateNewWord.addEventListener('click',drawCanvasConfigInsert)

// =============================
// Habilitar termino ya eliminado
// =============================

const enableWord = (id_word) => {
    return fetch(
        `/API/admin/word-enable.php?id_word=${id_word}`
    ).then((response) => response.json());
}

const formSubmitEnable = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    enableWord(id_word_click)
        .then(fetchCorrect)
        .then(()=>document.querySelector(`[idword="${id_word_click}"]`).outerHTML = '');
    
    return true;
};

const drawCanvasConfigEnable = (response) => {
    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigEnable"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.textContent = "Habilitar Termino";
    tagCanvasConfigHeader.style.color = 'var(--bs-blue)';

    newTemplate.querySelector(".canvasConfigWordDraw").textContent = response.WORD;
    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitEnable;

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    return true;
};

// =============================
// Paginación
// =============================

const tagPaginationTableModify = document.querySelector('#paginationTableModify');
const tagPaginationTableDeletedes = document.querySelector('#paginationTableDeletedes');

let classPaginatinTableModify;
let classPaginatinTableDeletedes;

const drawPaginationTableModify = () => {
    const wordSearch = inputSearch.value.trim();
    const tagDraw = tagPaginationTableModify.querySelectorAll('div')[1];
    
    tagDraw.innerHTML = '';

    fetch(`/API/client/word-count.php?words_search=${wordSearch}&id_dictionary=${idDictionary}`)
        .then((response)=>response.json())
        .then((response)=>response.COUNT)
        .then((response)=>{
            classPaginatinTableModify = new Pagination(response);

            tagPaginationTableModify.querySelector('.showCount').textContent = response;

            classPaginatinTableModify.drawPagination(tagDraw);
            classPaginatinTableModify.functionClick = () => {
                fetchWordsSuggestions(wordSearch,classPaginatinTableModify.page).then(drawDataTableModify);
            }
        });
}

const drawPaginationDeletedes = () => {
    const wordSearch = inputSearch.value.trim();
    const tagDraw = tagPaginationTableDeletedes.querySelectorAll('div')[1];
    
    tagDraw.innerHTML = '';

    fetch(`/API/admin/word-count-disabled.php?words_search=${wordSearch}&id_dictionary=${idDictionary}`)
        .then((response)=>response.json())
        .then((response)=>response.COUNT)
        .then((response)=>{
            classPaginatinTableModify = new Pagination(response);

            tagPaginationTableDeletedes.querySelector('.showCount').textContent = response;

            classPaginatinTableModify.drawPagination(tagDraw);
            classPaginatinTableModify.functionClick = () => {
                fetchWordsDisabled(wordSearch,classPaginatinTableModify.page).then(drawDataTableRemoved);
            }
        })
}