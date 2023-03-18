# Instrucciones de Uso de la API

Toda la información entregada de rotorno tiene formato ".json"

---------

## Descripción de Termino
### "API/client/word-description.php"

Obtenemos la descripción de una sola palabra

**Datos Necesarios:**

- GET: 
    - 'id_word' -> _numero_

**Datos de Retorno:**
- WORD 
- PRONUNCIATION
- SIGNIFICANSE

## Busquedae de Multiples Terminos
### "API/client/word-for-field.php"

Obtenemos multiples ID y palabras por la busqueda de una palabra y tipo de campo

**Datos Necesarios:**

- GET: 
    - 'words_search' -> _string_
    - 'field' -> _opciones(ultrea,pronunciation,significance)_

**Datos de Retorno:**
- ID_WORD
- WORD = _(idioma,pronuncación o significado segun lo usado)_


## Lista de Palabras
### "API/client/word-listing"

Obtenemos una lista paginada de palabras con su descripción

**Datos Necesarios:**

- GET: 
    - 'page' -> _numero_

**Datos de Retorno:**
- ID_WORD
- WORD
- PRONUNCIATION
- SIGNIFICANSE