DELIMITER |
CREATE PROCEDURE insert_mailing_list(IN Mail VARCHAR(150))
BEGIN
    INSERT INTO mailing_list (MAIL_ML) VALUES (Mail);
END|
