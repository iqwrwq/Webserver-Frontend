<?php
$SLASH = "/";
$dirs = array_filter(glob('*'), 'is_dir');
$host = $_SERVER['HTTP_HOST'];
$messages = [
   'creation_success' => '',
   'success' => false
];


function dir_is_empty($dirname)
{
   if (!is_dir($dirname)) return false;
   foreach (scandir($dirname) as $file) {
      if (!in_array($file, array('.', '..', '.svn', '.git'))) return false;
   }
   return true;
}
 ?>