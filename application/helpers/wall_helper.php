<?php
	if(!defined('BASEPATH'))
		exit('No direct script access allowed');

    function clickable_link($text = '')
    {	
      $text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $text);
      $ret = ' ' . $text;
      $ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"no_follow\">\\2</a>", $ret);
      $ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
      $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
      $ret = substr($ret, 1);
      return $ret;
    }

    function cleanInput($input) {

      $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU'    // Strip style tags properly
        //'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
      );

      $output = preg_replace($search, '', $input);
      return $output;
    }

    function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = mysql_real_escape_string($input);
    }
    return $output;


}

?>
