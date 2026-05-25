<?php

    session_start();

    # Comprueba que el usuario está logeado
    if (!isset($_SESSION['email'])){
        echo ' 
            <script> 
                alert("Por favor debes iniciar sesión");
                window.location = "login.php";
            </script>
        ';
        session_destroy();
        die();
    }
?>