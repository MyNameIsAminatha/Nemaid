<?php
  require_once(__DIR__ . "/../class/class.dbmysql.php");
  $db = new dbmysql;
?>

<html>
  <head>
    <link rel="stylesheet" href="./css/materialize.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/nemaid.css">
  </head>
  <body>
  <!-- For the logo -->
      <nav>
        <div class="nav-wrapper">
          <a href="index.php" class="brand-logo center">NEMAID</a>
          <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li><a href="#">Genus</a></li>
            <li><a href="#">Parameters</a></li>
            <li><a href="sample.php">Sample</a></li>
            <li><a href="#">Results</a></li>
            <li><a href="#">Exit</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <ul class="right">
            <li> <a href="form.php"><i class="material-icons orange-text" style="font-size:34px;">account_circle</i></a></li>
          </ul>

        </div>
      </nav>
      <main class="grey lighten-4">
