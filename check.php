<?php

require_once './arquivos_de_login/init.php';



if (!isLoggedIn())
{
    header('Location: http://localhost/tcc');
}
