<?php

abstract class ThumbsUpButton {

  /**
   * Metoda powinna zwracać kod do umieszczenia w nagłówku strony.
   * Kod załącza odpowiednie skrypty JS.
   *
   * @return string Kod HTML załączający skrypty JS
   */
  abstract public function get_head_scripts($is_ssl=false);

  /**
   * Metoda powinna zwracać skrypty do umieszczenia w body strony.
   *
   * @return string Kod HTML i JS
   */
  abstract public function get_body_scripts();
  
  /**
   * Standardowe zachowanie metody.
   * Niektóre przyciski (np. NK Fajne!) robią to w inny sposób i wymagają swojej implementacji.
   *
   * @return string Kod HTML wyświetlający przycisk
   */
  public function get_code($link, $title='', $image_url = '', $description = '') {
    $code = '<div class="' . $this->class . '" ';
    $this->settings['href'] = $link;
    foreach ($this->settings as $var => $val) {
      $code .= ' data-' . $var .'="' . $val . '"'; 
    }     
    $code .= '></div>';
    return $code;
  }
  
}
