<?php
  require_once "session.php";

  if($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST["cikis"]))
    return;
  
  session_destroy();
  header("Location: anasayfa.php");
?>