<?php
/*
Plugin Name: WP-OpenDyslexic
Plugin URI: https://frankleonard.nl/wp-opendyslexic/
Description: Allows registered users to enable the OpenDyslexic font in their profile.
Version: 1.0
Author: Frank Gerritse
Author URI: https://frankleonard.nl/
License: GPL2
Text Domain: opendyslexic
Domain Path: /languages/

*/
/*  Copyright 2015  Frank Gerritse (email : frank@frankleonard.nl)

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

/*
Changelog:
20150123 - first version
*/
?>
<?php
/*
/ Function to add the i18n
*/
function load_opendyslexic_textdomain() {
  load_plugin_textdomain( 'opendyslexic', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
 
/*
/ Adding all the Wordpress hooks
*/
add_action('plugins_loaded', 'load_opendyslexic_textdomain' );
add_action('profile_personal_options', 'add_opendyslexic_option_to_profile');
add_action('edit_user_profile_update', 'update_profile_use_opendyslexic');
add_action('personal_options_update', 'update_profile_use_opendyslexic');
add_action('wp_head','add_opendyslexic_css');
add_action('admin_head', 'add_opendyslexic_css_admin');

/*
/ Function to add the WP-OpenDyslexic choice setting to the user profile page in the WP admin
*/
function add_opendyslexic_option_to_profile( $user ) {
    ?>
        <table class="form-table">
                <tr>
                        <th><label><?php _e('Opendyslexic font', 'opendyslexic');?></label></th>
                        <td><p><?php _e('You can use the OpenDyslexic font on the website or on both the website and the admin. The OpenDyslexic font is designed to help people with dyslexia with their reading. ', 'opendyslexic');?></p></td>
                </tr>
        <tr>
        <td></td>
        <td>
 <select name="use_opendyslexic" id="use_opendyslexic" >
                        <option value="no" <?php selected( 'no', get_user_meta( $user->ID, 'use_opendyslexic', true ) ); ?>><?php _e('Don\'t use the OpenDyslexic font', 'opendyslexic');?></option>
                        <option value="yes_everywhere" <?php selected( 'yes_everywhere', get_user_meta( $user->ID, 'use_opendyslexic', true ) ); ?>><?php _e('Use both on the website and in the admin', 'opendyslexic');?></option>
                        <option value="yes_websiteonly" <?php selected( 'yes_websiteonly', get_user_meta( $user->ID, 'use_opendyslexic', true ) ); ?>><?php _e('Only use on the website', 'opendyslexic');?></option>
                        <option value="yes_adminonly" <?php selected( 'yes_adminonly', get_user_meta( $user->ID, 'use_opendyslexic', true ) ); ?>><?php _e('Only use within the admin', 'opendyslexic');?></option>
                    </select>
	</td>
        </tr>
        </table>
    <?php
}

/*
/ Function to save the WP-OpenDyslexic setting to the database
*/

function update_profile_use_opendyslexic($user_id) {
     if ( current_user_can('edit_user',$user_id) )
         update_usermeta($user_id, 'use_opendyslexic', $_POST['use_opendyslexic']);
}

/*
/ Function to add the OpenDyslexic CSS to the website if user has this enabled
*/
function add_opendyslexic_css()
{
$user_ID = get_current_user_id(); 
$use_opendyslexic = get_user_meta($user_ID, 'use_opendyslexic', true );
if ($use_opendyslexic=="yes_everywhere" || $use_opendyslexic=="yes_websiteonly"){
?>
<style type="text/css">
@font-face { font-family: open-dyslexic; src: url('<?= plugin_dir_url( __FILE__ );?>OpenDyslexic-Regular.ttf'); }
* { font-family: open-dyslexic !important }
</style>
<?php
}
}

/*
/ Function to add the OpenDyslexic CSS to the admin if user has this enabled
*/
function add_opendyslexic_css_admin()
{
$user_ID = get_current_user_id(); 
$use_opendyslexic = get_user_meta($user_ID, 'use_opendyslexic', true);
if ($use_opendyslexic=="yes_everywhere" || $use_opendyslexic=="yes_adminonly"){
?>
<style type="text/css">
@font-face { font-family: open-dyslexic; src: url('<?= plugin_dir_url( __FILE__ );?>OpenDyslexic-Regular.ttf'); }
* { font-family: open-dyslexic !important }
</style>
<?php
}
}
?>
