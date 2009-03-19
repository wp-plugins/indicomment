<?php
/*
Plugin Name: Indic Comment
Plugin URI: http://webkoof.com/wordpress-plugins/indicomment-comment-in-indian-language/
Description: Visitors  can write their comment in Indian languages. Vistor's write in Roman script and the plugin automatically converts it in corresponding Indian Script.
Version:  0.1
Author: Vikash Kumar
Author URI: http://webkoof.com
*/

function comment() {
?>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("elements", "1", {
            packages: "transliteration"
          });
 
      function onLoad() {
        var options = {
          sourceLanguage: 'en',            
          destinationLanguage: ['hi'],    
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

add_action('comment_form',  'comment');


?>
