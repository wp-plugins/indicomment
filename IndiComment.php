<?php
/*
Plugin Name: Indic Comment
Plugin URI: http://webkoof.com/wordpress-plugins/indicomment-comment-in-indian-language/
Description: Visitors  can write their comment in Indian languages. Vistor's write in Roman script and the plugin automatically converts it in corresponding Indian Script.
Version:  0.2
Author: Vikash Kumar
Author URI: http://webkoof.com
*/

/*  Copyright 2009  Vikash Kumar  (email : vikash.iitb@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



?>

<?php

function comment() {
$lang = get_option('indicLanguage');
if ($lang=="") $lang='hi';
?>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("elements", "1", {
            packages: "transliteration"
          });
	  var lang= decodeURIComponent("<?php echo rawurlencode($lang); ?>");
      function onLoad() {
        var options = {
          sourceLanguage: 'en',            
          destinationLanguage: lang,    
          shortcutKey: 'ctrl+g',   
          transliterationEnabled: true
        };
 
        var control =
            new google.elements.transliteration.TransliterationControl(options);

        var textArea=document.getElementsByTagName("textarea")[0].id;
        var ids = [textArea];
        control.makeTransliteratable(ids);
      }
      google.setOnLoadCallback(onLoad);
</script>
<?php
}

function menu() {
  add_submenu_page('edit-comments.php', 'Indic Comments', 'IndiComment', 8, __FILE__, 'options');
}

function options() {
if( $_POST['action' ] == 'update' ) {
 update_option( 'indicLanguage', $_POST['indicLanguage'] );
}
?>

<div class="wrap">
<h2>Indic Comment</h2>

<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">

 
<tr valign="top">
<th scope="row">Indic Language default</th>
<td><select name="indicLanguage" >
<option value="hi">Hindi (hi) </option> 
<option value="ta">Tamil (ta) </option> 
<option value="te">Telugu (te)</option> 
<option value="kn">kannad (kn)</option> 
<option value="ml">Malyalam (ml)</option> 
<option value="ar">Arabic (ar)</option> 
</select></td></tr>
<tr>
<td>Current Selection: </td><td><?php echo get_option('indicLanguage'); ?></td>
</tr>

</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="new_option_name,some_other_option,option_etc" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>


<?php
}

add_action('comment_form',  'comment');
add_action('admin_menu', 'menu');

?>
