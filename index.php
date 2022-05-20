<!DOCTYPE html>
<html lang="en">
<head>
    <!-- =========== FAV ICON ========== -->
    <link rel="shortcut icon" type="image/png" href="icon.png">
    
    <!-- =========== META ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- =========== TITLE ========== -->
    <title>Online Compiler</title>

    <!-- =========== CSS ========== -->
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <!-- =========== REMIXI ICONS ========== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- =========== CODE MIRROR ========== -->
    <script src="codemirror-5.65.2/lib/codemirror.js"></script>
    <link rel="stylesheet" href="codemirror-5.65.2/lib/codemirror.css">
    <script src="codemirror-5.65.2/mode/MyLangauge/javaScript.js"></script>
</head>
<body>
    <!-- =========== CONTAINER ========== -->
    <div class="container">
    <!-- HEADER -->
        <header class="header">
            <!-- LEFT SECTION -->
            <div class="left-section">
                <h1 class="title">Online <span>Compiler</span></h1>
                <nav>
                    <ul>
                        <li class="list-item">
                            <a href="#">Editor</a>
                        </li>
                        <li class="list-item font-size-item" onclick="openFontSizeMenu()">
                            <a href="#">Font Size<i id="Myarrow" class="ri-arrow-down-s-line"></i></a>
                            <ul class="size-sub-menu" id="size-sub-menu">
                                <li id="font14" onclick="changeFontSize(14);"><a href="#">14 px</a></li>
                                <li id="font15" onclick="changeFontSize(15);"><a href="#">15 px</a></li>
                                <li id="font16" onclick="changeFontSize(16);"><a href="#">16 px</a></li>
                                <li id="font17" onclick="changeFontSize(17);"><a href="#">17 px</a></li>
                                <li id="font18" onclick="changeFontSize(18);"><a href="#">18 px</a></li>
                                <li id="font19" onclick="changeFontSize(19);"><a href="#">19 px</a></li>
                                <li id="font20" onclick="changeFontSize(20);"><a href="#">20 px</a></li>
                            </ul>
                        </li>
                        <li class="list-item font-item" onclick="openSubMenu()">
                            <a href="#">Font <i id="Myarrow2" class="ri-arrow-down-s-line arrow"></i></a>
                            <ul class="sub-menu" id="sub-menu">
                                <li><a href="#" onclick="changeFontFamily('Poppins, sans-serif');">Poppins</a></li>
                                <li><a href="#" onclick="changeFontFamily('Roboto, sans-serif');">Roboto</a></li>
                                <li><a href="#" onclick="changeFontFamily('Lato, sans-serif');">Lato</a></li>
                                <li><a href="#" onclick="changeFontFamily('Montserrat, sans-serif');">Montesrat</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <!-- RIGHT SECTION  -->
            <div class="right-section">
                <div class="buttons">
                    <a href="#">
                        <input id="browse" class="btn browse-btn" type="button" value="Browse">
                    </a>
                </div>
            </div>
        </header>

        <!-- =========== FORM ========== -->
        <form method="POST">
            <div class="code-editor" id="code-editor">
                <textarea name="codeEditor" id="editor"><?php if(isset($_REQUEST['codeEditor'])) {echo $_REQUEST['codeEditor']; } ?></textarea>
            </div>
            <!-- =========== BUTTONS ========== -->
            <div class="buttons">
                <input id="scanBtn" name="scanBtn" type="submit" value="Scan">
                <input id="parseBtn" name="parseBtn" type="submit" value="Parse">
            </div>
        </form>

        <!-- =========== OUTPUTS ========== -->
        <div class="outputs">
            <!-- =========== SCANNER ========== -->
            <div class="output-screen scanner">
                <?php include 'scanner.php'; ?>
            </div>
            
            <!-- =========== PASRER ========== -->
            <div class="output-screen parser">
                <?php include 'parser.php'; ?>
            </div>
        </div>

        <!-- =========== FOOTER ========== -->
        <div class="footer">
            <h4>Made With FCAI</h4>
        </div>
    </div>    

    <!-- JQUERY -->
    <script src="http://code.jquery.com/jquery-3.0.0.min.js"></script>

    <!-- MAIN JAVASCRIPT -->
    <script src="main.js"></script>
</body>
</html>