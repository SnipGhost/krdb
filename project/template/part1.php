<html>
<head>
    <title>Главная</title>
    <link rel="stylesheet" href="<?=$PATH?>style/main.css">
    <link rel="stylesheet" href="<?=$PATH?>style/icons.css">
    <?php 
        if ($page == "reports") {
            printf('<link rel="stylesheet" href="%sstyle/chart.css">', $PATH);
            printf('<link rel="stylesheet" href="%sstyle/meter.css">', $PATH);
            printf('<script type="text/javascript" src="%sjs/jquery.js"></script>', $PATH);
            printf('<script type="text/javascript" src="%sjs/chart.js"></script>', $PATH);
        }
    ?>
	</head>
<body>

    <div class="header">
        <span class="logo_span">АИС Школа <?=$VERSION?></span>
        <div id="navbar">
            <div class="username"><?=$_SESSION['ФИО']?></div>
            
            <div class="avatar" style="background-image: url('<?=$PATH?><?=$_SESSION['Аватар']?>');">
                <div class="subpanel">
                    <div class="triangle"></div>
                    <div class="subpanel-box">
                        <form action="<?=$PATH?>" method="POST">
                            <a href="profile"><div class="profile_btn">
                                <div class="material-icons profile-icon">account_box</div><span>Профиль</span>
                            </div></a>
                            <button name="logout" class="profile_btn" type="submit">
                                <div class="material-icons profile-icon">exit_to_app</div><span>Выйти</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="menu">

        <br>

        <?php // Генерируем менюшку для конкретного типа пользователя
            include("content/menu.php");
        ?>

        <a href="https://vk.com/snipghost"><div class="menu_btn" style="bottom:0;position:absolute;">
            <div class="material-icons menu-light">copyright</div>
            <span>Кучеренко М.А.</span>
        </div></a>

    </div>

    <div class="wrapper">

		<!-- Content page start -->