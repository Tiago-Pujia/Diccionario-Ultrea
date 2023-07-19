<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/API/verify/verify-dictionary-used.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar en el Diccionario</title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/independences/bootstrap/bootstrap.min.css"/>
        <script src="/independences/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="/independences/bootstrap-icons/font/bootstrap-icons.css"/>
    
    <!-- scripts JS -->
        <script src="/screens/getQueryVariable.js"></script>
        <script src="script.js" defer="true"></script>
    
    <!-- Styles -->
        <style>
            #listResults {
                max-height: 30vh;
            }

            #datalistOptions {
                max-height: 35vh;
                z-index: 10;
            }

            #datalistOptions,
            #listResults{
                cursor: pointer;
                scrollbar-width:none;
            }

            main{
                height: 60vh;
            }

            .divider-select{
                font-size: 1.5pt; 
                background-color: #000000;
            }

            /* sm */
            @media (min-width: 576px) {
                main > .row {
                    padding: 0 2vw;
                }
            }

            /* medium */
            @media (min-width: 768px) {  
                main > .row {
                    padding: 0 6vw;
                }
            }

            @media (max-width: 768px){
                .divider-select{
                    display: none;
                }
            }

            /* large */
            @media (min-width: 992px) {
                main{
                    width: 70vw !important;
                }

                main > .row {
                    padding: 0 10vw;
                }
            }

            /* xl */
            @media (min-width: 1200px) {
                main{
                    width: 60vw !important;
                }

                main > .row {
                    padding: 0 4vw;
                }
            }
        </style>
</head>
<body class="bg-dark position-relative">

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/screens/header.html' ?>
    <script>
        tagLinkHome.classList.add('active');
    </script>

    <main class="container border-dark border-1">
        <div class="row px-md-1">
            <div class="col-12">
                <div class="row mb-3 mb-xl-5 justify-content-center">
                    <form class="col-xxl-9 col-xl-10" id="formSubmit">
                        <fieldset class="input-group">
                            <input type="text" id="search" class="form-control" name="words_search" autocomplete="off" placeholder="¿Qué querés buscar?">
                            <ul id="datalistOptions" class="d-none list-group position-absolute top-100 w-100 overflow-scroll rounded border border-2 border-dark"></ul>
                            <button class="btn btn-primary text-light" type="submit"><i class="bi bi-search"></i></button>
                        </fieldset>
                        <fieldset class="mt-2 mt-md-4 row">
                            <div class="col pe-1 pe-md-2">
                                <div class="form-floating">
                                    <select id="selectSearch" class="form-select">
                                        <option value="ultrea" selected>Idioma Original</option>
                                        <option value="significance">Castellano</option>
                                    </select>
                                    <label for="selectSearch">Campo de Búsqueda</label>
                                </div>
                            </div>
                            <div class="col ps-1 ps-md-3">
                                <div class="form-floating">
                                    <select id="selectType" class="form-select">
                                        <option value="" selected>Sin Filtro</option>
                                        <option class="divider-select" disabled>&nbsp;</option>
                                    </select>
                                    <label for="selectType">Clase de Palabra</label>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-5 col-md-4 pe-0 me-md-4 d-none" id="colListResults">
                <p class="m-0 mb-lg-2 fw-light text-white">Resultados: <span id="countResults"></span></p>
                <aside id="listResults" class="border-3 border-primary-subtle border p-0 mw-100 overflow-scroll">
                    <ul class="list-group list-group-flush"></ul>
                </aside>
            </div>
            <div class="col" id="colResult">
                <article class="d-none text-white">
                    <h2 class="h2 border-bottom mb-3 pb-1" id="word_search"></h2>
                    <p class="text-danger mb-4"><i class="bi bi-arrow-return-right"></i> <span id="pronunciation"></span></p>
                    <p class="text-success mb-4"><i class="bi bi-arrow-return-right"></i> <span id="significance"></span></p>
                    <p class="text-info m-0"><i class="bi bi-arrow-return-right"></i> <span id="typeWord"></span></p>
                </article>
            </div>
        </div>
    </main>

    <div class="text-center text-primary d-none" id="loading">
        <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
    </div>
</body>
</html>