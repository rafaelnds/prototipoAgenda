<?php
   session_start();
   unset($_SESSION["login"]);
   unset($_SESSION["senha"]);
   
  
   header('Refresh: 1; URL = login.php');
?>