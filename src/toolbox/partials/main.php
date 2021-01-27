<?php
$SLASH = "/";
$dirs = array_filter(glob('*'), 'is_dir');
$host = $_SERVER['HTTP_HOST'];
$messages = [
   'creation_success' => '',
   'success' => false
];

if (isset($_POST['directory-name'])) {
   if (file_exists($_POST['directory-name'])) {
      $messages['creation_success'] = "creation of " . $_POST['directory-name'] . " failed beacuse it already exists !";
      $messages['success'] = false;
   } else {
      mkdir(getcwd() . $SLASH . $_POST['directory-name']);
      $messages['creation_success'] = $_POST['directory-name'] . " created successfully !";
      $messages['success'] = true;
   }
   unset($_POST);
}

function dir_is_empty($dirname)
{
   if (!is_dir($dirname)) return false;
   foreach (scandir($dirname) as $file) {
      if (!in_array($file, array('.', '..', '.svn', '.git'))) return false;
   }
   return true;
}

?>

<body>
   <header>
      <div class="heading">
         <div class="logo"><a href="/"><i class="fab fa-dev fa-3x"></i> </div>
         <h3 class="logo-txt">/<?php echo $host  ?></h3></a>
      </div>
   </header>
   <?php if ($messages['creation_success'] != null) : ?>
      <div class="messages <?php echo $messages['success'] ? "success" : "fail" ?>">
         <?php echo $messages['success'] ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>' ?>
         <?php echo $messages['creation_success']; ?>
      </div>
   <?php endif ?>

   <div class="display-dirs">
      <?php foreach ($dirs as $dir) : ?>
         <a href='<?php echo $dir ?>' class="display-dir-box">
            <i class='fas fa-arrow-circle-right'></i><?php echo $SLASH . $dir ?>
            <?php if (!dir_is_empty($dir)) : ?>
               <i class="info-icon fas fa-info-circle"></i>
            <?php endif ?>
         </a>
         <?php if (!dir_is_empty($dir)): ?>
            <div class="info-list hide">
               <ul>
                  <?php foreach (glob($dir . $SLASH . '*') as $file) :
                  ?>
                     <li>
                        <?php
                        if (is_dir($file)) {
                           echo '<i class="list-icon fas fa-folder-open"></i>';
                           echo '(' . (count(scandir($file)) - 2) . ') ';
                        } else {
                           echo '<i class="list-icon fas fa-file"></i>';
                        }
                        echo $file;
                        ?>
                     </li>
                  <?php endforeach ?>
               </ul>
            </div>
         <?php endif ?>
      <?php endforeach ?>

      <div class="display-dir-box" id="adding-box">
         <a class="btn btn-plus" type="menu" id="btn-add"><i id="plu-min" class="fas fa-plus-circle"></i></a>
         <form method="POST" action="">
            <div class="input-group">
               <input type="hidden" id="add-input-field" class="input-field" placeholder="Directory Name" name="directory-name" required />
               <button type="submit" id="btn-submit" class="btn fas fa-plus-square btn-submit"></a>
            </div>
         </form>
      </div>
   </div>