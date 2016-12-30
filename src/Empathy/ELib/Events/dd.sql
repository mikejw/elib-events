

CREATE TABLE  				event(
id     					INT(11)		AUTO_INCREMENT PRIMARY KEY,
user_id					INT(11)		NOT NULL,
start_time				TIMESTAMP(10)	NULL,
end_time				TIMESTAMP(10)	NULL,
event_name				VARCHAR(256)	NOT NULL,
short_desc				TEXT		NULL,
long_desc				TEXT		NULL,
tickets_link				VARCHAR(256)	NULL,
event_link				VARCHAR(256)	NULL,
status					TINYINT(1)	NOT NULL DEFAULT 0);

