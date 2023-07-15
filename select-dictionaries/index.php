<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diccionarios Disponibles</title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/independences/bootstrap/bootstrap.min.css"/>
        <script src="/independences/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="/independences/bootstrap-icons/font/bootstrap-icons.css"/>
    
    <!-- Styles CSS -->
    <style>
        .card {
            box-shadow: 0 0 3px #fff !important;
        }
    </style>
</head>
<body class="bg-dark text-white">


    <div class="navbar bg-dark color-primary border-bottom border-primary mb-4 mb-md-5">
        <div class="container">
            <div class="navbar-brand m-0">
                <h1 class="text-primary text-wrap m-0">Lista de Diccionarios</h1>
            </div>

            <a class="btn btn-primary border-primary" href="/administration/dictionaries/">
                <i class="bi bi-file-earmark-lock text-light"></i> Administrar Diccionarios
            </a>
        </div>
    </div>
    
    <main class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="cardGroup"></div>
        <div class="text-center text-primary" id="loading">
            <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
        </div>
    </main>

<template id="templateCard">
    <div class="col">
        <div class="card shadow-lg  text-center text-dark">
            <div class="card-header">
                <p class="m-0 fw-light">Agregado el: <span class="date-create"></span></p>
            </div>
            <div class="card-body">
                <h2 class=" my-2 mb-4 fw-semibold"></h2>
                <a class="btn btn-primary shadow">Cargar <i class="bi bi-box-arrow-in-down"></i></a>
            </div>
            <div class="card-footer">
                <p class="m-0 fw-light">Cantidad de Palabras: <span class="words-count"></span></p>
            </div>
        </div>
    </div>
</template>
<script>
    const tagMain = document.querySelector('main');
    const templateCard = document.querySelector('#templateCard');
    const tagGardGroup = document.querySelector('#cardGroup');
    const tagLoading = document.querySelector("#loading");

    fetch('/API/dictionaries/dictionaries-listing.php')
        .then((response)=>response.json())
        .then((response)=>{
            response.forEach(obj => {
                const newTemplate = templateCard.content.cloneNode(true);
                const dateCreate = new Date(obj.DATE_CREATION);
                    newTemplate.querySelector('h2').textContent = obj.NAME;
                    newTemplate.querySelector('.date-create').textContent = `${dateCreate.getDate()}-${dateCreate.getMonth() + 1}-${dateCreate.getFullYear()}`;
                    newTemplate.querySelector('.words-count').textContent = obj.WORDS_COUNT;
                    newTemplate.querySelector('a').setAttribute('href','/home?id_dictionary=' + obj.ID_DICTIONARY);
                tagGardGroup.append(newTemplate);
            });
        }).then(()=>tagLoading.style.display = "none")
</script>
</body>
</html>
