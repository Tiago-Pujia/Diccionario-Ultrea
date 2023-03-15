<?php
$getData = fn($name,$default = '') => isset($_POST[$name]) ? $_POST[$name] : null;

$postUser = $getData('user');
$postPassword = $getData('password');

$user = '';
$password = '';

$errorUser = null;
$errorPassword = null;

if(isset($_POST['user'])){
    if($postUser != $user){
        $errorUser = 'Error de Usuario';
    }
}

if(isset($_POST['password'])){
    if($postPassword != $password){
        $errorPassword = 'Error de Contraseña';
    }
}

if(!$errorUser && !$errorPassword && isset($_POST['user']) && isset($_POST['user'])){
    setcookie('session','ak92nd9','/administrarion');
} else {

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion - Diccionario</title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/independences/bootstrap/bootstrap.min.css"/>
        <script src="/independences/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="/independences/bootstrap-icons/font/bootstrap-icons.css"/>
    
    <!-- Styles -->
    <style>
        form{
            background-color: #101010;
        }

        /* sm */
        @media (min-width: 576px) {
            form{
                max-width: 50vw !important;
            }
        }

        /* medium */
        @media (min-width: 768px) {  
            form{
                max-width: 40vw !important;
            }
        }

        /* large */
        @media (min-width: 992px) {
            form{
                max-width: 35vw !important;
            }
        }

        /* xl */
        @media (min-width: 1200px) {
            form{
                max-width: 25vw !important;
            }
        }
    </style>
</head>
<body class="bg-dark">
<!-- <body class=""> -->
    <!-- <nav class="p-4 mb-3">
        <a class="btn btn-sm btn-outline-info" href="/">Home</a>
    </nav> -->
    <main class="container">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <form action="" method="POST" class="rounded" style="background-color: ;">
                <h1 class="text-white my-5 pb-1">Inicie Sesión</h1>

                <div>
                    <div class="input-group">
                        <label class="input-group-text bg-secondary border-0 text-white" for="inputUser"><i class="bi bi-person-fill"></i></label>
                        <input 
                            type="text" 
                            class="form-control border-2 <?php if($errorUser){echo'is-invalid';}elseif($postUser == $user){echo 'is-valid';}?>"
                            value="<?php echo $postUser; ?>"
                            id="user"
                            name="user" 
                            placeholder="Usuario">
                    </div>
                    <p class="text-danger <?php if(!$errorUser)echo 'd-none'; ?>">Usuario Incorrecto</p>
                </div>

                <div>
                    <div class="input-group mt-3">
                        <label class="input-group-text bg-secondary text-white border-0" for="inputPassword"><i class="bi bi-key-fill" style="transform: rotate(45deg);"></i></label>
                        <input 
                            type="password" 
                            class="form-control border-2 <?php if($errorPassword){echo'is-invalid';}elseif($postPassword == $password){echo 'is-valid';}?>" 
                            value="<?php echo $postPassword; ?>"
                            name="password" 
                            id="inputPassword" 
                            placeholder="Contraseña">
                    </div>
                    <p class="text-danger <?php if(!$errorPassword)echo 'd-none'; ?>">Contraseña Incorrecta</p>
                </div>

                <input class="btn btn-secondary mt-3 w-100" type="submit" value="Acceder">
                <hr class="text-secondary">
                <p><a class="text-decoration-none text-primary-emphasis" href="/">Volver al Inicio</a></p>
            </form>
        </div>
    </main>
</body>
</html>
<?php 
exit(); 
}
?>