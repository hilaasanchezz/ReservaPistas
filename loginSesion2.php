<?php

    session_start();

    # Comprueba que el usuario está logeado
    if (isset($_SESSION['email'])){
        echo ' 
            <script> 
                window.location = "index.php";
            </script>
        ';
    }
?>