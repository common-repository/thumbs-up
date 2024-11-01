<?php

class ThumbsUpFacebook extends ThumbsUpButton {

  protected $settings = array(
    'color' => 'dark',
    'layout' => 'button_count',
    'send' => 'false',
    'width' => 200,
    'how-faces' => 'false', 
    'font' => 'arial',  
  );
  protected $class = 'fb-like';

  /**
   * Zwraca skrypty do umieszczenia w body strony.
   *
   * @return string Kod HTML i JS
   */
  public function get_body_scripts() {
    return '<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1&appId=304202102961342";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, \'script\', \'facebook-jssdk\'));</script>';
  
  }

  /**
   * Zwraca kod do umieszczenia w nagłówku strony.
   * Kod załącza odpowiednie skrypty JS.
   *
   * @return string Kod HTML załączający skrypty JS
   */
  public function get_head_scripts($is_ssl=false) {
    return null;
  }

}
