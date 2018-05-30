CREATE TABLE `db_school`.`users` ( `id`         INT         NOT NULL AUTO_INCREMENT , 
                                   `username`   VARCHAR(32) NOT NULL ,
                                   `password`   VARCHAR(64) NOT NULL ,
                                   `lastname`   VARCHAR(64) NOT NULL ,
                                   `firstname`  VARCHAR(64) NOT NULL ,
                                   `secondname` VARCHAR(64) NOT NULL ,
                                   `email`      VARCHAR(64) NOT NULL ,
                                   `birth`      DATE        NOT NULL ,
                                   `type`       ENUM('low','mid','high') NOT NULL ,
                                   `avatar`     VARCHAR(64) NOT NULL ,
                                   PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Таблица пользователей';

/*************************************************************************************************/

ALTER TABLE `users` ADD UNIQUE(`username`);
ALTER TABLE `users` ADD `sex` BOOLEAN NOT NULL DEFAULT FALSE AFTER `secondname`;

/*************************************************************************************************/

INSERT INTO `users` (`id`, `username`, `password`, `lastname`, `firstname`, `secondname`, `email`, `birth`, `type`, `avatar`)
    VALUES (NULL, 'snipghost', '3AD9E926030A55B5F571FF82A6D03F2CFCAB9E3CAD490D77524847834F1739A8', 'Кучеренко', 'Михаил', 'Александрович', 'snipghost@list.ru', '1998-12-16', 'high', 'img/user.png'),
           (NULL, 'hikaru', '3AD9E926030A55B5F571FF82A6D03F2CFCAB9E3CAD490D77524847834F1739A8', 'Итидзе', 'Хикару', '\"Капитан\"', 'snipghost@list.ru', '1998-11-11', 'mid', 'img/0d.png')