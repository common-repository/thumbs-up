<?php
/**
 * Klasa dodaje przycisk NK Fajne! portalu http://nk.pl
 */
class ThumbsUpNk extends ThumbsUpButton {

  private $settings = array(
    'color' => 1,
    'layout' => 2,
    'width' => 135,
  );
  protected $class = 'nk-fajne';

  /**
   * Ten przycisk nie ma dodatkowych skryptów do umieszczenia w treści strony.
   *
   * @return string
   */
  public function get_body_scripts() {
    return '';  
  }
  
  /**
   * Zwraca kod do umieszczenia w nagłówku strony.
   * Kod załącza odpowiednie skrypty JS.
   *
   * @return string Kod HTML załączający skrypty JS
   */
  public function get_head_scripts($is_ssl=false) {
    if ($is_ssl) {
      $script_url = 'https://nk.pl/script/nk_widgets/nk_widget_fajne_embed'; 
    } else {
      $script_url = 'http://0.s-nk.pl/script/nk_widgets/nk_widget_fajne_embed';    
    }
    
    return '<script type="text/javascript" src="'.$script_url.'"></script>'; 
  }
 
  /**
   * Zwraca kod do wstawienia w miejscu wyświetlania przycisku.
   *
   * @return string Kod HTML + JavaScript wyświetlający przycisk.
   */ 
  public function get_code($link, $title='', $image_url = '', $description = '') {               
    
    $code = '<div class="' . $this->class . '" style="width: '.$this->settings['width'].'px;"><script>
    new nk_fajne({
      url: "'.$link.'",
      type: '.$this->settings['layout'].',
      color: '.$this->settings['color'].',
      title: '.json_encode($title).',
      image: "'.$image_url.'",
      description: '.json_encode($description).'
    });
    </script></div>';
    
    return $code;
  }


} 
