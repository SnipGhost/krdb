<?php

    function resize($file, $name, $quality = null, $uploaddir = 'upload/')
    {

        // Ограничение по ширине в пикселях
        $max_size = 600;

        // Качество изображения по умолчанию
        if ($quality == null)
        $quality = 75;

        // Cоздаём исходное изображение на основе исходного файла
        if ($file['type'] == 'image/jpeg')
            $src = imagecreatefromjpeg($file['tmp_name']);
        elseif ($file['type'] == 'image/png')
            $src = imagecreatefrompng($file['tmp_name']);
        elseif ($file['type'] == 'image/gif')
            $src = imagecreatefromgif($file['tmp_name']);
        else
            return false;

        // Определяем ширину и высоту изображения
        $w_src = imagesx($src); 
        $h_src = imagesy($src);

        $w = $max_size;
        if ($w_src < $w) $w = $w_src;

        // Создаём пустую квадратную картинку 
        $dest = imagecreatetruecolor($w, $w); 

        // Вырезаем квадратную серединку по x, если фото горизонтальное
        if ($w_src > $h_src)
            imagecopyresampled($dest, $src, 0, 0, round((max($w_src, $h_src) - min($w_src, $h_src))/2), 0, $w, $w, min($w_src, $h_src), min($w_src, $h_src));
        // Вырезаем квадратную серединку по y, если фото горизонтальное
        elseif ($w_src < $h_src)
            imagecopyresampled($dest, $src, 0, 0, 0, round((max($w_src, $h_src) - min($w_src, $h_src))/2), $w, $w, min($w_src, $h_src), min($w_src, $h_src));
        // Квадратная картинка масштабируется без вырезок
        elseif ($w_src == $h_src)
            imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $w, $w_src, $w_src);

        // echo "src: " .$w_src . "x" . $h_src . "<br>";
        // echo "new: " .$w . "x" . $w . "<br>";

        $filename = $uploaddir . $name . ".jpeg";
        // echo $filename . "<br>";
        // Вывод картинки и очистка памяти
        if (!imagejpeg($dest, $filename, $quality))
            return NULL;

        imagedestroy($dest);
        imagedestroy($src);

        return $filename;
    }

    function regNewUser($mysqli) {

        // Пути загрузки файлов
        $uploaddir = 'upload/';
        // Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');
        // Максимальный размер файла
        $size = 1024000;

        // Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!isset($_POST['username']) ||
                !isset($_POST['password']) ||
                !isset($_POST['fio']) ||
                !isset($_POST['tel']) ||
                !isset($_POST['email']) ||
                !isset($_POST['sex']) ||
                !isset($_POST['age']) ||
                !isset($_POST['type']) ||
                !isset($_FILES['avatar']['error']))
            {
                return 3;
            } else {

                // Проверяем тип файла
                if (!in_array($_FILES['avatar']['type'], $types))
                    return 4;
                
                // Проверяем размер файла
                if ($_FILES['avatar']['size'] > $size)
                    return 5;

                //$uploadfile = $uploaddir . basename($_FILES['avatar']['name']);
                // $uploadfile = $uploaddir . $_POST['username'] . "." .
                //     pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

                $uploadfile = resize($_FILES['avatar'], $_POST['username']);

                if ($uploadfile == NULL)
                    return 6;
                else {
                    //echo 'Загрузка удачна <a href="' . $uploadfile . '">Посмотреть</a> ' ;
                    $q = "INSERT INTO Пользователи(username, password, ФИО, Телефон, Email, Пол, ДР, Тип, Аватар) VALUES('".
                            $_POST['username']."','".
                            hash("sha256", $_POST['password'])."','".
                            $_POST['fio']."','".
                            $_POST['tel']."','".
                            $_POST['email']."','".
                            $_POST['sex']."','".
                            $_POST['age']."','".
                            $_POST['type']."','".
                            $uploadfile."')";
                    // echo $q;
                    if ($mysqli->query($q)) {
                        return 8;
                    } else {
                        return 7;
                    }
                }

                // Загрузка файла и вывод сообщения
                // if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile))
                //     echo 'Загрузка удачна <a href="' . $uploadfile . '">Посмотреть</a> ' ;
                // else
                    

            }
        }
    }

    if (isset($_POST['registrate'])) {

        $login_error = regNewUser($mysqli);

    }

?>