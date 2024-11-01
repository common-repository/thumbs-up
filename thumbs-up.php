<?php
/*
Plugin Name: Thumbs Up
Plugin URI: http://wordpress.org/extend/plugins/top-share-pl
Description: Simply adds top Polish sharing button
Version: 1.0.0
Author: Marek Ziółkowski
Author URI: http://blog.powsinoga.pl
License: GPL2

Copyright 2012  Marek Ziółkowski

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class ThumbsUp {

  private $buttons;
  private $settings = array(
    'show-on-home' => false,
    'show-on-category' => false,
    'show-on-tag' => false,
    'show-on-page' => false,
    'show-manual' => true,
  );

  public function __construct() {
    $this->classes = array(
      'ThumbsUpNk',
      'ThumbsUpGoogle',
      'ThumbsUpFacebook',
    );
    
    $this->buttons = array();
    foreach ($this->classes as $class) {
      if (class_exists($class)) {
        $this->buttons[] = new $class;
      }
    }
  }
  
  /**
   * Wypisuje skrypty w <head></head> strony.
   */    
  public function print_head_scripts() {
    
    foreach ($this->buttons as $button) {
      echo $button->get_head_scripts();
    }
  }

  /**
   * Zwraca kod JavaScript, który należy wstawić w treści strony.
   *
   * @return string Kod HTML i/lub JavaScript
   */
  public function get_body_scripts() {
    $body = '';    
    foreach ($this->buttons as $button) {
      $body .= $button->get_body_scripts();
    }
    return $body;
  }  

  /**
   * Zwraca kod wszystkich przycisków.
   *
   * @return strung Kod HTML i/lub JavaScript
   */
  public function get_button_codes($link, $title='', $image_url='', $description='') {
    $codes = '<div class="thumbsup_buttons">';    
    foreach ($this->buttons as $button) {
      $codes .= $button->get_code($link, $title, $image_url, $description);
    }
    $codes .= '</div><div style="clear: both;"></div>';
    return $codes;        
  }
     
  /**
   * Wzbogaca content o przycisk Fajne!. 
   * W zależności od ustawień dodaje go przed lub po treści.
   *
   * @param string $content Oryginalna treść.
   * @return string Treść wzbogacona.
   */
  public function add_buttons($content) {
    if (!in_the_loop()) {
      return $content;
    }
    
    if ($this->settings['show-manual'] == true
     || is_home() && $this->settings['show-on-home'] != true
     || is_category() && $this->settings['show-on-category'] != true
     || is_tag() && $this->settings['show-on-tag'] != true
     || is_page() && $this->settings['show-on-page'] != true) {
      return $content;
    }
 
    if (!is_admin()) {
      $link = get_permalink();
    } else {
      $link = site_url();
    }
    
    if (has_post_thumbnail()) {
      // jeśli post ma miniaturę, wydobywamy jej URL
      $attachment_id = get_post_thumbnail_id();
      $attachement_attrs = wp_get_attachment_image_src($attachment_id);    
      $image_url = $attachement_attrs[0];  
    } else {
      $image_url = '';
    }
            
    $title = get_the_title();            
    $description = strip_tags($content);
    $cp = 'utf8';
    if (mb_strlen($description, $cp) > 250) {
      $description = mb_substr($description,0,247, $cp) . '...';
    }
            
    $buttons = $this->get_body_scripts() . $this->get_button_codes($link, $title, $image_url, $description);
    return $buttons . $content;   
  } 

}

wp_enqueue_style('my-style', WP_PLUGIN_URL . '/thumbs-up/styles.css');

require_once( dirname( __FILE__ ) . '/thumbs-up-button.php' );
require_once( dirname( __FILE__ ) . '/thumbs-up-nk.php' );
require_once( dirname( __FILE__ ) . '/thumbs-up-facebook.php' );
require_once( dirname( __FILE__ ) . '/thumbs-up-google.php' );

$tspl = new ThumbsUp();
add_action( 'wp_print_scripts', array($tspl, 'print_head_scripts')); 
add_action( 'the_content', array($tspl, 'add_buttons'));
