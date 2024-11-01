<?php

class ThumbsUpGoogle extends ThumbsUpButton {

  protected $settings = array(
    'size' => 'medium',
    'width' => 200,
    'annotation' => 'bubble',      
  );

  protected $class = 'g-plusone';

  public function get_body_scripts() {
    return '';  
  }
  
  public function get_head_scripts($is_ssl=true) {
    return '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>';
  }
  
  
}
