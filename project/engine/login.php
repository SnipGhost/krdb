<?php
    if (isset($_POST['logout'])) {
        unset($_SESSION['username']);
    }

    if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {

        $username = $mysqli->real_escape_string($_POST['username']);
        $password = hash("sha256", $_POST['password']);

        $q = "SELECT * FROM Пользователи WHERE username = '".$username."' AND password = '".$password."' LIMIT 1";

        if ($result = $mysqli->query($q)) {
            if ($row = $result->fetch_assoc()) {
                if ($row['Подтвержден'] == 1) {
                    foreach ($row as $key => $value)
                        $_SESSION[$key] = $value;
                } else {
                    $login_error = 9; // Пользователь не подтвержден
                }
            } else {
                $login_error = 1; // Запрос неудачен, нечего фетчить, но скажем что юзера нет
            }
        } else {
            $login_error = 1; // Запрос неудачен, пользователя нет или базе каюк
        }

        $result->close();

    } else if (isset($_POST['checkin']) && isset($_POST['username']) && isset($_POST['password'])) {

        $q = "SELECT username FROM Пользователи WHERE username = '".$_POST['username']."'";
        if ($result = $mysqli->query($q)) {
            if ($result->num_rows == 0) {
                include("engine/reg.php");
                exit();
            } else {
                $login_error = 2; // Такой пользователь уже зарегестрирован
            }
        } else {
            $login_error = 7; // Неведомая хрень при запросе в базу
        }

    }
?>