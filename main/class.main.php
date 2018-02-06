<?php

class main {

	var $objects = array(); // Objects casted
  var $inclusions = array(); // CSS and JS files to be included
  var $inclusionsRaw = array(); // CSS and JS files to be included
  public static $config; // Refer to config.inc.php

	public function __construct() {
		if(!self::$config){
      include(dirname(__FILE__). "/../config/config.inc.php");
      self::$config = $config;
    }
	}

	public function cast($class) {
	  if(!isset($this->objects["$class"])) {
      require_once(__DIR__ ."/../". $this->findClassFolder($class) ."/class.$class.php");
      $this->objects[$class] = new $class($this);
    }
    return $this->objects[$class];
  }

  private function findClassFolder($class) {
    if(substr($class, 0, 2) == 'ui') {
      return 'interface';
    } elseif (substr($class, 0, 2) == 'ax') {
      return 'ajax';
    } elseif (substr($class, 0, 2) == 'db') {
      return 'database';
    } elseif (substr($class, 0, 2) == 'co') {
      return 'model';
    } else {
      die('Unauthorized class' . $class);
    }
  }

  public function getAction($action) {

    list($class, $method) = explode(".", $action);
    $ax = $this->cast("ax" . $class);

    if(isset($ax->publicFunctions[$method]) && $this->allowOrigin($ax->publicFunctions[$method])) {
      call_user_func(array($ax, $method));
    } else {
      die("Unauthorized access");
    }
  }

  /**
   * Check for allowed origins of request for an action
   * @param $origin: true or "ajax" for ajax requests only, "*" for all
   * @return boolean
   */
  private function allowOrigin($origin) {

    if(!$origin) {
      return false;
    } elseif($origin == "*" OR $origin == true) {
      return true;
    }

  }

  private function header(){

    $htmlRet = "";

    foreach($this->inclusions as $inclusion){
      if($inclusion[0]=="css") {
        $htmlRet .= '<link rel="stylesheet" href="./interface/css/'. $inclusion[1] . '" type="text/css" media="all" />';
      }
    }

		foreach($this->inclusionsRaw as $inclusionRaw){
			$htmlRet .= $inclusionRaw;
		}

		foreach($this->inclusions as $inclusion){
			if($inclusion[0] == "js"){
				$htmlRet .= '<script src="./interface/js/'. $inclusion[1] . '"></script>';
			}
		}

		foreach($this->inclusionsRaw as $inclusion){
			if($inclusion[0] == "js"){
				$htmlRet .= '<script src="' . $inclusion[1] . '"></script>';
			}
		}

    $htmlRet .= '<title>' . $this::$config['TITLE'] . '</title>';
    $htmlRet .= '<meta name="viewport" content="' . $this::$config['VIEWPORT'] . '">';
    $htmlRet .= '<meta name="description" content="' . $this::$config['DESCRIPTION'] . '">';
    $htmlRet .= '<meta name="keywords" content="' . $this::$config['KEYWORDS'] . '">';
    $htmlRet .= '<link rel="shortcut icon" href="' . $this::$config['FAVICON'] . '">';
    $htmlRet .= '<meta name="generator" content="Mistral" />';

    return $htmlRet;

  }

  private function footer() {

    $htmlRet = "";

    foreach($this->inclusions as $inclusion){
      if($inclusion[0] == "js"){
        $htmlRet .= '<script src="./interface/js/'. $inclusion[1] . '"></script>';
      }
    }

    foreach($this->inclusionsRaw as $inclusion){
      if($inclusion[0] == "js"){
        $htmlRet .= '<script src="' . $inclusion[1] . '"></script>';
      }
    }

    return $htmlRet;

  }

  public function getPage($page){

    ob_start();

    if(!$this->isAjax()) include(dirname(__FILE__) ."/../interface/page/". $this::$config['HEADER_PAGE'] .".php");

    $filename = dirname(__FILE__) ."/../interface/page/$page.php";

    if(is_file($filename)){
      include($filename);
    } else {
      include(dirname(__FILE__) ."/../interface/page/". $this::$config['NOT_FOUND_PAGE'] .".php");
    }

    if(!$this->isAjax()) include(dirname(__FILE__) ."/../interface/page/". $this::$config['FOOTER_PAGE'] .".php");

    $htmlContent = ob_get_contents();
    ob_end_clean();

    $htmlRet = "";

    if(!$this->isAjax()) {
      $htmlRet = "<!DOCTYPE html><html><head>";
      $htmlRet .= $this->header();
      $htmlRet .= "</head><body>";
    }

    $htmlRet .= $htmlContent;

    $htmlRet .= $this->footer();

    if(!$this->isAjax()) {
      $htmlRet .= "</body></html>";
    }

    return $htmlRet;

  }

  /**
   * Allow to add a JS or CSS file.
   * @param string $filename css/js filename
   */
  private function add($filename) {
    $type = pathinfo($filename, PATHINFO_EXTENSION);
    $this->inclusions[$filename] = array($type, $filename);
  }

  public function addRaw($string) {
		array_push($this->inclusionsRaw, $string);
  }

  public function isAjax(){
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
  }

}
