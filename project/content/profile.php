<?php 

    function printProfilePage($username, $fio, $tel, $email, $sex, $age, $ava, $enabled)
    {
        global $PATH;

        if ($enabled) {
            $password = '<div class="line">
                        <span>Пароль:</span>
                        <input type="password" autocomplete="off" name="password" value="" required/>
                        </div><br>';
        } else $password = '';

        printf('<div class="edit-form-wrap userline"><div class="avatar" style="background-image: url(%s);"></div><span>%s</span></div>', $PATH.$ava, $fio);

        if (!$enabled) {
            $class = "disabled";
        } else $class = "";

        printf('<form class="edit-form reg-form %s" action="" method="POST" enctype="multipart/form-data">
                    <div class="line">
                        <span>Логин:</span>
                        <input type="text" name="username" autocomplete="off" value="%s" required/>
                    </div><br>
                    %s
                    <div class="line">
                        <span>ФИО:</span>
                        <input name="fio" class="longfield" autocomplete="off" placeholder="Дефолтов Дефолт Дефолтович" value="%s" type="text" required/>
                    </div><br>
                    <div class="line">
                        <span>Телефон:</span>
                        <input name="tel" autocomplete="off" placeholder="+7 (910) 123-45-67" type="tel" pattern="+7 ([0-9]{3}) [0-9]{3}-[0-9]{2}-[0-9]{2}" value="%s" required/>
                    </div><br>
                    <div class="line">
                        <span>Email:</span>
                        <input name="email" autocomplete="off" placeholder="email@example.com" value="%s" type="email" required/>
                    </div><br>
                    <div class="line">
                        <span>Ваш пол:</span>', $class, $username, $password, $fio, $tel, $email);

        if ($sex == "Муж.") {
            $male = "selected";
            $female = "";
        } else {
            $male = "";
            $female = "selected";
        }
        printf('<select name="sex">
                    <option value="Муж." %s>Мужской</option>
                    <option value="Жен." %s>Женский</option>
                </select>', $male, $female);

        if ($enabled)
            $button = '<button name="_update" class="edit-form-btn material-icons md-light md-nav" type="submit">save</button>';
        else $button = '';

        printf('</div><br>
            <div class="line">
                <span>Дата рождения:</span>
                <input name="age" type="date" autocomplete="off" placeholder="yyyy-mm-dd" min="1930-01-01" max="2013-01-01" value="%s" required/>
            </div><br>
            <!-- <div class="line">
                <span>Фотография:</span><br><br>
                <input type="file" name="avatar" required>
            </div><br> --><br><br>
            %s
        </form>', $age, $button);

    }

    if (isset($_POST['_update']) && 
        isset($_POST['username']) && 
        isset($_POST['password']) &&
        isset($_POST['fio']) &&
        isset($_POST['tel']) &&
        isset($_POST['email']) &&
        isset($_POST['sex']) &&
        isset($_POST['age']))
    {
        // TODO: заэкранировать все пост-переменные
        $password = hash("sha256", $_POST['password']);
        $q = "UPDATE `Пользователи` SET `password` = '".$password."', `ФИО` = '".$_POST['fio']."', `Телефон` = '".$_POST['tel']."', `Email` = '".$_POST['email']."', `Пол` = '".$_POST['sex']."', `ДР` = '".$_POST['age']."' WHERE `username` = '".$_POST['username']."'";
        if ($mysqli->query($q)) {
            $_SESSION['ФИО'] = $_POST['fio'];
            $_SESSION['Тлефон'] = $_POST['tel'];
            $_SESSION['Email'] = $_POST['email'];
            $_SESSION['Пол'] = $_POST['sex'];
            $_SESSION['ДР'] = $_POST['age'];
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        else printf('<span class="orange">Сбой обновления данных</span><br>');
    }

    if (!isset($_GET['id'])) {
        printProfilePage($_SESSION['username'],
                         $_SESSION['ФИО'],
                         $_SESSION['Телефон'],
                         $_SESSION['Email'],
                         $_SESSION['Пол'],
                         $_SESSION['ДР'],
                         $_SESSION['Аватар'],
                         true);
    } else {
        $id = $mysqli->real_escape_string($_GET['id']);
        $q = "SELECT username, ФИО, Телефон, Email, Пол, ДР, Аватар FROM `Пользователи` WHERE Пользователь_ID = '".$id."' LIMIT 1";
        if ($result = $mysqli->query($q)) {
            if ($row = $result->fetch_assoc()) {
                printProfilePage($row['username'], 
                                 $row['ФИО'],
                                 $row['Телефон'],
                                 $row['Email'],
                                 $row['Пол'],
                                 $row['ДР'],
                                 $row['Аватар'],
                                 false);
            }
            else printf('<span class="orange">Нет такого пользователя</span><br>');
        }
        else printf('<span class="orange">Нет такого пользователя</span><br>');
    }

?>

