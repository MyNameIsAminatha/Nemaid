<?php

require_once("main/class.main.php");

session_start();
$main = new main();

if(isset($_REQUEST['logout'])) $main->cast("coauth")->logout();

if(isset($_REQUEST['action'])) {
  echo $main->getAction($_REQUEST['action']);
} elseif(isset($_REQUEST['page'])) {
  echo $main->getPage((isset($_REQUEST['page'])?$_REQUEST['page']:commons::$config['DEFAULT_PAGE']));
} else {
	header('Location: index.php?page=' . $main::$config["DEFAULT_PAGE"]);
}
