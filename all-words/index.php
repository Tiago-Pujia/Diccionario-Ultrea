<?php
$page = isset($_GET['page']) ? $_GET['page'] : 0;

include_once "../crud.php";

$query = "SELECT COUNT(ID_WORD) AS 'rowsCount' FROM tbl_words;";
$rowsCount = $crud->query($query)[0]['rowsCount'];
$pageCount = floor($rowsCount/25)
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Palabras Ultrea</title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/independences/bootstrap/bootstrap.min.css"/>
        <script src="/independences/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="/independences/bootstrap-icons/font/bootstrap-icons.css"/>
</head>
<body>
    <header class="container-fluid row">
        <h1 class="display-5 col-md display-4 m-0">Lista de Palabras Totales</h1>
        <div class="col-md-1 align-self-lg-center ">
            <a href="/home" class="btn btn-outline-primary btn-sm mt-5-md">Inicio</a>
        </div>
    </header>
    <div class="container-fluid pb-2">
        <div>
            <p>Resultados Totales: <strong><?php echo $rowsCount; ?></strong></p>
            <p>Paginas: <strong><?php echo $pageCount; ?></strong></p>
        </div>
    </div>
    <nav class="container-fluid mt-3">
        <ul class="pagination justify-content-center">
            <?php if($page != 0){ ?>
            <!-- Anterior Pagina --> <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>">&laquo;</a></li>
            <!-- Primer Pagina --> <li class="page-item btn-outline-dark"><a class="page-link" href="?page=0">0</a></li>
            <?php } ?>

            <?php
                $pageRes5 = ($page - 5);
                if($pageRes5 > 0){
            ?>
            <!-- 5 Paginas Antes --> <li class="page-item"><a class="page-link" href="?page=<?php echo $pageRes5;  ?>"><?php echo $pageRes5; ?></a></li>
            <?php } ?>

            <!-- Pagina Actual --> <li class="page-item"><a class="page-link active" href="<?php echo $page; ?>"><?php echo $page; ?></a></li>

            <?php
                $pageSum5 = ($page + 5);
                if($pageSum5 < $pageCount){
            ?>
            <!-- 5 Paginas Despues --> <li class="page-item"><a class="page-link" href="?page=<?php echo $pageSum5;  ?>"><?php echo $pageSum5; ?></a></li>
            <?php } ?>

            <?php if($page != $pageCount){ ?>
            <!-- Ultima Pagina --> <li class="page-item"><a class="page-link" href="?page=<?php echo $pageCount;?>"><?php echo $pageCount;?></a></li>
            <!-- Pagina Siguiente --> <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>">&raquo;</a></li>
            <?php } ?>
        </ul>
    </nav>
    <main class="container-fluid">
        <div class="table-responsive">
            <table class="table table-hover d-none" id="table">
                <thead>
                    <tr class="table-dark">
                        <th class="col">#</th>
                        <th class="col">PALABRA</th>
                        <th class="col">PRONUNCIACIÓN</th>
                        <th class="col">TRADUCCIÓN</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="text-center text-primary" id="loading">
            <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
        </div>
    </main>
    <script>
        const nav = document.querySelector('nav');
        const main = document.querySelector('main');
        const table = document.querySelector('#table');
        const tbody = document.querySelector('tbody');
        const loading = document.querySelector('#loading');

        let newNav = nav.cloneNode(true);
        main.after(newNav);

        const drawRows = (arr) => {
            let fragment = document.createDocumentFragment();

            for (const obj of arr) {
                let tr = document.createElement('tr');

                for (const key in obj) {
                    let td = document.createElement('td');
                    let text = obj[key] ? obj[key].trim()  : ' ';

                    if(key == 'ID_WORD'){
                        let a = document.createElement('a');
                        a.href = '/given-word/?id_word=' + obj[key];
                        a.innerHTML = "<i class='bi bi-box-arrow-up-left'></i>";

                        td.append(a);
                        tr.append(td);

                        continue;
                    }
                    td.textContent = text;
                    tr.append(td);
                }
                fragment.append(tr);
            }
            tbody.append(fragment);
            return true;
        }

        fetch('getData.php?page=<?php echo $page; ?>')
            .then((response) => response.json())
            .then((response) => drawRows(response))
            .then(()=>loading.remove())
            .then(()=>table.classList.remove("d-none"));

    </script>
</body>
</html>