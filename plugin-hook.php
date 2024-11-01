<?php
/*
Plugin Name: TCBD Lost Password Remover
Plugin URI: http://demos.tcoderbd.com/wordpress_plugin/tcbd-lost-password-remove
Description: This plugin will enable to remove the lost password link form your Wordpress theme in login page.
Author: Md Touhidul Sadeek
Version: 2.0
Author URI: http://tcoderbd.com
*/

/*  Copyright 2015 tCoderBD (email: info@tcoderbd.com)

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

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

function disable_reset_lost_password() 
 {
   return false;
 }
 add_filter( 'allow_password_reset', 'disable_reset_lost_password');



class Password_Reset_Removed
{

  function __construct() 
  {
    add_filter( 'show_password_fields', array( $this, 'disable' ) );
    add_filter( 'allow_password_reset', array( $this, 'disable' ) );
    add_filter( 'gettext',              array( $this, 'remove' ) );
  }

  function disable() 
  {
    if ( is_admin() ) {
      $userdata = wp_get_current_user();
      $user = new WP_User($userdata->ID);
      if ( !empty( $user->roles ) && is_array( $user->roles ) && $user->roles[0] == 'administrator' )
        return true;
    }
    return false;
  }

  function remove($text) 
  {
    return str_replace( array('Lost your password?', 'Lost your password'), '', trim($text, '?') ); 
  }
}

$pass_reset_removed = new Password_Reset_Removed();


?>