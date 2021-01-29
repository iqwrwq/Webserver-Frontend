<?php

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

if ($messages['creation_success'] != null) : ?>
   <div class="messages <?php echo $messages['success'] ? "success" : "fail" ?>">
      <?php echo $messages['success'] ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>' ?>
      <?php echo $messages['creation_success']; ?>
   </div>
<?php endif ?>