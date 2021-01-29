<div class="display-dirs">
   <?php foreach ($dirs as $dir) : ?>
      <a href='<?php echo $dir ?>' class="display-dir-box">
         <i class='fas fa-arrow-circle-right'></i><?php echo $SLASH . $dir ?>
         <?php if (!dir_is_empty($dir)) : ?>
            <i class="info-icon fas fa-info-circle"></i>
         <?php endif ?>
      </a>
      <?php if (!dir_is_empty($dir)) : ?>
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