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
    <header class="border-bottom border-primary border-1 mb-5">
        <div class="container py-3">
            <h1 class="ps-3 m-0 display-5 text-primary text-capitalize">Lista de Diccionarios</h1>
        </div>
    </header>
    
    <main class="container">
        <div class="row g-3" id="cardGroup"></div>
    </main>

<template id="templateCard">
    <div class="col col-md-4 col-lg-3">
        <div class="card shadow-lg  text-center text-dark">
            <div class="card-header">
                <p class="m-0 fw-light">ID: <span class="id"></span></p>
            </div>
            <div class="card-body">
                <h2 class=" my-2 mb-4 fw-semibold">asd</h2>
                <a class="btn btn-primary shadow">Cargar <i class="bi bi-box-arrow-in-down"></i></a>
            </div>
            <div class="card-footer">
                <p class="m-0 fw-light">Agregado el: <span class="date-create"></span></p>
            </div>
        </div>
    </div>
</template>
<script>
    const tagMain = document.querySelector('main');
    const templateCard = document.querySelector('#templateCard');
    const tagGardGroup = document.querySelector('#cardGroup');

    fetch('/API/dictionaries/dictionaries-listing.php')
        .then((response)=>response.json())
        .then((response)=>{
            response.forEach(obj => {
                const newTemplate = templateCard.content.cloneNode(true);
                const dateCreate = new Date(obj.DATE_CREATION);
                    newTemplate.querySelector('h2').textContent = obj.NAME;
                    newTemplate.querySelector('.date-create').textContent = `${dateCreate.getDate()}-${dateCreate.getMonth() + 1}-${dateCreate.getFullYear()}`;
                    newTemplate.querySelector('.id').textContent = obj.ID_DICTIONARY;
                    newTemplate.querySelector('a').setAttribute('href','/home?id_dictionary=' + obj.ID_DICTIONARY);
                tagGardGroup.append(newTemplate);
            });
        })
</script>
</body>
</html>
