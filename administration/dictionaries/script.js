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
}

const showConfigModify = () => {
    fetchDictionaries().then(drawDataTableModify);
    hideTables();

    tagShowModify.classList.add('active');
    tagTableModify.classList.remove('d-none');
    tagTableRemoved.classList.add('d-none')

    return true;
}

const showConfigDeteletes = () => {
    fetchDictionariesDisabled().then(drawDataTableRemoved);
    hideTables();

    tagShowDeletedes.classList.add('active');
    tagTableRemoved.classList.remove('d-none');
    tagTableModify.classList.add('d-none');

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

const fetchDictionaries = () => {
    return fetch(
        `/API/dictionaries/dictionaries-listing.php`
    ).then((response) => response.json());
}

const drawDataTableModify = (info) => {
    const tagTbody = tagTableModify.querySelector("tbody");
    const fragment = document.createDocumentFragment();

    info.forEach((data) => {
        let createTagTr = document.createElement("tr");
        let id_dictionary = data.ID_DICTIONARY;
        let dataDraw = [
            data.NAME,
            data.WORDS_COUNT,
            `<a class="btn btn-outline-primary" href="/home/?id_dictionary=${data.ID_DICTIONARY}" target="_blank"><i class="bi bi-box-arrow-up-left"></i></a>`,
            `<i class="bi bi-arrow-repeat btn btn-outline-success" function="update"></i>`,
            `<i class="bi bi-trash3-fill btn btn-outline-danger" function="delete"></i>`,
        ];

        dataDraw.forEach((el) => {
            let createTagTd = document.createElement("td");

            createTagTd.innerHTML += el;
            createTagTr.append(createTagTd);
        });

        createTagTr.setAttribute("id_dictionary", id_dictionary);
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

const fetchDictionariesDisabled= () => {
    return fetch(
        `/API/dictionaries/dictionaries-listing-disabled.php`
    ).then((response) => response.json());
};

const drawDataTableRemoved = (info) => {
    const tagTbody = tagTableRemoved.querySelector("tbody");
    const fragment = document.createDocumentFragment();

    info.forEach((data) => {
        let createTagTr = document.createElement("tr");
        let id_dictionary = data.ID_DICTIONARY;
        let dataDraw = [
            data.NAME,
            data.WORDS_COUNT,
            data.DATE_DISABLED,
            `<i class="bi bi-archive-fill btn btn-outline-primary" function="enable"></i>`
        ];

        dataDraw.forEach((el) => {
            let createTagTd = document.createElement("td");

            createTagTd.innerHTML += el;
            createTagTr.append(createTagTd);
        });

        createTagTr.setAttribute("id_dictionary", id_dictionary);
        fragment.append(createTagTr);
    });

    tagTbody.innerHTML = "";
    tagTbody.onclick = eventTagTBodyClick;
    tagTbody.append(fragment);

    return true;
};

// =============================
// Obtener Canvas
// =============================

let id_dictionary_click = null;

const   tagCanvasConfig = document.querySelector("#canvasConfig"),
        tagCanvasConfigHeader = document.querySelector("#canvasConfigHeader"),
        tagCanvasConfigTitle = tagCanvasConfigHeader.querySelector(".offcanvas-title"),
        tagCanvasConfigBody = document.querySelector("#canvasConfigBody"),
        tagCanvasConfigConfirm = document.querySelector("#canvasConfigConfirmQuery"),
        tagCanvasConfigLoading = document.querySelector("#canvasConfigLoading"),
        canvasConfig = new bootstrap.Offcanvas(tagCanvasConfig);

const fetchDictionary = (id_dictionary) => {
    return fetch(
        `/API/dictionaries/dictionaries-description.php?id_dictionary=${id_dictionary}`
    ).then(
        (response) => response.json()
    );
};

const fetchDictionaryDisabled = (id_dictionary) => {
    return fetch(
        `/API/dictionaries/dictionaries-description-disabled.php?id_dictionary=${id_dictionary}`
    ).then(
        (response) => response.json()
    );
};

const eventTagTBodyClick = (el) => {
    const functionTag = el.target.getAttribute("function");

    id_dictionary_click = el.target.parentElement.parentElement.getAttribute("id_dictionary");

    switch (functionTag) {
        case 'update':
            canvasConfig.show();
            fetchDictionary(id_dictionary_click)
                .then(drawCanvasConfigUpdate)
                .then(showBody);
            break;

        case 'delete':
            canvasConfig.show();
            fetchDictionary(id_dictionary_click)
                .then(drawCanvasConfigDelete)
                .then(showBody);
            break;

        case 'enable':
            canvasConfig.show();
            fetchDictionaryDisabled(id_dictionary_click)
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
// Eliminar Diccionario
// =============================

const deleteDictionary = (id_dictionary) => {
    return fetch(`/API/dictionaries/dictionaries-delete.php?id_dictionary=${id_dictionary}`).then(
        (response) => response.text()
    );
};

const formSubmitDelete = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    deleteDictionary(id_dictionary_click)
        .then(fetchCorrect)
        .then(()=>document.querySelector(`[id_dictionary="${id_dictionary_click}"]`).outerHTML = '');
    
    return true;
};

const drawCanvasConfigDelete = (response) => {
    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigDelete"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.textContent = "Eliminar Diccionario";
    tagCanvasConfigHeader.style.color = 'var(--bs-red)';

    newTemplate.querySelector(".canvasConfigNameDraw").textContent = response.NAME;
    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitDelete;

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    return true;
};

// =============================
// Actualizar Diccionario
// =============================

const updateDictionary = (id_dictionary,name) => {
    return fetch(
        `/API/dictionaries/dictionaries-update.php?name=${name}&id_dictionary=${id_dictionary}`
    ).then((response) => response.text());
};

const formSubmitUpdate = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    const name = document.querySelector('#configUpdate').value.trim();
        
    updateDictionary(id_dictionary_click, name)
        .then(fetchCorrect)
        .then(()=>{
            tagShowModify.click();
        });;
    
    return true;
};

const drawCanvasConfigUpdate = (response) => {
    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigUpdate"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.innerHTML = `Modificar Diccionario<br>"<spam class="fst-italic">${response.NAME}</spam>"`;
    tagCanvasConfigHeader.style.color = 'var(--bs-green)';

    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitUpdate;
    newTemplate.querySelector('#configUpdate').setAttribute('placeholder',response.NAME);

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    return true;
};

// =============================
// Crear Nuevo Diccionario
// =============================

const tagCreateNewDictionary = document.querySelector('#createNewDictionary');

const createWord = (name) => {
    return fetch(
        `/API/dictionaries/dictionaries-create.php?name=${name}`
    ).then((response) => response.text());
};

const formSubmitInsert = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    const name = document.querySelector('#configCreate').value.trim();

    createWord(name)
        .then(fetchCorrect)
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

    tagCanvasConfigTitle.innerHTML = `Crear Nuevo Diccionario`;
    tagCanvasConfigHeader.style.color = 'var(--bs-blue)';
    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitInsert;

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    showBody();

    return true;
}

tagCreateNewDictionary.addEventListener('click',drawCanvasConfigInsert)

// =============================
// Habilitar Diccionario
// =============================

const enableDictionary = (id_dictionary) => {
    return fetch(
        `/API/dictionaries/dictionaries-enable.php?id_dictionary=${id_dictionary}`
    ).then((response) => response.text());
}

const formSubmitEnable = (e) => {
    e.preventDefault();

    hideElementsCanvasConfig();
    showLoadingCanvasConfig();

    enableDictionary(id_dictionary_click)
        .then(fetchCorrect)
        .then(()=>document.querySelector(`[id_dictionary="${id_dictionary_click}"]`).outerHTML = '');
    
    return true;
};

const drawCanvasConfigEnable = (response) => {
    const   tagTemplateCanvasConfig = document.querySelector("#templateCanvasConfigEnable"),
            newTemplate = tagTemplateCanvasConfig.content.cloneNode(true);

    tagCanvasConfigTitle.textContent = "Habilitar Diccionario";
    tagCanvasConfigHeader.style.color = 'var(--bs-blue)';

    newTemplate.querySelector(".canvasConfigWordDraw").textContent = response.NAME;
    newTemplate.querySelector(".canvasConfigForm").onsubmit = formSubmitEnable;

    tagCanvasConfigBody.innerHTML = "";
    tagCanvasConfigBody.append(newTemplate);

    return true;
};