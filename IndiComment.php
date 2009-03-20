<?php
/*
Plugin Name: Indic Comment
Plugin URI: http://webkoof.com/wordpress-plugins/indicomment-comment-in-indian-language/
Description: Visitors  can write their comment in Indian languages. Vistor's write in Roman script and the plugin automatically converts it in corresponding Indian Script.
Version:  0.3
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

function indiComment_comment() {
$lang='hi';
$enabled=0;
$lang = get_option('indicLanguage');
$enabled = get_option('indicEnabled');

?>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("elements", "1", {
            packages: "transliteration"
          });
	  var lang= decodeURIComponent("<?php echo rawurlencode($lang); ?>");
	  var e= <?php echo $enabled; ?>;
      function onLoad() {
        var options = {
          sourceLanguage: 'en',            
          destinationLanguage: lang,    
          shortcutKey: 'ctrl+g',   
          transliterationEnabled: e
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

function indiComment_menu() {
  add_submenu_page('edit-comments.php', 'Indic Comments', 'IndiComment', 8, __FILE__, 'indiComment_options');
}

function indiComment_options() {
if( $_POST['action' ] == 'update' ) {
 update_option( 'indicLanguage', $_POST['indicLanguage'] );
 update_option( 'indicEnabled', $_POST['indicEnabled'] );
}
$lang = get_option('indicLanguage');
$enabled = get_option('indicEnabled');
?>

<div class="wrap">
<h2>Indic Comment</h2>

<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">

<tr valign="top">
<td width="200px"><b>Indic Language default</b></td>
<td><select name="indicLanguage" >
<option value="hi" <?php if ($lang=="hi") echo "selected";?>>Hindi (hi) </option> 
<option value="ta" <?php if ($lang=="ta") echo "selected";?>>Tamil (ta) </option> 
<option value="te" <?php if ($lang=="te") echo "selected";?>>Telugu (te)</option> 
<option value="kn" <?php if ($lang=="kn") echo "selected";?>>kannad (kn)</option> 
<option value="ml" <?php if ($lang=="ml") echo "selected";?>>Malyalam (ml)</option> 
<option value="ar" <?php if ($lang=="ar") echo "selected";?>>Arabic (ar)</option> 
</select></td>
<td>
Select the script in which you want the transliteration to work.
</td></tr>

<tr valign="top">
<td><b>Enabled by default</b></td>
<td><select name="indicEnabled" >
<option value="1" <?php if ($enabled==1) echo "selected";?>>True</option> 
<option value="0" <?php if ($enabled==0) echo "selected";?>>False</option> 
</select></td>
 <td> 
If this is 'true' then comment form will use indian language on page load and you need to press ctrl+g to go back to english. If this is 'false' then comment form will use english and you need to press ctrl+g to write in Indic language.
</td></tr>
</table>

<input type="hidden" name="action" value="update" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>


<?php
}

add_action('comment_form',  'indiComment_comment');
add_action('admin_menu', 'indiComment_menu');

?>
