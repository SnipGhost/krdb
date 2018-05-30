<?php

    function printClass($mysqli, $class_id)
    {
        $class_id = $mysqli->real_escape_string($class_id);

        printf('<h3>Состав %s класса:</h3><br>', getClassName($mysqli, $class_id));

        $query = "SELECT Пользователь_ID, ФИО, Аватар FROM ученики WHERE Класс_ID = '".$class_id."'";

        if ($result = $mysqli->query($query))
        {

            printf('<div>');
            while ($row = $result->fetch_assoc())
            {
                printf('<a href="profile?id=%s" class="edit-form-wrap userline">
                            <div class="avatar" style="background-image: url(\'%s\');"></div>
                            <span>%s</span>
                        </a>', $row['Пользователь_ID'], $row['Аватар'], $row['ФИО']);
            }
            printf('</div><br>');

            $result->close();

        } 
        else printf('<span class="orange">No result</span><br>');
    }

    if ($_SESSION['Тип'] == 0) {

        printClass($mysqli, $_SESSION['Класс_ID']);

    } else {

        printf('<form id="choose-table" class="edit-form-wrap edit-form" action="" method="GET">
                <label>Выбор класса: </label>
                <button type="submit" class="material-icons md-light md-nav">check_circle</button>
                <select name="class">');

        if ($result = $mysqli->query("SELECT * FROM Классы")) {
            //printf('<span class="green">Select вернул %d строк(и):</span><br>', $result->num_rows);
            while ($row = $result->fetch_assoc()) {
                if (isset($_GET['class']) && $row["Класс_ID"] == $_GET['class'])
                     printf('<option value="%s" selected>', $row["Класс_ID"]);
                else printf('<option value="%s">', $row["Класс_ID"]);
                printf ("%s</option>", $row["Год_обучения"].$row["Буква_класса"]);
            }
            $result->close();
        }

        printf('</select></form>');

        $class_id = "1";
        if (isset($_GET['class'])) {
            $class_id = $_GET['class'];
        }

        printClass($mysqli, $class_id);

    }

?>