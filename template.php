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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="http://example.com/favicon.png">
    <title><?php echo $host ?></title>
    <style>
        :root {
            --black: #000;
            --white: #fff;
            --pastel: #ffebcd;
            --pastel-secondary: #f5f5dc;
            --pastel-blur: #fffaf0;
            --greenish: #008080;
        }

        * {
            padding: 0;
            margin: 0;
            text-decoration: none;
            list-style: none;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }


        header {
            position: relative;
            display: block;
            padding: 0.2rem 0.4rem;
            justify-content: center;
            align-items: center;
            background: var(--greenish);
            font-weight: 600;
        }

        header a {
            color: var(--pastel-secondary);
            text-decoration: none;
        }

        header a:hover {
            color: var(--pastel);
        }

        .logo {
            display: inline-block;
        }

        .logo-txt {
            display: inline;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
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

        .display-dir-box {
            display: flex;
            align-items: center;
            vertical-align: middle;
            width: 100%;
            height: 2.5rem;
            padding: 0rem 1.2rem;
            color: var(--black);
        }

        .display-dir-box .fa-arrow-circle-right {
            padding-right: 1rem;
        }

        .display-dir-box:nth-of-type(odd) {
            background-color: var(--pastel-blur);
        }

        .display-dir-box:hover {
            color: var(--greenish);
            cursor: pointer;
        }

        #adding-box {
            cursor: unset;
        }

        .input-group {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .info-icon {
            position: absolute;
            margin-left: 90%;
        }

        .hide {
            display: none;
        }

        .info-list {
            height: auto;
            width: 300px;
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
            background-color: var(--greenish);
        }

        .btn {
            border: 0;
            font-size: 16px;
            background-color: unset;
            cursor: pointer;
        }

        .btn:hover {
            color: var(--greenish);
        }

        .plus-btn {
            padding: 10px 10px 10px 0px;
        }

        .plus-btn .fa-minus-circle {
            color: var(--greenish);
        }

        .plus-btn .fa-minus-circle:hover {
            color: var(--black);
        }

        .submit-btn {
            visibility: hidden;
            float: inline-end;
        }

        .submit-btn {
            visibility: hidden;
            float: inline-end;
            font-size: 30px;
        }

        .input-field {
            padding: 5px;
            background-color: var(--pastel-secondary);
            border: 2px white solid;
        }

        .cut-off {
            height: 2rem;
            width: 100%;
            background-color: var(--greenish);
        }
    </style>
</head>

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
            <div class="info-list hide">
                <ul>
                    <?php foreach (glob($dir . $SLASH . '*') as $file) :
                    ?>
                        <li>
                            <?php
                            if (is_dir($file)) {
                                echo '<i class="list-icon fas fa-folder-open"></i>';
                                echo '('.(count(scandir($file)) - 2).') ';
                            } else {
                                echo '<i class="list-icon fas fa-file"></i>';
                            }
                            echo $file;
                            ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>

        <?php endforeach ?>
        <div class="display-dir-box" id="adding-box">
            <a class="btn plus-btn" type="menu" id="add-btn"><i id="plu-min" class="fas fa-plus-circle"></i></a>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="hidden" id="add-input-field" class="input-field" placeholder="Directory Name" name="directory-name" required />
                    <button type="submit" id="submit-btn" class="btn fas fa-plus-square submit-btn"></a>
                </div>
            </form>
        </div>
    </div>

    <div class="cut-off"></div>

    <script type="text/javascript">
        var plusBtn = document.getElementById("add-btn");
        var icon = document.getElementById("plu-min");
        var inputfield = document.getElementById("add-input-field");
        var submitBtn = document.getElementById("submit-btn");
        var infoIcons = document.getElementsByClassName("info-icon");
        var infoLists = document.getElementsByClassName("info-list");

        plusBtn.addEventListener("click", () => {

            if (icon.classList.contains("fa-plus-circle")) {
                icon.classList.remove("fa-plus-circle");
                icon.classList.add("fa-minus-circle");
                inputfield.type = "text";
                submitBtn.style.visibility = "visible";
            } else if (icon.classList.contains("fa-minus-circle")) {
                icon.classList.remove("fa-minus-circle");
                icon.classList.add("fa-plus-circle");
                inputfield.type = "hidden";
                submitBtn.style.visibility = "hidden";
            }
        });

        for (let i = 0; i < infoIcons.length; i++) {
            infoIcons[i].addEventListener("mouseover", () => {
                infoLists[i].classList.remove("hide");
            });
            infoIcons[i].addEventListener("mouseout", () => {
                infoLists[i].classList.add("hide");
            });
        }
    </script>

    <small>v1.1</small>

    <script src="https://kit.fontawesome.com/ee02357a59.js"></script>
</body>

</html>