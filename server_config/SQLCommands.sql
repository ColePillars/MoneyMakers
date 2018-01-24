/*Make MySQL user for web app with limited permissions to combat extreme forms of injections*/
CREATE USER 'MoneyMakersDev'@'localhost' IDENTIFIED WITH mysql_native_password AS '***';GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'MoneyMakersDev'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
/*Adding atr_user key for user registration and password reset */
ALTER TABLE `tbl_user_info` ADD `atr_user_key` VARCHAR(20) NOT NULL AFTER `atr_zip`;

