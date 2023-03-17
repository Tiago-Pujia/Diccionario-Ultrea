# Instrucciones de Uso de la API

Toda la información entregada de rotorno tiene formato ".json"

---------

## "API/client/word-description.php"

**Datos Necesarios:**

- GET: 
    - 'id_word' -> _numero_

**Datos de Retorno:**
- WORD 
- PRONUNCIATION
- SIGNIFICANSE

## "API/client/word-for-field.php"

**Datos Necesarios:**

- GET: 
    - 'words_search' -> _string_
    - 'field' -> _opciones(ultrea,pronunciation,significance)_

**Datos de Retorno:**
- ID_WORD
- WORD = _(idioma,pronuncación o significado segun lo usado)_

## "API/client/word-listing"

**Datos Necesarios:**

- GET: 
    - 'page' -> _numero_

**Datos de Retorno:**
- ID_WORD
- WORD
- PRONUNCIATION
- SIGNIFICANSE