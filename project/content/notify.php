<?php

    if (isset($_POST['_approve']) && 
        isset($_POST['Пользователь_ID']) &&
        isset($_POST['Approve_ID'])) 
    {
        if (!isset($_POST['Класс_ID'])) $classid = "NULL";
        else $classid = "'".$mysqli->real_escape_string($_POST['Класс_ID'])."'";
        if (!isset($_POST['Подгруппа_ID'])) $groupid = "NULL";
        else $groupid = "'".$mysqli->real_escape_string($_POST['Подгруппа_ID'])."'";
        $userid = $mysqli->real_escape_string($_POST['Пользователь_ID']);
        $approveid = $mysqli->real_escape_string($_POST['Approve_ID']);

        $query1 = "UPDATE `Пользователи`
                    SET `Подтвержден` = '1', `Класс_ID` = ".$classid.", `Подгруппа_ID` = ".$groupid."
                    WHERE `Пользователь_ID` = '".$userid."'";
        $query2 = "DELETE FROM `Подтверждения` WHERE `ID` = '".$approveid."'";

        $mysqli->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
        if ($mysqli->query($query1) && $mysqli->query($query2)) {
            printf('<span class="green">Пользователь успешно подтвержден</span><br>');
            $mysqli->commit();
        } else {
            printf('<span class="orange">Произошла ошибка</span><br>');
        }

    }

    $selector_class = '<select name="Класс_ID">';
    $q = "SELECT `Класс_ID`, `Год_обучения`, `Буква_класса` FROM `Классы` WHERE 1";
    if ($result = $mysqli->query($q)) {
        while ($row = $result->fetch_assoc())
        {
            $selector_class .= '<option value="'.$row['Класс_ID'].'">'.$row['Год_обучения'].$row['Буква_класса']."</option>";
        }
    }
    $selector_class .= '</select>';

    $selector_group = '<select name="Подгруппа_ID">';
    $q = "SELECT `Подгруппа_ID`, `Подгруппа` FROM `Подгруппы` WHERE 1";
    if ($result = $mysqli->query($q)) {
        while ($row = $result->fetch_assoc())
        {
            $selector_group .= '<option value="'.$row['Подгруппа_ID'].'">'.$row['Подгруппа']."</option>";
        }
    }
    $selector_group .= '</select>';

    $query = "SELECT P.`ID`, P.`Пользователь_ID`, P.`Дата`, P.`Тип`, U.`ФИО`, U.`Email`, U.`Пол`, U.`ДР`
            FROM `Подтверждения` AS P 
            LEFT JOIN `Пользователи` AS U 
                ON P.`Пользователь_ID` = U.`Пользователь_ID`
            WHERE P.`Тип` <= ".$_SESSION['Тип'];

    $types[0] = "Ученик";
    $types[1] = "Учитель";
    $types[2] = "Администратор";

    printf('<h3>Пользователи, требующие подтверждения аккаунта:</h3><br>');

    if ($result = $mysqli->query($query)) 
    {
        printf('<table class="tbl">');
        printf('<tr>');
        printf('<th>%s</th>', 'Дата');
        printf('<th>%s</th>', 'Тип');
        printf('<th>%s</th>', 'ФИО');
        printf('<th>%s</th>', 'Email');
        printf('<th>%s</th>', 'Пол');
        printf('<th>%s</th>', 'ДР');
        printf('<th>%s</th>', 'Подтверждение');
        printf('</tr>');
        while ($row = $result->fetch_assoc())
        {
            printf('<tr>');
            printf ('<td>%s</td>', $row['Дата']);
            printf ('<td>%s</td>', $types[$row['Тип']]);
            printf ('<td>%s</td>', $row['ФИО']);
            printf ('<td>%s</td>', $row['Email']);
            printf ('<td>%s</td>', $row['Пол']);
            printf ('<td>%s</td>', $row['ДР']);
            if ($row['Тип'] == 0) {
                printf ('<td><form class="edit-form approve-form" method="POST">
                            <input name="Пользователь_ID" type="hidden" value="%s"/>
                            <input name="Approve_ID" type="hidden" value="%s"/>
                            %s
                            %s
                            <button type="submit" name="_approve" class="material-icons md-light md-nav">check_circle</button>
                        </form></td>', $row['Пользователь_ID'], $row['ID'], $selector_class, $selector_group);
            } else {
                printf ('<td><form class="edit-form approve-form" method="POST">
                            <input name="Пользователь_ID" type="hidden" value="%s"/>
                            <input name="Approve_ID" type="hidden" value="%s"/>
                            <button type="submit" name="_approve" class="material-icons md-light md-nav">check_circle</button>
                        </form></td>', $row['Пользователь_ID'], $row['ID']);
            }
            printf('</tr>');
        }
        printf('</table><br>');

        $result->close();

    } 
    else printf('<span class="orange">No result</span><br>');

?>