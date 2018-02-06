<?php

// Classe utilisée pour fournir les outils nécessaires à DIGITALIS dans ses vérifications de status de membres et divers petits outils clés.

class cotools extends main {

  function __construct($controller){
    parent::__construct($controller);
  }

  /**
   * Force UTF8
   * return string
   */
  public function utf8_force($string){
    if (preg_match('%^(?:
          [\x09\x0A\x0D\x20-\x7E]            # ASCII
        | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
        | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
        | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
        | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
        | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
    )*$%xs', $string))
        return $string;
    else
        return iconv('CP1252', 'UTF-8', $string);
  }

}
