DELIMITER |
CREATE PROCEDURE delete_user_mailing_list(IN id INT(11))
BEGIN
    DELETE FROM mailing_list WHERE ID_ML = id;
END|

CREATE PROCEDURE delete_user_mailing_list2(IN Mail VARCHAR(150))
BEGIN
    DELETE FROM mailing_list WHERE MAIL_ML = Mail;
END|