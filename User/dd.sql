

CREATE TABLE ace_user(
id			INT(11)			AUTO_INCREMENT PRIMARY KEY,
email			VARCHAR(128)		NOT NULL,
auth			TINYINT(1)		NOT NULL DEFAULT 0,
username		VARCHAR(8)		NOT NULL,
password		VARCHAR(32)		NOT NULL,
reg_code		VARCHAR(32)		NOT NULL,	
active			TINYINT(1)		NOT NULL DEFAULT 0,
registered		TIMESTAMP(10)           NOT NULL,
activated		TIMESTAMP(10)           NULL);

