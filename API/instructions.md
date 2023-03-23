# Instrucciones de Uso de la API

Toda la información entregada de rotorno tiene formato ".json".

Los archivos en /admin requieren el logueo de administrado o no se tendra acceso. Esta se almacena por cookies en /administration/log-in

---------

## Descripción de Termino
### "API/client/word-description.php"

Obtenemos la descripción de una sola palabra

**Datos Necesarios:**

- GET: 
    - 'id_word' -> _numero_ (obligatorio)

**Datos de Retorno:**
- WORD 
- PRONUNCIATION
- SIGNIFICANSE

## Busquedas de Multiples Terminos
### "API/client/word-for-field.php"

Obtenemos multiples ID y palabras por la busqueda de una palabra y tipo de campo. Esta pagina cada 25 resultados, por lo que debemos especificar la pagina.

**Datos Necesarios:**

- GET: 
    - 'words_search' -> _string_ (obligatorio)
    - 'field' -> _opciones(ultrea,pronunciation,significance)_
    - 'page' -> _numero_

**Datos de Retorno:**
- ID_WORD
- WORD = _(idioma,pronuncación o significado segun lo usado)_


## Lista de Palabras con su Descripción
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

## Resultados totales

### "API/client/word-count.php"

Obtenemos la cuenta total de resultados de una busqueda de palabras no desactivadas

**Datos Necesarios:**

- GET:
    - 'words_search' -> _string_ (obligatorio)
    - 'field' -> _string_

---------

## Verificar Sesión

### "API/admin/verify-session.php"

Obtenemos la variable "$verifySession" que verifica si el usuario esta logueado como admin

## Creación de un nuevo Termino

### "API/admin/word-create.php"

Creamos un nuevo termino. Solo especificamos palabra, pronunciación y significado

**Datos Necesarios:**

- GET: 
    - 'word' -> _string_ (obligatorio)
    - 'pronunciation' -> _string_
    - 'significanse' -> _string_

## Modificar Termino

### "API/admin/word-update.php"

Modificamos un termino

**Datos Necesarios:**

- GET:
    - 'id_word' -> _numero_ (obligatorio)
    - 'word' -> _string_
    - 'pronunciation' _string_
    - 'significanse' _string_

## Deshabiltar Termino

### "API/admin/word-delete.php"

Deshabilitamos un termino para que este fuera del alcanze un cliente

**Datos Necesarios:**

- GET:
    - 'id_word' -> _numero_ (obligatorio)

## Habilitar Termino

### "API/admin/word-enable.php"

Habilitamos un termino ya desactivado por "word-delete.php" para la vista de todo el mundo

**Datos Necesarios:**

- GET:
    - 'id_word' -> _numero_ (obligatorio)

## Obtener Descripción de un termino deshabilitado

### "API/admin/word-description-disabled.php"

**Datos Necesarios:**

- GET:
    - 'id_word' -> _numero_ (obligatorio)

**Datos de Retorno:**

- WORD
- PRONUNCIATION
- SIGNIFICANSE

## Lista de Palabras Deshabilitadas con su Descripción

### "API/admin/word-listing-disabled.php"

Obtenemos una lista paginada de palabras con su descripción

**Datos Necesarios:**

- GET: 
    - 'page' -> _numero_

**Datos de Retorno:**
- ID_WORD
- WORD
- PRONUNCIATION
- SIGNIFICANSE