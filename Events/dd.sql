

CREATE TABLE  				event(
id     					INT(11)		AUTO_INCREMENT PRIMARY KEY,
user_id					INT(11)		NOT NULL,
start_time				TIMESTAMP(10)	NULL,
end_time				TIMESTAMP(10)	NULL,
title					VARCHAR(256)	NOT NULL,
short_desc				TEXT		NULL,
long_desc				TEXT		NULL,
tickets_link				VARCHAR(256)	NULL,
event_link				VARCHAR(256)	NULL);

