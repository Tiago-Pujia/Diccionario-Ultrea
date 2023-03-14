<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diccionario Ultrea</title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/independences/bootstrap/bootstrap.min.css"/>
        <script src="/independences/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="/independences/bootstrap-icons/font/bootstrap-icons.css"/>
    
    <!-- scripts JS -->
        <script src="script.js" defer="true"></script>
    
    <!-- Styles -->
        <style>
            body{
                min-height: 100vh;
                position: relative;
            }

            main {
                height: 100%;
                /* position: absolute; */
            }

            #listResults {
                max-height: 30vh;
                cursor: pointer;
                scrollbar-width:none;
            }

            /* sm */
            @media (min-width: 576px) {
                main{
                    /* border: 1px solid #000; */
                    border-top: 0;
                    border-bottom: 0;
                }

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
                    width: 50vw !important;
                    height: ;
                }

                main > .row {
                    padding: 0 4vw;
                }
            }
        </style>
</head>
<body class="bg-light position-relative">
    <header class="container-fluid border-bottom border-secondary p-3 bg-dark">
        <h1 class="fst-italic text-uppercase text-primary m-0">Diccionario Ultrea</h1>
    </header>
    <?php include_once "../screens/nav.html" ?>
    <div class="w-100 border-top border-dark border-1"></div>
    <main class="container border-dark border-1 pt-3 pt-md-4 pt-lg-5">
        <div class="row">
            <div class="col-12">
                <div class="row mb-3 mb-xl-5 justify-content-center">
                    <form class="col-xl-9" id="formSubmit">
                        <fieldset class="input-group">
                            <input type="text" id="search" class="form-control" name="words_search" autocomplete="off" placeholder="¿Que quieres buscar?" list="datalistOptions">
                            <datalist id="datalistOptions"></datalist>
                            <button class="btn btn-primary text-light" type="submit"><i class="bi bi-search"></i></button>
                        </fieldset>
                        <fieldset class="mt-4">
                            <div class="form-floating">
                                <select name="options_search" id="selectSearch" class="form-select">
                                    <option value="ultrea" selected>Idioma Ultrea</option>
                                    <option value="pronunciation">Pronunciación</option>
                                    <option value="significance">significado</option>
                                </select>
                                <label for="selectSearch">Opciones de Busqueda</label>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-5 col-md-4 pe-0 me-md-4 d-none" id="colListResults">
                <p class="m-0 mb-lg-2 fw-light">Resultados: <span id="countResults"></span></p>
                <aside id="listResults" class="border-3 border-dark border p-0 mw-100 overflow-scroll">
                    <ul class="list-group list-group-flush"></ul>
                </aside>
            </div>
            <div class="col" id="colResult">
                <article class="d-none">
                    <h2 class="h2 border-bottom mb-3 pb-1" id="word_search"></h2>
                    <p class="text-danger mb-4"><i class="bi bi-arrow-return-right"></i> <span id="pronunciation"></span></p>
                    <p class="m-0"><i class="bi bi-arrow-return-right"></i> <span id="significance"></span></p>
                </article>
            </div>
        </div>
    </main>
    <div class="text-center text-primary d-none" id="loading">
        <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
    </div>
</body>
</html>