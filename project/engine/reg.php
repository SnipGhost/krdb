<html>
<head>
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="<?=$PATH?>style/style.css"/>   
    <link rel="stylesheet" type="text/css" href="<?=$PATH?>style/main.css"/>  
    </head>
<body>
    <div class="window regis">
        <div class="title">Регистрация</div>
        <form class="edit-form reg-form" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="username" value="<?=$_POST['username']?>"/>
            <input type="hidden" name="password" value="<?=$_POST['password']?>"/>
            <div class="line">
                <span>ФИО:</span>
                <input name="fio" class="longfield" autocomplete="off" placeholder="Дефолтов Дефолт Дефолтович" value="" type="text" required/>
            </div><br>
            <div class="line">
                <span>Телефон:</span>
                <input name="tel" autocomplete="off" placeholder="+7 (910) 123-45-67" type="tel" pattern="+7 ([0-9]{3}) [0-9]{3}-[0-9]{2}-[0-9]{2}" value="" required/>
            </div><br>
            <div class="line">
                <span>Email:</span>
                <input name="email" autocomplete="off" placeholder="email@example.com" value="" type="email" required/>
            </div><br>
            <div class="line">
                <span>Ваш пол:</span>
                <select name="sex">
                  <option value="Муж." selected>Мужской</option>
                  <option value="Жен.">Женский</option>
                </select>
            </div><br>
            <div class="line">
                <span>Дата рождения:</span>
                <input name="age" type="date" autocomplete="off" placeholder="yyyy-mm-dd" min="1930-01-01" max="2013-01-01" value="" required/>
            </div><br>
            <div class="line">
                <span>Тип учетной записи:</span>
                <select name="type">
                  <option value="0" selected>Ученик</option>
                  <option value="1">Учитель</option>
                  <option value="2">Администратор</option>
                </select>
            </div><br>
            <div class="line">
                <span>Фотография:</span><br><br>
                <input type="file" name="avatar" required>
            </div><br><br><br>
            <button id="btn_login" type="submit" name="registrate" class="button">
                <div class="button_tag gcolor"></div>
                <span>Подтвердить</span>
            </button>
        </form>
    </div>
</body>
</html>