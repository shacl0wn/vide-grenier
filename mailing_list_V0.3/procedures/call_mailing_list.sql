DELIMITER |
CREATE PROCEDURE call_mailing_list(IN Nbr INT(11))
BEGIN
    SELECT * FROM mailing_list LIMIT Nbr, 25;
END|

CREATE PROCEDURE call_user_mailing_list(IN Mail VARCHAR(150))
BEGIN
    SELECT * FROM mailing_list WHERE MAIL_ML = Mail;
END|