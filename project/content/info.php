<html>
<head>
    <title>Test page</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <div class="header"></div>
    <div class="wrapper">
        
        <?php

            echo '<pre class="blue">'.print_r($_GET,true).'</pre><br><br>';
            echo '<pre class="blue">'.print_r($_POST,true).'</pre><br><br>';

            echo '<p class="blue">';

            $mysqli = new mysqli("localhost", "root", "214736", "db_school");

            if ($mysqli->connect_errno) {
                printf("Не удалось подключиться: %s<br>", $mysqli->connect_error);
                exit();
            }

            printf("Изначальная кодировка: %s<br>", $mysqli->character_set_name());

            /* изменение набора символов на utf8 */
            if (!$mysqli->set_charset("utf8")) {
                printf("Ошибка при загрузке набора символов utf8: %s<br>", $mysqli->error);
                exit();
            } else {
                printf("Текущий набор символов: %s<br>", $mysqli->character_set_name());
            }

            $q = "SHOW TABLES";

            if ($result = $mysqli->query($q)) {

                printf("<br>Select вернул %d строк.<br>", $result->num_rows);

                while ($row = $result->fetch_assoc()) {
                    printf ("%s<br>", $row["Tables_in_db_school"]);
                }

                $result->close();

            } else {
                printf("No result!");
            }

            $mysqli->close();

            echo '<p class="blue">';

        ?>

    </div>
    <div class="footer"></div>
</body>
</html>