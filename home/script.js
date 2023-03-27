const tagLoading = document.querySelector("#loading");
const tagMain = document.querySelector("main");
const inputSearch = document.querySelector("#search");

// =============================
// DataList, autocompletado del input
// =============================

const tagDatalist = document.querySelector("#datalistOptions");

const hideDataList = () => {
    tagDatalist.innerHTML = "";
    tagDatalist.classList.add("d-none");
};

const showDataList = () => {
    tagDatalist.classList.remove("d-none");
    tagDatalist.scrollTo(0,0);   
};

tagDatalist.addEventListener("click", (el) => {
    let itemActive = tagDatalist.querySelector('.active');
        itemActive.classList.remove('active');

    el.target.classList.add('active');
        
    itemActive = tagDatalist.querySelector('.active')

    const id_word_tab = itemActive.getAttribute('id');

    history.replaceState(null, "", `/home/?id_word=${id_word_tab}`);
    fetchWord(getQueryVariable("id_word"));

    inputSearch.value = itemActive.textContent;
    hideDataList();
    return true;
});

const drawDataListWordsSuggestions = (data) => {
    const fragment = document.createDocumentFragment();

    data.forEach((el) => {
        let createTagLi = document.createElement("li");

        createTagLi.setAttribute('id',el.ID_WORD)
        createTagLi.textContent = el.WORD;
        createTagLi.classList.add("list-group-item");
        createTagLi.classList.add("list-group-item-action");

        fragment.append(createTagLi);
    });

    tagDatalist.innerHTML = "";
    tagDatalist.append(fragment);

    if (tagDatalist.length != 0) {
        Array.from(tagDatalist.querySelectorAll("li"))[0].classList.add(
            "active"
        );
    }

    return true;
};

const moveDatalist = (key) => {
    let itemActive = tagDatalist.querySelector(".active");

    let itemActiveHeight = Number(getComputedStyle(itemActive).height.replace('px',''));
    let scroll = tagDatalist.scrollTop;
    
    switch (key) {
        case "ArrowDown":
            let itemNext = itemActive.nextElementSibling;

            if(itemNext != null && Number(itemNext.getAttribute('id'))){
                itemActive.classList.remove("active");
                itemNext.classList.add("active"); 

                tagDatalist.scrollTo({
                    top: scroll + itemActiveHeight,
                    left: 0,
                    behavior: "smooth",
                });
            }
            break;

        case "ArrowUp":
            let itemPrevious = itemActive.previousElementSibling;

            if(itemPrevious != null && Number(itemPrevious.getAttribute('id'))){
                tagDatalist.scrollTo({
                    top: scroll - itemActiveHeight,
                    left: 0,
                    behavior: "smooth",
                });

                itemActive.classList.remove("active");
                itemPrevious.classList.add("active");
            }
            break;

        case "Tab":
            const id_word_tab = itemActive.getAttribute('id');

            history.replaceState(null, "", `/home/?id_word=${id_word_tab}`);
            fetchWord(getQueryVariable("id_word"));

            inputSearch.value = itemActive.textContent;
            hideDataList();
            break;
    }

    document.querySelector("body").onclick = function () {
        hideDataList();
        this.onclick = "";
    };
};

inputSearch.addEventListener("keydown", (el) => moveDatalist(el.key));

inputSearch.addEventListener("input", function (el) {
    let wordSearch = this.value;
    let selectSearch = document.querySelector("#selectSearch");
        selectSearch = selectSearch.options[selectSearch.selectedIndex].value;
    let typeWord = tagSelectTypeWord.options[tagSelectTypeWord.selectedIndex].value;

    if (el.data) {
        fetchWordsSuggestions(selectSearch, wordSearch, 0, typeWord)
            .then(drawDataListWordsSuggestions)
            .then(showDataList);
    }

    return true;
});

// =============================
// Obtener sugerencias
// =============================

const formSubmit = document.querySelector("#formSubmit");
const tagContainerListResults = document.querySelector("#listResults");
const taglistResults = tagContainerListResults.querySelector('ul')

formSubmit.addEventListener("submit", (e) => {
    e.preventDefault();
    hideDataList();

    let wordSearch = document.querySelector("#search").value.trim();
    let selectSearch = document.querySelector("#selectSearch");
        selectSearch = selectSearch.options[selectSearch.selectedIndex].value;
    let typeWord = tagSelectTypeWord.options[tagSelectTypeWord.selectedIndex].value;

    tagLoading.classList.remove("d-none");
    tagMain.classList.add("d-none");

    fetchWordsCount(selectSearch, wordSearch, typeWord)
        .then(drawWordsCount);

    fetchWordsSuggestions(selectSearch, wordSearch, 0,typeWord)
        .then((response)=>{
            taglistResults.setAttribute('wordSearch',wordSearch);
            taglistResults.setAttribute('page',0);
            taglistResults.setAttribute('field',selectSearch);
            taglistResults.innerHTML = 
                `<li class="list-group-item list-group-item-primary p-1 text-center text-danger order-5" id="loadingListResults">
                    <div class="spinner-border"></div>
                </li>`;

            tagContainerListResults.onscroll = scrollEventListResults;
            return response;
        })
        .then(drawWordsSuggestions)
        .then(()=>{
            tagLoading.classList.add("d-none");
            tagMain.classList.remove("d-none");    
            tagContainerListResults.scrollTo(0,0);    
        })
        .then(()=>{
            if(
                Number(getComputedStyle(taglistResults).height.replace('px','')) 
                <= 
                Number(getComputedStyle(tagContainerListResults)['max-height'].replace('px',''))
            ){
                getDrawListResultsScroll()
            }
        });
    
    return true;
});

const fetchWordsSuggestions = (optionSearch = "ultrea", wordSearch, page = 0, idTypeWord = '') => {
    return fetch(
        `/API/client/word-for-field.php?words_search=${wordSearch}&field=${optionSearch}&page=${page}&id_type_word=${idTypeWord}`
    ).then((response) => response.json());
};

const drawWordsSuggestions = (data) => {
    let fragment = document.createDocumentFragment();

    data.forEach((element) => {
        let id_word = element["ID_WORD"];
        let word = element["WORD"];

        let createTagLi = document.createElement("li");

        createTagLi.textContent = word;
        createTagLi.setAttribute("id_word", id_word);
        createTagLi.classList.add("list-group-item");
        createTagLi.classList.add("list-group-item-action");
        createTagLi.classList.add("list-group-item-primary");
        createTagLi.classList.add("px-1");

        fragment.append(createTagLi);
    });

    taglistResults.append(fragment);

    document.querySelector("#colListResults").classList.remove("d-none");

    return true;
};

taglistResults.addEventListener("click", function (el) {
    let tagClick = el.target;
    let id_word = tagClick.getAttribute("id_word");

    if(!isNaN(id_word)){
        Array.from(this.querySelectorAll("li"))
            .forEach((el) => el.classList.remove("active"));
        
        tagClick.classList.add("active");

        fetchWord(id_word);
        history.replaceState(null, "", `/home/?id_word=${id_word}&id_dictionary=${idDictionary}`);    
    }

    return true;
});

const fetchWordsCount = (optionSearch = "ultrea", wordSearch, idTypeWord='') => {
    return fetch(
        `/API/client/word-count.php?words_search=${wordSearch}&field=${optionSearch}&id_type_word=${idTypeWord}`
    ).then((response) => response.json());
};

const drawWordsCount = (data) => {
    const tagCountResults = document.querySelector("#countResults");
        tagCountResults.textContent = data.COUNT;

    return true;
}

const getDrawListResultsScroll = () => {
    const wordSearch = taglistResults.getAttribute('wordSearch');
    const field = taglistResults.getAttribute('field');
    const page = Number(taglistResults.getAttribute('page')) + 1;
    const typeWord = tagSelectTypeWord.options[tagSelectTypeWord.selectedIndex].value;

    taglistResults.setAttribute('page',page);

    fetchWordsSuggestions(field,wordSearch,page,typeWord)
    .then((response)=>{
        if(response.length){
            drawWordsSuggestions(response);            
            tagContainerListResults.onscroll = scrollEventListResults;
        } else {
            document.querySelector('#loadingListResults').outerHTML = '';
        }
    });            
}

const scrollEventListResults = function(){
    if(this.scrollTop + this.offsetHeight >= this.scrollHeight){
        tagContainerListResults.onscroll = '';
        getDrawListResultsScroll()    
    }
}

// =============================
// Obtener Palabra Especifica
// =============================

const fetchWord = (id_word) => {
    tagLoading.classList.remove("d-none");
    tagMain.classList.add("d-none");

    fetch(`/API/client/word-description.php?id_word=${id_word}`)
        .then((response) => response.json())
        .then(drawWord);

    return true;
};

const drawWord = (obj) => {
    const tagWordSearch = document.querySelector("#word_search"),
        tagPronunciation = document.querySelector("#pronunciation"),
        tagSignificance = document.querySelector("#significance"),
        tagTypeWord = document.querySelector('#typeWord'),
        tagColResult = document.querySelector("#colResult > article");

    const dataWord = obj.WORD,
        dataPronunciation = "[" + obj.PRONUNCIATION + "]",
        dataTranslation = obj.SIGNIFICANCE,
        dataTypeWord = obj.TYPE_WORD;

    tagWordSearch.textContent = dataWord;
    tagPronunciation.textContent = dataPronunciation;
    tagSignificance.textContent = dataTranslation;
    tagTypeWord.textContent = dataTypeWord;

    tagLoading.classList.add("d-none");
    tagMain.classList.remove("d-none");
    tagColResult.classList.remove("d-none");

    return true;
};

if (getQueryVariable("id_word")) {
    fetchWord(getQueryVariable("id_word"));
}

// =============================
// Obtener Tipos de Palabras
// =============================
const tagSelectTypeWord = document.querySelector('#selectType');

fetch("/API/type-words/type-word-listing.php")
    .then((response)=>response.json())
    .then((response)=>{
        const fragment = document.createDocumentFragment();

        response.forEach((el,i)=>{
            const newTagOption = document.createElement('option');
            newTagOption.value = el.ID_TYPE;
            newTagOption.textContent = el.NAME;
            fragment.append(newTagOption);
        });

        tagSelectTypeWord.append(fragment);

        return true;
    })