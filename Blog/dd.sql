

CREATE TABLE  				blog(
id     					INT(11)		AUTO_INCREMENT PRIMARY KEY,
blog_category_id			INT(11)		NOT NULL DEFAULT 0,
status					INT(11)		NOT NULL,
user_id					INT(11)		NOT NULL,		
stamp					TIMESTAMP(10)	NOT NULL,
heading					VARCHAR(64)	NOT NULL,
body					TEXT);

CREATE TABLE				tag(
id     					INT(11)		AUTO_INCREMENT PRIMARY KEY,
tag					VARCHAR(128)	NOT NULL);

CREATE TABLE				blog_tag(
blog_id     				INT(11)		NOT NULL,
tag_id					INT(11)		NOT NULL,
PRIMARY KEY(blog_id, tag_id));

CREATE TABLE				blog_image(
id     					INT(11)		AUTO_INCREMENT PRIMARY KEY,
blog_id					INT(11)		NOT NULL,
filename     				VARCHAR(64)	NOT NULL);


CREATE TABLE  				blog_comment(
id     					INT(11)		AUTO_INCREMENT PRIMARY KEY,
blog_id					INT(11)		NOT NULL,
user_id					INT(11)		NOT NULL,
status					INT(11)		NOT NULL,		
stamp					TIMESTAMP(10)	NOT NULL,
heading					VARCHAR(64)	NULL,
body					TEXT);


CREATE TABLE  				blog_category(
id     					INT(11)		AUTO_INCREMENT PRIMARY KEY,
blog_category_id			INT(11)		NOT NULL DEFAULT 0,
label					VARCHAR(64)	NOT NULL);

