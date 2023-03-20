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

    switch (key) {
        case "ArrowDown":
            itemActive.classList.remove("active");
            itemActive.nextElementSibling.classList.add("active");
            break;

        case "ArrowUp":
            itemActive.classList.remove("active");
            itemActive.previousElementSibling.classList.add("active");
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
        hideDataList();
    };
};

inputSearch.addEventListener("keydown", (el) => moveDatalist(el.key));

// =============================
// Obtener sugerencias
// =============================

const formSubmit = document.querySelector("#formSubmit");
const taglistResults = document.querySelector("#listResults > ul");

formSubmit.addEventListener("submit", (e) => {
    e.preventDefault();
    hideDataList();

    let wordSearch = document.querySelector("#search").value;
    let selectSearch = document.querySelector("#selectSearch");
    selectSearch = selectSearch.options[selectSearch.selectedIndex].value;

    tagLoading.classList.remove("d-none");
    tagMain.classList.add("d-none");
    fetchWordsSuggestions(selectSearch, wordSearch).then(drawWordsSuggestions);

    return true;
});

inputSearch.addEventListener("input", function (el) {
    let wordSearch = this.value;
    let selectSearch = document.querySelector("#selectSearch");
    selectSearch = selectSearch.options[selectSearch.selectedIndex].value;

    if (el.data) {
        fetchWordsSuggestions(selectSearch, wordSearch)
            .then(drawDataListWordsSuggestions)
            .then(showDataList);
    }

    return true;
});

const fetchWordsSuggestions = (optionSearch = "ultrea", wordSearch) => {
    return fetch(
        `/API/client/word-for-field.php?words_search=${wordSearch}&field=${optionSearch}`
    ).then((response) => response.json());
};

const drawWordsSuggestions = (data) => {
    const tagColListResults = document.querySelector("#colListResults");
    const tagCountResults = document.querySelector("#countResults");

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

    tagLoading.classList.add("d-none");
    tagMain.classList.remove("d-none");

    taglistResults.innerHTML = "";
    taglistResults.append(fragment);

    tagColListResults.classList.remove("d-none");
    tagCountResults.textContent = data.length;

    return true;
};

taglistResults.addEventListener("click", function (el) {
    let tagClick = el.target,
        id_word = tagClick.getAttribute("id_word");

    Array.from(this.querySelectorAll("li")).forEach((el) =>
        el.classList.remove("active")
    );
    tagClick.classList.add("active");

    fetchWord(id_word);
    history.replaceState(null, "", `/home/?id_word=${id_word}`);

    return true;
});

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
        tagColResult = document.querySelector("#colResult > article");

    const dataWord = obj.WORD,
        dataPronunciation = "[" + obj.PRONUNCIATION + "]",
        dataTranslation = obj.SIGNIFICANSE;

    tagWordSearch.textContent = dataWord;
    tagPronunciation.textContent = dataPronunciation;
    tagSignificance.textContent = dataTranslation;

    tagLoading.classList.add("d-none");
    tagMain.classList.remove("d-none");
    tagColResult.classList.remove("d-none");

    return true;
};

const getQueryVariable = (variable) => {
    let vars = window.location.search.substring(1).split("&");
    for (let i = 0; i < vars.length; i++) {
        let pair = vars[i].split("=");
        if (pair[0] == variable) return pair[1];
    }
    return false;
};

if (getQueryVariable("id_word")) {
    fetchWord(getQueryVariable("id_word"));
}