<?php

    if (isset($_POST["_update"]))
    {
        $line = "";
        foreach ($_POST as $key => $value) {
            if ($key[0] == "_") continue;
            if ($value == "") continue; //$line .= "`".$mysqli->escape_string($key)."` = NULL, ";
            else $line .= "`".$mysqli->escape_string($key)."` = '".$mysqli->escape_string($value)."', ";
        }

        $id_field = $mysqli->escape_string($_POST["_id_field"]);
        $id_value = $mysqli->escape_string($_POST[$id_field]);
        $table = $mysqli->escape_string($_POST["_table"]);

        $q = "UPDATE `".$table."` SET ".substr($line, 0, -2)." WHERE `".$id_field."` = '".$id_value."'";
        printf('<span class="blue">%s</span><br>', $q);

        if (!$mysqli->query($q))
             printf('<span class="orange">Ошибка при запросе!</span><br>');
        else printf('<span class="green">Успешно обновлено!</span><br>');
    }

    if (isset($_POST["_delete"]))
    {
        $id_field = $mysqli->escape_string($_POST["_id_field"]);
        $id_value = $mysqli->escape_string($_POST[$id_field]);
        $table = $mysqli->escape_string($_POST["_table"]);

        $q = "DELETE FROM `".$table."` WHERE `".$id_field."` = '".$id_value."'";
        printf('<span class="blue">%s</span><br>', $q);

        if (!$mysqli->query($q))
             printf('<span class="orange">Ошибка при запросе!</span><br>');
        else printf('<span class="green">Успешно удалено!</span><br>');
    }

    if (isset($_POST["_insert"]))
    {
        $line = "";

        foreach ($_POST as $key => $value) {
            if ($key[0] == "_") continue;
            if ($value == "") $line .= "NULL, ";
            else $line .= "'".$mysqli->escape_string($value)."', ";
        }

        $table = $mysqli->escape_string($_POST["_table"]);

        $q = "INSERT INTO `".$table."` VALUES(".substr($line, 0, -2).")";
        printf('<span class="blue">%s</span><br>', $q);

        if (!$mysqli->query($q))
             printf('<span class="orange">Ошибка при запросе!</span><br>');
        else printf('<span class="green">Успешно добавлено!</span><br>');
    }

    $PATH = "/~snipghost/project/"

?>


    <script type="text/javascript">
        var cur_rec = 1;
        var max_num = 0;
        document.addEventListener('DOMContentLoaded', function() { 
            max_num = document.getElementById('edit-form-wrap').childElementCount - 3;
        });
        function newRecord() {
            document.getElementById('edit-form-' + cur_rec.toString()).style.display = "none";
            cur_rec = 0;
            document.getElementById('edit-form-newrec').style.display = "block";
        }
        function nextRecord() {
            if (cur_rec == 0) {
                document.getElementById('edit-form-newrec').style.display = "none";
                cur_rec = 1;
            } else {
                document.getElementById('edit-form-' + cur_rec.toString()).style.display = "none";
                cur_rec++;
            }
            var element = document.getElementById('edit-form-' + cur_rec.toString());
            if (!element) {
                cur_rec = 1;
                document.getElementById('edit-form-' + cur_rec.toString()).style.display = "block";
            }
            else element.style.display = "block";
        }
        function lastRecord() {
            if (cur_rec == 1) {
                document.getElementById('edit-form-1').style.display = "none";
                cur_rec = max_num;
                document.getElementById('edit-form-' + cur_rec.toString()).style.display = "block";
                return;
            }
            if (cur_rec == 0) {
                document.getElementById('edit-form-newrec').style.display = "none";
                cur_rec = 1;
            } else {
                document.getElementById('edit-form-' + cur_rec.toString()).style.display = "none";
                cur_rec--;
            }
            document.getElementById('edit-form-' + cur_rec.toString()).style.display = "block";
        }
    </script>
        
    <form id="choose-table" class="edit-form-wrap edit-form  " action="" method="GET">
        <label>Выбор таблицы: </label>
        <button type="submit" class="material-icons md-light md-nav">check_circle</button>
        <select name="table">
            <?php
                printf('<span class="orange">!!!</span><br>');
                if ($result = $mysqli->query("SHOW TABLES")) {
                    //printf('<span class="green">Select вернул %d строк(и):</span><br>', $result->num_rows);
                    while ($row = $result->fetch_assoc()) {
                        if (isset($_GET['table']) && $row["Tables_in_db_school"] == $_GET['table']) printf('<option selected>');
                        else printf('<option>');
                        printf ("%s</option>", $row["Tables_in_db_school"]);
                    }
                    $result->close();
                } else {
                    printf('<span class="orange">No result</span><br>');
                }
            ?>
        </select>
    </form>

        
    <?php

        $table_name = "Время";

        if (isset($_GET['table'])) {
            $get_string = $_GET['table'];
            $table_name = $mysqli->real_escape_string($get_string);
        }

        $q = "SELECT * FROM `".$table_name."` WHERE 1";

        printTableForm($mysqli, $q);
        printEditorForm($mysqli, $q, $table_name);

    ?>

    <br><br><br>