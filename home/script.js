const tagLoading = document.querySelector("#loading");
const tagMain = document.querySelector("main");

// =============================
// Obtener sugerencias
// =============================

const formSubmit = document.querySelector("#formSubmit");
const taglistResults = document.querySelector("#listResults > ul");

formSubmit.addEventListener("submit", (e) => {
    e.preventDefault();

    let wordSearch = document.querySelector("#search").value;
    let selectSearch = document.querySelector("#selectSearch");
    selectSearch = selectSearch.options[selectSearch.selectedIndex].value;

    fetchWordsSuggestions(selectSearch, wordSearch);

    return true;
});

const fetchWordsSuggestions = (optionSearch = "ultrea", wordSearch) => {
    tagLoading.classList.remove("d-none");
    tagMain.classList.add("d-none");

    fetch(
        `getData.php?words_search=${wordSearch}&options_search=${optionSearch}`
    )
        .then((response) => response.json())
        .then(drawWordsSuggestions);

    return true;
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

    fetch(`getData.php?id_word=${id_word}`)
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

// =============================
// Calcular height main
// =============================

// screen.availHeight

/* const configureHeightMain = () => {
    const tagsBodyChildren = Array.from(document.querySelectorAll("body > *"));
    const tagsBodyChildrenHeight = tagsBodyChildren
        .filter(
            (tag) =>
                !Array.from(tag.classList).some(
                    (tagClass) => tagClass == "d-none" || tag.nodeName == "MAIN"
                )
        )
        .map((tag) => Number(getComputedStyle(tag).height.replace("px", "")))
        .reduce((a, b) => a + b, 0);

    // screen.availHeight - tagsBodyChildrenHeight;

    document.querySelector("main").style.height =
        window.innerHeight - tagsBodyChildrenHeight + "px";

    return false;
};
 */
