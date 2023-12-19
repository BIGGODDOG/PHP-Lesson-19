DELIMITER $$CREATE TRIGGER hash_password BEFORE INSERT ON users
       FOR EACH ROW       BEGIN
           SET new.password = SHA1(CONCAT(salt, MD5(password)));       END$$
DELIMITER ;



DELIMITER $$
	CREATE TRIGGER hash_password_update
	BEFORE UPDATE ON usersFOR EACH ROW
	BEGIN
	SET NEW.password = SHA1(CONCAT(NEW.salt, MD5(NEW.password)));
END$$



DELIMITER $$
	CREATE TRIGGER salt_changed
	BEFORE UPDATE ON usersFOR EACH ROW
	BEGIN
	SET NEW.salt = OLD.salt;
END$$