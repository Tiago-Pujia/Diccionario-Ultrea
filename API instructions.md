# Instrucciones de Uso de la API :pushpin:

Toda la información entregada de rotorno tiene formato ".json".

Los archivos en /admin requieren el logueo de administrado o no se tendra acceso. Esta se almacena por cookies en admin

Se creo un mapa contextual para comprender mejor el uso:

~~~
API
|
|-> admin
|   |
|   |-> word-create.php
|   |-> word-create.php
|   |-> word-delete.php
|   |-> word-enable.php
|   |-> word-update.php
|   |
|   |-> word-count-disabled.php
|   |-> word-description-disabled.php
|   |-> word-listing-disabled.php
|
|-> client
|   |
|   |-> word-count.php
|   |-> word-description.php
|   |-> word-listing.php
|   |-> word-for-field.php
|
|-> type-word
|   |
|   |-> type-word-description.php
|   |-> type-word-listing.php
|
|-> verify
|   |
|   |-> verify-dictionary-used.php
|   |-> verify-session-admin
|       |
|       |-> rediret.php
|
|-> dictionaries
|   |
|   |-> dictionaries-create.php
|   |-> dictionaries-delete.php
|   |-> dictionaries-update.php
|   |-> dictionaries-enable.php
|   |-> dictionaries-description.php
|   |-> dictionaries-listing.php
|   |-> dictionaries-listing-disabled.php
|   
~~~

---------
---------

## :book: Uso al Cliente :book:

### Resultados totales

> /API/client/word-count.php

Obtenemos la suma de los todos los registros de palabras que esten habilitados

> **Datos Necesarios:**
> 
> - GET:
>     - 'words_search' -> _string_
>     - 'field' -> _string_
>     - 'id_type_word' -> _numero_
> 
> **Datos de Retorno:**
> 
> - COUNT

### Descripción de Termino

> /API/client/word-description.php

Obtenemos la descripción de una sola palabra

> **Datos Necesarios:**
> 
> - GET: 
>      - 'id_word' -> _numero_ (obligatorio)
> 
> **Datos de Retorno:**
> - WORD 
> - PRONUNCIATION
> - SIGNIFICANSE
> - TYPE_WORD

### Busquedas de Multiples Terminos

> /API/client/word-for-field.php

Obtenemos multiples resultados segun los filtros que le pasemos. Esta paginado cada 25 resultados, por lo que se debe especificar la pagina.

>**Datos Necesarios:**
>
> - GET: 
>    - 'words_search' -> _string_ (obligatorio)
>    - 'field' -> _opciones(ultrea,pronunciation,significance)_
>    - 'page' -> _numero_
>    - 'id_type_word' -> _numero_
>
> **Datos de Retorno:**
> - ID_WORD
> - WORD = _(idioma,pronuncación o significado segun lo usado)_


### Lista de Palabras con su Descripción
> /API/client/word-listing

Obtenemos una lista paginada de palabras con su descripción

**Datos Necesarios:**

> - GET: 
>     - 'page' -> _numero_
> 
> **Datos de Retorno:**
> - ID_WORD
> - WORD
> - PRONUNCIATION
> - SIGNIFICANSE
> - TYPE_WORD

----------
----------

## :wrench: Uso Exclusivo Administradores :wrench:

### Creación de un nuevo Termino
> /API/admin/word-create.php

Creamos un nuevo termino

> **Datos Necesarios:**
>
> - GET:
>     - 'word' -> _string_ (obligatorio)
>     - 'pronunciation' -> _string_
>     - 'significanse' -> _string_
>     - 'id_type_word' -> _numero_

### Deshabiltar Termino
> /API/admin/word-delete.php

Deshabilitamos un termino para que este fuera del alcanze un cliente

> **Datos Necesarios:**
> 
> - GET:
>     - 'id_word' -> _numero_ (obligatorio)

### Habilitar Termino
> /API/admin/word-enable.php

Habilitamos un termino ya desactivado por "word-delete.php" para la vista de todo el mundo

> **Datos Necesarios:**
> 
> - GET:
>     - 'id_word' -> _numero_ (obligatorio)

### Modificar Termino
> /API/admin/word-update.php

Modificamos un termino

> **Datos Necesarios:**
> 
> - GET:
>     - 'id_word' -> _numero_ (obligatorio)
>     - 'word' -> _string_
>     - 'pronunciation' -> _string_
>     - 'significanse' -> _string_
>     - 'id_type_word' -> _numero_ o null


### Resultados Totales Eliminados

> /API/client/word-count.php

Obtenemos la suma de los todos los registros de palabras que esten eliminados

> **Datos Necesarios:**
> 
> - GET:
>     - 'words_search' -> _string_
>     - 'field' -> _string_
>     - 'id_type_word' -> _numero_
> 
> 
> **Datos de Retorno:**
> 
> - COUNT

### Obtener Descripción de un termino deshabilitado

> /API/admin/word-description-disabled.php

> **Datos Necesarios:**
> 
> - GET:
>     - 'id_word' -> _numero_ (obligatorio)
> 
> **Datos de Retorno:**
> 
> - WORD
> - PRONUNCIATION
> - SIGNIFICANSE

### Lista de Palabras Deshabilitadas con su Descripción

> /API/admin/word-listing-disabled.php

Obtenemos una lista paginada cada 25 saltos, de palabras con su descripción

> **Datos Necesarios:**
> 
> - GET: 
>     - 'page' -> _numero_
> 
> **Datos de Retorno:**
> - ID_WORD
> - WORD
> - PRONUNCIATION
> - SIGNIFICANSE

---------
---------

## :black_nib: Tipo de Palabras :black_nib:

Nos referimos a los datos guardados en la tabla "tbl_type_word"

### Lista de Nombres

> /API/type-words/type-word-listing.php

Obtenemos los nombres de los tipos de palabras. No es necesario enviarle información

> **Datos de Retorno:**
> - ID_TYPE
> - NAME

### Descripción de un Tipo

> /API/type-words/type-word-description.php

Obtenemos el nombre segun el ID que le demo

> **Datos Necesarios:**
> - GET:
>   - 'id_type_word' -> _numero_
>
> **Datos de Retorno:**
> - NAME

---------
---------

## :arrows_counterclockwise: Verificar/Comprobar :arrows_counterclockwise:

### Verificar el uso de Diccionario

> /API/verify/verify-dictionary-used.php

Comprobamos que el usuario esta haciendo uso de un diccionario.

Tan solo debemos implementarlo al inicio de nuestro archivo. Si lo esta usando podra continuar, en caso contrario sera redireccionado a la selección en "/select-dictionaries".


### Verificación Sesion como Admin

> /API/verify/verify-session-admin/redirect.php

Verificamos que el usuario inicio sesion como administrador mediante sus cookies, hacemos uso de la variable almacenada en "verify-session.php".

Si el usuario no esta registrado el contenido no sera mostrado y se cargara un formulario "login.php" para que inicie sesion.

Debemos implementar "redirect.php" al inicio de cada sitio que queramos que se requiera uso de admin.

-------
-------

## :books: Portadas Diccionarios :books:

### Crear Diccionario

> /API/dictionaries/dictionaries-create.php

Creamos un nuevo diccionario

> **Datos Necesarios:**
> - GET:
>   - 'name' -> _string_ (obligatorio)

### Eliminar Diccionario

> /API/dictionaries/dictionaries-delete.php

Deshabilitamos un nuevo diccionario

> **Datos Necesarios:**
> - GET:
>   - 'id_dictionary' -> _numero_ (obligatorio)

### Habilitar Diccionario

> /API/dictionaries/dictionaries-delete.php

Habilitamos un diccionario que fue eliminado

> **Datos Necesarios:**
> - GET:
>   - 'id_dictionary' -> _numero_ (obligatorio)

### Actualizar Diccionario

> /API/dictionaries/dictionaries-update.php

Modificamos los datos de un diccionario

> **Datos Necesarios:**
> - GET:
>   - 'id_dictionary' -> _numero_ (obligatorio)
>   - 'name' -> _string_

### Descripcion de un Diccionario

> /API/dictionaries/dictionaries-description.php

Leemos los datos un diccionario habilitado o deshabilitado

> **Datos Necesarios:**
> - GET:
>   - 'id_dictionary' -> _numero_ (obligatorio)
>
> **Datos de Retorno**
> - NAME
> - WORDS_COUNT
> - DATE_CREATION

### Descripcion de un Diccionario

> /API/dictionaries/dictionaries-listing.php

Obtenemos una lista de los diccionarios disponibles

> **Datos de Retorno**
> - ID_DICTIONARY
> - NAME
> - WORDS_COUNT
> - DATE_CREATION

### Descripcion de un Diccionario

> /API/dictionaries/dictionaries-listing-disabled.php

Obtenemos una lista de los diccionarios no disponibles

> **Datos de Retorno**
> - ID_DICTIONARY
> - NAME
> - WORDS_COUNT
> - DATE_CREATION