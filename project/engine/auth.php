<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?=$PATH?>style/style.css"/>   
        <title>Аутентификация</title>
    </head>
    <body>
        <form action="" method="POST" class="window auth">
            <div class="title">Аутентификация</div>
            <div class="hostdata">
                <div class="host_icon" style="background-image: url(img/2.png)"></div>
                <div class="host_info">
                    <div class="host_name">АИС Школа v2.0</div>
                    <div class="host_addr">@ <?php echo $_SERVER['SERVER_ADDR']; ?></div>
                </div>
            </div>
            <div class="active_form_layer">
                <?php
                    if (!isset($login_error)) $login_error = 0;
                    switch ($login_error) {
                        case 1:
                            $color = "rcolor";
                            $text = "Неправильный логин или пароль";
                            break;
                        case 2:
                            $color = "pcolor";
                            $text = "Данный логин уже занят";
                            break;
                        case 3:
                            $color = "ocolor";
                            $text = "Некорректные данные регистрации";
                            break;
                        case 4:
                            $color = "ocolor";
                            $text = "Недопустимый тип фото";
                            break;
                        case 5:
                            $color = "ocolor";
                            $text = "Недопустимый размер фото";
                            break;
                        case 6:
                            $color = "ocolor";
                            $text = "Ошибка при загрузке фото";
                            break;
                        case 7:
                            $color = "rcolor";
                            $text = "Ошибка при запросе в базу";
                            break;
                        case 8:
                            $color = "pcolor";
                            $text = "Пользователь добавлен";
                            break;
                        case 9:
                            $color = "bcolor";
                            $text = "Пользователь не подтвержден";
                            break;
                        default:
                            $color = "gcolor";
                            $text = "Введите данные для доступа";
                    }
                    printf('<div class="stripe %s"><span class="type">%s</span></div>', $color, $text)
                ?>
                <div class="input_line">
                    <span class="type">Логин:&nbsp;&nbsp;</span>
                    <input required name="username" type="text" class="field" value="">
                </div>
                <div class="input_line">
                    <span class="type">Пароль:&nbsp;</span>
                    <input required name="password" type="password" class="field" value="">
                </div>
                <button id="btn_login" type="submit" name="login" class="button">
                    <div class="button_tag bcolor"></div>
                    <span>Войти</span>
                </button>
                <button id="btn_chekin" type="submit" name="checkin" class="button">
                    <div class="button_tag rcolor"></div>
                    <span>Регистрация</span>
                </button>
            </div>
        </form>
    </body> 
</html>