<?php

    function printBars($mysqli, $query)
    {
        if ($result = $mysqli->query($query)) 
        {
            $num = 0;
            $sum = 0;

            while ($row = $result->fetch_assoc())
            {
                $sum += $row['Суммарная стоимость'];
                $arr[$num] = $row['Суммарная стоимость'];
                $nam[$num] = $row['Корпус'];
                $num++;
            }

            printf("<br><br>");

            for ($i = 0; $i < $num; $i++) {
                printf('<div style="width: 500px;"><span>%s:</span><div class="meter nostripes bar">', $nam[$i]);
                printf('<span style="width: %s;"></span>', ($arr[$i] / $sum * 100)."%");
                printf('</div></div><br>');
            }

            $result->close();
        } 
    }

?>

    <center><h3>Распределение пользователей по классам</h3><br>

    <div id="container" class="vis container">  

        <canvas id="chart" width="500" height="370"></canvas>
    
        <table id="chartData" style="margin-top: 20px;">
                            
            <?php 

                $colors[0] = "#ED5713";
                $colors[1] = "#0DA068";
                $colors[2] = "#194E9C";
                $colors[3] = "#ED9C13";
                $colors[4] = "#050049";

                $query = "SELECT CONCAT(C.`Год_обучения`, C.`Буква_класса`) AS Класс, COUNT(U.`username`) AS Количество
                            FROM `Пользователи` AS U 
                            LEFT JOIN `Классы` AS C
                                ON C.`Класс_ID` = U.`Класс_ID`
                            GROUP BY Класс";

                if ($result = $mysqli->query($query)) 
                {
                    $num = 0;
                    printf('<tr><th>Класс</th><th>Количество</th></tr>');
                    while ($row = $result->fetch_assoc())
                    {
                        printf('<tr style="color: %s">', $colors[$num]);
                        foreach ($row as $value) {
                            if ($value == "") $value = "Без класса";
                            printf ('<td>%s</td>', $value);
                        }
                        printf('</tr>');
                        $num++;
                    }
                    $result->close();
                }

            ?>
    
        </table>
                
    </div></center><br><br><hr><br><br><br>


    <h3>Сравнительная суммарная стоимость оборудования в кабинетах</h3><br>
    <?php
        $q = "SELECT `Корпус`, SUM(`Cost`) AS `Суммарная стоимость` FROM `Кабинеты` GROUP BY `Корпус`";
        printTableForm($mysqli, $q);
        printBars($mysqli, $q);
    ?>

    <br><hr><br><br>

    <h3>Отношение количества женщин и мужчин</h3><br>
    <?php
        $q = "SELECT `Пол`, COUNT(`username`) AS `Количество` FROM `Пользователи` GROUP BY `Пол`";
        printTableForm($mysqli, $q);
    ?>

    <br><br><br><br><br><br>
