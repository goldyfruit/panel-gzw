<?php

class AppHelper extends Helper {
 
   function url($url = null, $full = false) {
        if(!isset($url['language']) && isset($this->params['language'])) {
          $url['language'] = $this->params['language'];
        }
 
        return parent::url($url, $full);
   }
 
}

?>