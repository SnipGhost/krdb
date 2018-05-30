DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `levenshtein_ratio`(`s1` VARCHAR(63) CHARSET utf8, `s2` VARCHAR(63) CHARSET utf8) RETURNS float
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
    DECLARE s1_len, s2_len, max_len INT;
    SET s1_len = LENGTH(s1), s2_len = LENGTH(s2);
    IF s1_len > s2_len THEN 
      SET max_len = s1_len; 
    ELSE 
      SET max_len = s2_len; 
    END IF;
    RETURN (1 - LEVENSHTEIN(s1, s2) / max_len) * 100;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `similarity_ratio`(`s1` VARCHAR(63), `s2` VARCHAR(63)) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE i, j, x, y, res, s1_len, s2_len INT;
    DECLARE word, subword VARCHAR(255);
    SET res = 0, i = 0, x = 0, s1_len = LENGTH(s1), s2_len = LENGTH(s2);
    WHILE i < s1_len DO
        SET i = i + 1;
        IF SUBSTRING(s1, i, 1) = ';' THEN
            SET word = SUBSTRING(s1, x+1, i-x), x = i, j = 0, y = 0;
            WHILE j < s2_len DO
                SET j = j + 1;
                IF SUBSTRING(s2, j, 1) = ';' THEN
                    SET subword = SUBSTRING(s2, y+1, j-y), y = j;
                    IF word = subword THEN
                        SET res = res + 1, j = s2_len + 1;
                    END IF;
                END IF;
            END WHILE;
        END IF;
    END WHILE;
    RETURN ROUND(res * 200 / s2_len);
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `levenshtein`(`s1` VARCHAR(63), `s2` VARCHAR(63)) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
    DECLARE s1_char CHAR;
    DECLARE cv0, cv1 VARBINARY(255);
    SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
    IF s1 = s2 THEN
      RETURN 0;
    ELSEIF s1_len = 0 THEN
      RETURN s2_len;
    ELSEIF s2_len = 0 THEN
      RETURN s1_len;
    ELSE
      WHILE j <= s2_len DO
        SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
      END WHILE;
      WHILE i <= s1_len DO
        SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
        WHILE j <= s2_len DO
          SET c = c + 1;
          IF s1_char = SUBSTRING(s2, j, 1) THEN 
            SET cost = 0; ELSE SET cost = 1;
          END IF;
          SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
          IF c > c_temp THEN SET c = c_temp; END IF;
            SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
            IF c > c_temp THEN 
              SET c = c_temp; 
            END IF;
            SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
        END WHILE;
        SET cv1 = cv0, i = i + 1;
      END WHILE;
    END IF;
    RETURN c;
END$$
DELIMITER ;
