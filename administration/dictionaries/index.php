<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/verify/verify-session-admin/redirect.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Diccionarios</title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/independences/bootstrap/bootstrap.min.css"/>
        <script src="/independences/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="/independences/bootstrap-icons/font/bootstrap-icons.css"/>

    <!-- Scripts JS -->
    <script src="script.js" defer="true"></script>

    <!-- Styles CSS -->
    <style>
        #tableModify td:nth-child(1),
        #tableModify td:nth-child(2){
            text-align:left;
        }

        #tableRemoved td:nth-child(4){
            text-align:center;
        }

        .divider-select{
            font-size: 1.5pt; 
            background-color: #000000;
        }

        @media (max-width: 576px) {
            thead{
                display: none;
            }        
        }

        @media (min-width: 576px){
            #pagination .pagination {
                justify-content: flex-end;
            }
        }

        @media (max-width: 768px){
            .divider-select{
                display: none;
            }
        }

        .table-responsive{
            border-bottom: calc(var(--bs-border-width) * 2) solid #fff !important;
        }
    </style>
</head>
<body class="bg-dark">

    <div class="navbar bg-dark border-bottom border-danger mb-4 mb-md-5">
        <div class="container">
            <div class="navbar-brand m-0">
                <h1 class="text-danger text-wrap m-0">Administrar Diccionarios</h1>
            </div>

            <a class="btn btn-outline-danger" href="/">
                <i class="bi bi-house"></i> Volver al Inicio
            </a>
        </div>
    </div>

    <main class="container mb-5">
        <div class="mb-5 row justify-content-center gy-2">
            <div class="btn-toolbar col-12 col-md-8">
                <div class="row flex-fill">
                    <div class="btn-group btn-group-sm col">
                        <button class="btn btn-light btn-outline-dark border border-white" id="createNewDictionary">Crear</button>
                    </div>
                    <div class="btn-group btn-group-sm col-8" id="btnGroupConfig">
                        <button class="btn btn-light btn-outline-dark border border-white" id="showModify">Modificar</button>
                        <button class="btn btn-light btn-outline-dark border border-white" id="showDeletedes">Ver Eliminados</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="pagination" class="mb-3" style="min-height:2.5rem;">
            <div class="d-none row align-items-center flex-column flex-sm-row gy-2 gy-sm-0" id="paginationTableModify">
                <div class="col">
                    <p class="text-white fw-light m-0">Resultados: <span class="showCount fw-bold"></span></p>
                </div>
                <div class="col"></div>
            </div>
            <div class="d-none row align-items-center flex-column flex-sm-row gy-2 gy-sm-0" id="paginationTableDeletedes">
                <div class="col">
                    <p class="text-white fw-light m-0">Resultados: <span class="showCount fw-bold"></span></p>
                </div>
                <div class="col"></div>
            </div>
        </div>

        <div id="tableModify" class="d-none">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead class="text-uppercase table-group-divider">
                        <tr>
                            <th class="text-light">Nombre</th>
                            <th class="text-light">Cantidad Palabras</th>
                            <th class="text-center text-primary">Abrir</th>
                            <th class="text-center text-success">Actualizar</th>
                            <th class="text-center text-danger">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider text-center"></tbody>
                </table>
            </div>
        </div>

        <div id="tableRemoved" class="d-none">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead class="text-uppercase table-group-divider">
                        <tr>
                            <th class="text-light">Nombre</th>
                            <th class="text-light">Cantidad Palabras</th>
                            <th class="text-light">Fecha</th>
                            <th class="text-center text-primary">Habilitar</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <div id="canvasConfig" class="offcanvas offcanvas-start text-bg-dark">
        <div id="canvasConfigHeader" class="offcanvas-header pb-0 d-none">
            <h3 class="offcanvas-title"></h3>
            <button class="btn-close btn-close-white border" data-bs-dismiss="offcanvas" style="border-color: #000 !important;"></button>
        </div>
        <div id="canvasConfigBody" class="offcanvas-body d-none">

        </div>
        
        <div class="text-center text-success" id="canvasConfigLoading">
            <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
        </div>

        <div id="canvasConfigConfirmQuery" class="text-success text-center d-none">
            <div class="border border-success rounded m-3">
                <div class="bi bi-check-lg w-100 h-100" style="width: 10rem; height: 10rem; font-size: 8rem;"></div>
            </div>
            <p>Petición Realizada</p>
            <button class="btn btn-success" data-bs-dismiss="offcanvas">Aceptar</button>
        </div>
    </div>

<!-- Template Canvas -->
<template id="templateCanvasConfigUpdate">
    <form class="canvasConfigForm">
        <hr class="text-white">
        <fieldset class="mb-4">
            <label class="form-label" for="configUpdate">Nombre del Diccionario</label>
            <input class="form-control" type="text" name="name" id="configUpdate" autocomplete="off">
        </fieldset>
        <hr class="text-white my-4">
        <button class="btn btn-success" type="submit">Actualizar</button>
    </form>
</template>
<template id="templateCanvasConfigDelete">
    <hr class="text-white">
    
    <p class="my-5">¿Estas seguro que desea deshabilitar el diccionario "<spam class="canvasConfigNameDraw"></spam>"?</p>

    <hr class="text-white">

    <form class="canvasConfigForm">
        <button class="btn btn-danger" type="submit">Eliminar</button>
    </form>
</template>
<template id="templateCanvasConfigInsert">
    <form class="canvasConfigForm">
        <hr class="text-white">
        <fieldset class="mb-4">
            <label class="form-label" for="configCreate">Nombre del Diccionario</label>
            <input class="form-control" type="text" name="name" id="configCreate" autocomplete="off">
        </fieldset>
        <hr class="text-white">
        <button class="btn btn-primary" type="submit">Crear Nuevo Diccionario</button>
    </form>
</template>
<template id="templateCanvasConfigEnable">
    <hr class="text-white">
    
    <p class="my-5">¿Estas seguro que desea habilitar el diccionario "<spam class="canvasConfigWordDraw"></spam>"?</p>

    <hr class="text-white">

    <form class="canvasConfigForm">
        <button class="btn btn-primary" type="submit">Habilitar</button>
    </form>
</template>
</body>
</html>