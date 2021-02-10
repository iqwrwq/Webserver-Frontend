<?php
// HELPERS
$SLASH = "/";
$dirs = array_filter(glob('*'), 'is_dir');
$host = $_SERVER['HTTP_HOST'];
$messages = [
   'creation_success' => '',
   'success' => false
];
$_VERSION = 'v1.12 drakula';
function dir_is_empty($dirname)
{
   if (!is_dir($dirname)) return false;
   foreach (scandir($dirname) as $file) {
      if (!in_array($file, array('.', '..', '.svn', '.git'))) return false;
   }
   return true;
}
// -*-*-*-

// NOTIFICATIONS

?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="http://example.com/favicon.png">
   <script src="https://kit.fontawesome.com/ee02357a59.js"></script>
   <title><?php echo $host ?></title>

   <!-- CSS -->
   <style>
      .heading {
         display: block;
         -webkit-box-orient: horizontal;
         -webkit-box-direction: normal;
         -ms-flex-direction: row;
         flex-direction: row;
         background: #008080;
      }

      .heading .logo-container {
         position: relative;
         display: inline-block;
         padding: 0.2rem 0.4rem;
         -webkit-box-pack: center;
         -ms-flex-pack: center;
         justify-content: center;
         -webkit-box-align: center;
         -ms-flex-align: center;
         align-items: center;
         font-weight: 600;
      }

      .heading .logo-container .logo {
         display: inline-block;
      }

      .heading .logo-container .logo-txt {
         display: inline;
         font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
      }

      .heading .logo-container a {
         color: #f5f5dc;
         text-decoration: none;
      }

      .heading .logo-container a:hover {
         color: #ffebcd;
         cursor: pointer;
      }

      .heading .options {
         display: inline;
         width: 20%;
         color: #ffebcd;
         float: right;
         margin-top: 1.0rem;
      }

      .heading .options .btn-darkmode:hover {
         color: #ffebcd;
         cursor: pointer;
      }

      .heading.darkmode {
         background-color: #013939;
      }

      .heading.darkmode .logo-container a {
         color: #a3ddc0;
      }

      .heading.darkmode .logo-container a:hover {
         color: #efc37b;
      }

      .heading.darkmode .btn-darkmode {
         color: #a3ddc0;
      }

      .btn {
         border: 0;
         font-size: 16px;
         background-color: unset;
         cursor: pointer;
      }

      .btn :hover {
         color: #008080;
      }

      .btn-plus {
         padding: 10px 10px 10px 0px;
      }

      .btn-plus .fa-minus-circle {
         color: #008080;
      }

      .btn-plus .fa-minus-circle:hover {
         color: #000;
      }

      .btn-submit {
         visibility: hidden;
         float: inline-end;
         font-size: 30px;
      }

      .btn-darkmode {
         font-size: 20px;
      }

      .success {
         color: #4F8A10;
         background-color: #DFF2BF;
      }

      .fail {
         color: #D8000C;
         background-color: #FFD2D2;
      }

      .messages {
         padding: 10px;
         height: 25px;
         width: 100%;
      }

      * {
         padding: 0;
         margin: 0;
         text-decoration: none;
         list-style: none;
         font-family: Verdana, Geneva, Tahoma, sans-serif;
      }

      body.darkmode {
         background-color: #282828;
         color: white;
      }

      .display-dir-box {
         display: -webkit-box;
         display: -ms-flexbox;
         display: flex;
         -webkit-box-align: center;
         -ms-flex-align: center;
         align-items: center;
         vertical-align: middle;
         height: 2.5rem;
         padding: 0rem 1.2rem;
         color: #000;
      }

      .display-dir-box .fa-arrow-circle-right {
         padding-right: 1rem;
      }

      .display-dir-box:nth-of-type(odd) {
         background-color: #fffaf0;
      }

      .display-dir-box:hover {
         color: #008080;
         cursor: pointer;
      }

      .display-dir-box .input-field {
         padding: 5px;
         background-color: #f5f5dc;
         border: 2px #fff solid;
      }

      .display-dir-box.darkmode {
         color: #a3ddc0;
         font-weight: 600;
      }

      .display-dir-box.darkmode:nth-of-type(odd) {
         background-color: #303030;
      }

      .display-dir-box.darkmode:hover {
         color: #efc37b;
      }

      .display-dir-box.darkmode .input-group .input-field {
         background-color: #a3ddc0;
      }

      .display-dir-box.darkmode .btn .fa-plus-circle {
         color: #a3ddc0;
      }

      .display-dir-box.darkmode .btn .fa-plus-circle:hover {
         color: #efc37b;
      }

      .display-dir-box.darkmode .btn .fa-minus-circle {
         color: #efc37b;
      }

      .display-dir-box.darkmode .btn .fa-minus-circle:hover {
         color: #a3ddc0;
      }

      .display-dir-box.darkmode .btn-submit {
         color: #efc37b;
      }

      #adding-box {
         cursor: unset;
      }

      .input-group {
         display: -webkit-box;
         display: -ms-flexbox;
         display: flex;
         -webkit-box-pack: center;
         -ms-flex-pack: center;
         justify-content: center;
         -webkit-box-align: center;
         -ms-flex-align: center;
         align-items: center;
      }

      .info-icon {
         position: absolute;
         margin-left: 90%;
      }

      .hide {
         display: none;
      }

      .hide::after {
         display: none;
      }

      .info-list {
         height: auto;
         width: 400px;
         float: right;
         z-index: 1;
      }

      .info-list ul li {
         padding: 8px 0;
      }

      .info-list ul li .list-icon {
         margin: 0 20px 0 5px;
         font-size: 20px;
      }

      .info-list ul li:nth-child(odd) {
         background-color: #008080;
      }

      .cut-off {
         height: 2rem;
         width: 100%;
         background-color: #008080;
      }

      .cut-off.darkmode {
         background-color: #013939;
      }

      /*# sourceMappingURL=main.css.map */
   </style>

   <!-- CSS -->
</head>

<body>
   <!-- NAV -->
   <div id="heading" class="heading">

      <div class="logo-container">
         <a class="logo fab fa-dev fa-3x"></a>
         <a href="/" class="logo-txt"><?php echo $SLASH . $host  ?>
         </a>
      </div>
      <div class="options">
         <i id="darkmodeToggleOn" class="fas fa-toggle-on btn-darkmode hide"></i>
         <i id="darkmodeToggleOff" class="fas fa-toggle-off btn-darkmode"></i>
      </div>

   </div>
   <!-- NAV -->

   <!-- NOTIFICATIONS -->
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
   <!-- NOTIFICATIONS -->


   <!-- DISPLAYDIRECTORY -->
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
   <!-- /DISPLAYDIRECTORY -->

   <!-- FOOTER -->
   <div id="cut-off" class="cut-off"></div>
   <!-- /FOOTER -->

   <!-- SCRIPTS -->

   <!-- DARKMODE -->
   <script>
      class DarkmodeToggle {

         darkmodeToggleButtonOn;
         darkmodeToggleButtonOff;

         HTMLHeader;
         HTMLBody;
         displayDirBoxes;
         HTMLCutOff;

         constructor() {

            this.darkmodeToggleButtonOn = document.getElementById("darkmodeToggleOn");
            this.darkmodeToggleButtonOff = document.getElementById("darkmodeToggleOff");

            this.HTMLHeader = document.getElementById("heading");
            this.HTMLBody = document.body;
            this.displayDirBoxes = document.getElementsByClassName("display-dir-box");
            this.HTMLCutOff = document.getElementById("cut-off");

            this.togglers();
         }


         togglers() {
            this.darkmodeToggleButtonOn.addEventListener("click", () => {
               this.deactivateDarkmode();
            });
            this.darkmodeToggleButtonOff.addEventListener("click", () => {
               this.activateDarkmode();
            });
         }

         activateDarkmode() {
            this.darkmodeToggleButtonOn.classList.remove("hide");
            this.darkmodeToggleButtonOff.classList.add("hide");
            this.displayDarkmode();
            this.setDarkModeCookie(true);
         }

         deactivateDarkmode() {
            this.darkmodeToggleButtonOn.classList.add("hide");
            this.darkmodeToggleButtonOff.classList.remove("hide");
            this.displayLightmode();
            this.setDarkModeCookie(false);
         }

         displayDarkmode() {
            this.HTMLHeader.classList.add("darkmode");
            this.HTMLBody.classList.add("darkmode");
            for (let i = 0; i < this.displayDirBoxes.length; i++) {
               this.displayDirBoxes[i].classList.add("darkmode");
            }
            this.HTMLCutOff.classList.add("darkmode");
         }

         displayLightmode() {
            this.HTMLHeader.classList.remove("darkmode");
            this.HTMLBody.classList.remove("darkmode");
            for (let i = 0; i < this.displayDirBoxes.length; i++) {
               this.displayDirBoxes[i].classList.remove("darkmode");
            }
            this.HTMLCutOff.classList.remove("darkmode");
         }

      }

      const darkmodeToggle = new DarkmodeToggle();
   </script>

   <!-- INFOBUTTON -->
   <script>
      const HOVER_OVER = "mouseover";
      const HOVER_OUT = "mouseout";

      var infoIcons = document.getElementsByClassName("info-icon");
      var infoLists = document.getElementsByClassName("info-list");

      addListenerToInfoBtn();


      function addListenerToInfoBtn() {
         for (let i = 0; i < infoIcons.length; i++) {
            currentInfoIcon = infoIcons[i];
            currentInfoList = infoLists[i];

            currentInfoIcon.addEventListener(HOVER_OVER, () => {
               removeHideClassToInfoPanel(currentInfoList);
            });

            currentInfoIcon.addEventListener(HOVER_OUT, () => {
               addHideClassToInfoPanel(currentInfoList);
            });
         }
      }

      function removeHideClassToInfoPanel(currentInfoList) {
         currentInfoList.classList.remove("hide");
      }

      function addHideClassToInfoPanel(currentInfoList) {
         currentInfoList.classList.add("hide");
      }
   </script>

   <!-- INPUTFIELD -->
   <script>
      var plusBtn = document.getElementById("btn-add");
      var icon = document.getElementById("plu-min");
      var inputfield = document.getElementById("add-input-field");
      var submitBtn = document.getElementById("btn-submit");


      plusBtn.addEventListener("click", () => {

         if (checkIfCurrentIconPlus()) {
            changeIconToMinus();
            toggleInputField(true);

         } else if (checkIfCurrentIconMinus()) {
            changeIconToPlus();
            toggleInputField(false);
         }
      });

      function checkIfCurrentIconPlus() {
         return icon.classList.contains("fa-plus-circle");
      }

      function changeIconToMinus() {
         icon.classList.remove("fa-plus-circle");
         icon.classList.add("fa-minus-circle");
      }

      function toggleInputField(toggle) {
         if (toggle) {
            inputfield.type = "text";
            submitBtn.style.visibility = "visible";
         } else {
            inputfield.type = "hidden";
            submitBtn.style.visibility = "hidden";
         }
      }

      function checkIfCurrentIconMinus() {
         return icon.classList.contains("fa-minus-circle");
      }

      function changeIconToPlus() {
         icon.classList.remove("fa-minus-circle");
         icon.classList.add("fa-plus-circle");
      }
   </script>

   <!-- /SCRIPTS -->

   <!-- VERSION -->
   <small><?php echo $_VERSION ?></small>
   <!-- /VERSION -->


</body>

</html>