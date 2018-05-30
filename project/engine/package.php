<?php

	function connectToDB()
	{
		$mysqli = new mysqli("localhost", "root", "214736", "db_school");

		if ($mysqli->connect_errno)
		{
			printf('<span class="orange">Не удалось подключиться: %s</span><br>', $mysqli->connect_error);
			exit();
		}

		if (!$mysqli->set_charset("utf8"))
		{
			printf('<span class="orange">Ошибка при загрузке набора символов utf8: %s</span><br>', $mysqli->error);
			exit();
		}

		return $mysqli;
	}

    function printTableForm($mysqli, $query)
    {
        if ($result = $mysqli->query($query)) 
        {
            // printf('<span class="blue">%s</span><br>', $query);
            //printf('<span class="pink">Select вернул %d строк(и):</span><br><br>', $result->num_rows);

            $num = 0;

            /* Вывод таблицы */
            printf('<table class="tbl">');
            while ($row = $result->fetch_assoc())
            {
                /* Вывод заголовка, только один раз*/
                if ($num == 0)
                {
                    printf('<tr>');
                    foreach ($row as $key => $value)
                        printf ('<th>%s</th>', $key);
                    printf('</tr>');
                }
                $num++;
                /* Вывод строк */
                printf('<tr>');
                foreach ($row as $value)
                    printf ('<td>%s</td>', $value);
                printf('</tr>');
            }
            printf('</table><br>');

            $result->close();

        } 
        else printf('<span class="orange">No result</span><br>');
    }

    function printEditorForm($mysqli, $query, $table_name)
    {
        if ($result = $mysqli->query($query)) 
        {
            /* Вывод формы редактирования */
            printf('<div id="edit-form-wrap" class="edit-form-wrap">');
            printf('<div class="edit-form-nav">');
            printf('<button class="edit-form-btn material-icons md-light md-nav" onClick="nextRecord();">skip_next</button>');
            printf('<button class="edit-form-btn material-icons md-light md-nav" onClick="lastRecord();">skip_previous</button>');
            printf('<button class="edit-form-btn material-icons md-light md-nav" onClick="newRecord();">control_point</button>');
            printf('</div><br>');
            $num = 0;
            while ($row = $result->fetch_assoc())
            {
                ++$num;
                if ($num == 1) {
                    printf('<form id="edit-form-newrec" class="edit-form undisplay" action="" method="POST">', $num);
                    foreach ($row as $key => $value)
                        printf ('<div class="line"><span calass="green">%s:</span><input name="%s" autocomplete="off" value="%s" type="text"/></div><br>', $key, $key, "");
                    printf('<input type="hidden" name="_table" value="%s"/>', $table_name);
                    printf('<button name="_insert" class="edit-form-btn material-icons md-light md-nav" value="" type="submit">save</button>');
                    printf('<br><br></form>');
                }
                printf('<form id="edit-form-%s" class="edit-form undisplay" action="" method="POST">', $num);
                foreach ($row as $key => $value)
                    printf ('<div class="line"><span calass="green">%s:</span><input name="%s" autocomplete="off" value="%s" type="text"/></div><br>', $key, $key, $value);
                printf('<input type="hidden" name="_table" value="%s"/>', $table_name);
                reset($row);
                $first_key = key($row);
                printf('<input type="hidden" name="_id_field" value="%s"/>', $first_key);
                printf('<button name="_update" class="edit-form-btn material-icons md-light md-nav" value="" type="submit">save</button>');
                printf('<button name="_delete" class="edit-form-btn material-icons md-light md-nav" value="" type="submit">delete</button>');
                
                printf('<br><br></form>');
            }
            $result->close();
            printf('</div>');
        }
        else printf('<span class="orange">No result</span><br>');
    }

    function getClassName($mysqli, $class_id)
    {
        $query = "SELECT `Год_обучения`, `Буква_класса` FROM `Классы` WHERE `Класс_ID` = '".$class_id."' LIMIT 1";

        if ($result = $mysqli->query($query))
        {
            if ($row = $result->fetch_assoc()) {
                return $row['Год_обучения'].$row['Буква_класса'];
            } else {
                $result->close();
                return "ERROR";
            }
            $result->close();
        }
        else {
            printf('<span class="orange">No result</span><br>');
            return "ERROR";
        }
    }

    function parseURI()
    {
        global $PATH;
        $request = explode('?', $_SERVER['REQUEST_URI']);

        switch ($request[0]) {
            case $PATH:
                $page = "home";
                break;
            default:
                $page = str_replace($PATH, "", $request[0]);
        }

        return $page;
    }

?>