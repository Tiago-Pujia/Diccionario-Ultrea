const tagLoading = document.querySelector('#loading');
const tagPagination = document.querySelector('#pagination');
const tagTable = document.querySelector('#table');

// =============================
// Imprimir tabla
// =============================

const fetchWordsData = (page = 0) => {
    return fetch(
        `/API/client/word-listing.php?page=${page}`
    ).then((response) => response.json());
};

const drawDataTable = (info) => {
    const tagTbody = document.querySelector("tbody");
    const fragment = document.createDocumentFragment();

    info.forEach((data) => {
        let createTagTr = document.createElement("tr");
        let idword = data.ID_WORD;
        let dataDraw = [
            `<a href="/home/?id_word=${idword}" target="_blanck"><i class="bi bi-box-arrow-up-left"></i></a>`,
            data.WORD,
            `[${data.PRONUNCIATION}]`, 
            data.SIGNIFICANCE
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

fetchWordsData().then(drawDataTable);

// =============================
// Mostrar y Ocultar Tabla
// =============================

const showTable = () => {
    tagTable.classList.remove('d-none');
    tagLoading.classList.add('d-none');
}

const hideTable = () => {
    tagTable.classList.add('d-none');
    tagLoading.classList.remove('d-none');
}

// =============================
// Botones de Paginación
// =============================

let classPagination;

const drawPagination = () => {
    const tagDrawPagination = tagPagination.querySelector('.showPagination');
    const tagDrawCount = tagPagination.querySelector('.showCount');
    
    tagDrawPagination.innerHTML = '';

    fetch(`/API/client/word-count.php`)
        .then((response)=>response.json())
        .then((response)=>response.COUNT)
        .then((response)=>{
            classPagination = new Pagination(response);

            tagDrawCount.textContent = response;

            classPagination.drawPagination(tagDrawPagination);
            classPagination.functionClick = () => {
                hideTable();
                fetchWordsData(classPagination.page)
                    .then(drawDataTable)
                    .then(showTable);
            };
            
            showTable();
        });
}

drawPagination();