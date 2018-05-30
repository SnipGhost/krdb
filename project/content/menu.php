<?php
    
    $home = "";
    $schedule = "";
    $reports = "";
    $tables = "";
    $classes = "";
    $notify = "";
    $help = "";
    $find = "";

    switch ($page) {
        case 'home':
            $home = "menu_btn_selected";
            break;
        case 'find':
            $find = "menu_btn_selected";
            break;
        case 'schedule':
            $schedule = "menu_btn_selected";
            break;
        case 'help':
            $help = "menu_btn_selected";
            break;
        case 'tables':
            $tables = "menu_btn_selected";
            break;
        case 'reports':
            $reports = "menu_btn_selected";
            break;
        case 'classes':
            $classes = "menu_btn_selected";
            break;
        case 'notify':
            $notify = "menu_btn_selected";
            break;
        default:
            break;
    }

    printf('<a href="home"><div class="menu_btn %s">
                <div class="material-icons menu-light">home</div>
                <span>Главная</span>
            </div></a>', $home);

    if ($_SESSION['Тип'] != 0) {
        printf('<a href="notify"><div class="menu_btn %s">
                    <div class="material-icons menu-light">speaker_notes</div>
                    <span>Запросы</span>
                </div></a>', $notify);
    }

    if ($_SESSION['Тип'] != 2) {
        printf('<a href="schedule"><div class="menu_btn %s">
                    <div class="material-icons menu-light">schedule</div>
                    <span>Расписание</span>
                </div></a>', $schedule);
    } else {
        printf('<a href="tables"><div class="menu_btn %s">
                    <div class="material-icons menu-light">view_list</div>
                    <span>Таблицы</span>
                </div></a>
                <a href="reports"><div class="menu_btn %s">
                    <div class="material-icons menu-light">assessment</div>
                    <span>Отчеты</span>
                </div></a>', $tables, $reports);
    }

    // printf('<a href="main"><div class="menu_btn %s">
    //             <div class="material-icons menu-light">search</div>
    //             <span>Поиск</span>
    //         </div></a>', $find);

    // SELECT `ФИО`, levenshtein_ratio('sniphost', `username`) AS sim FROM `Пользователи`
    // ORDER BY sim DESC LIMIT 5

    printf('<a href="classes"><div class="menu_btn %s">
                <div class="material-icons menu-light">people</div>
                <span>Классы</span>
            </div></a>', $classes);

    printf('<a href="find"><div class="menu_btn %s">
                <div class="material-icons menu-light">find_in_page</div>
                <span>Поиск</span>
            </div></a>', $find);

    printf('<a href="help"><div class="menu_btn %s">
                <div class="material-icons menu-light">help</div>
                <span>Справка</span>
            </div></a>', $help);

?>    