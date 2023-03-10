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

    <!-- Styles -->
        <style>
            *{
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
</head>
<body class="bg-light">
    <header class="container-fluid border-bottom border-secondary p-3 bg-dark">
        <h1 class="fst-italic text-uppercase text-primary m-0">Diccionario Ultrea</h1>
    </header>
    <?php include_once "../screens/nav.html" ?>
    <main class="container mt-5" style="min-height: 4em;">
        <div class="row justify-content-center">
            <form id="form" class="col-lg-6" method="GET" action="/queried-words/">
                <fieldset class="input-group h-100">
                    <button class="btn btn-primary text-light" type="submit"><i class="bi bi-search"></i></button>
                    <input type="text" id="search" class="form-control" name="word" placeholder="Buscar...">

                    <button class="dropdown-toggle btn btn-secondary" data-bs-toggle="dropdown" type="button"></button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Buscar Por:</li>
                        <li class="dropdown-divider"></li>
                        <label for="inputUltrea" class="dropdown-item">
                            <div class="form-check">
                                <input type="radio" name="option" class="form-check-input" id="inputUltrea" value="ultrea" checked>
                                Idioma Ultrea
                            </div>
                        </label>
                        <label for="inputPronunciation" class="dropdown-item">
                            <div class="form-check">
                                <input type="radio" name="option" class="form-check-input" id="inputPronunciation" value="pronunciation">
                                Pronunciación
                            </div>
                        </label>
                        <label for="inputSpanish" class="dropdown-item">
                            <div class="form-check">
                                <input type="radio" name="option" class="form-check-input" id="inputSpanish" value="spanish">
                                Traducción al Castellano
                            </div>
                        </label>
                    </ul>
                </fieldset>
            </form>
        </div>
    </main>
</body>
</html>