var getQueryVariable = (variable) => {
    let vars = window.location.search.substring(1).split("&");
    for (let i = 0; i < vars.length; i++) {
        let pair = vars[i].split("=");
        if (pair[0] == variable) return pair[1];
    }
    return false;
};

var idDictionary = getQueryVariable('id_dictionary');