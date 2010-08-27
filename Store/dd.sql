

CREATE TABLE 		brand(
id			INT(11)					AUTO_INCREMENT PRIMARY KEY,
name			VARCHAR(128)				NULL,
about			TEXT					NULL);



CREATE TABLE 	product(
id		INT(11)					NOT NULL AUTO_INCREMENT PRIMARY KEY,
category_id	INT(11)					NOT NULL DEFAULT 1,
brand_id	INT(11)					NOT NULL,
name		VARCHAR(128)				NOT NULL,
description	TEXT					NULL,
image		VARCHAR(64)				NULL,
upc		VARCHAR(32)				NULL,
sold_in_store   TINYINT(1)				NOT NULL DEFAULT 0);

CREATE TABLE 	category(
id		INT(11)					NOT NULL AUTO_INCREMENT PRIMARY KEY,
category_id	INT(11)					NOT NULL DEFAULT 0,
hidden		TINYINT(1)				NOT NULL DEFAULT 0,
name		VARCHAR(128)				NOT NULL,
shipping	DECIMAL(6,2)				NULL,
intl_shipping   DECIMAL(6,2)				NULL);

CREATE TABLE 	property(
id		INT(11)					NOT NULL AUTO_INCREMENT PRIMARY KEY,
name		VARCHAR(128)				NOT NULL);

CREATE TABLE	property_option(
id		INT(11)					NOT NULL AUTO_INCREMENT PRIMARY KEY,
property_id	INT(11)					NOT NULL,
option_val	VARCHAR(128)				NOT NULL);

CREATE TABLE	product_variant_property_option(			
id			INT(11)					NOT NULL AUTO_INCREMENT PRIMARY KEY,
product_variant_id	INT(11)					NOT NULL,
property_option_id		INT(11)					NOT NULL);

CREATE TABLE	product_variant(
id		INT(11)					NOT NULL AUTO_INCREMENT PRIMARY KEY,
product_id	INT(11)					NOT NULL,
image		VARCHAR(64)				NULL,
sku		VARCHAR(32)				NULL,
weight_g	INT					NOT NULL DEFAULT 0,
weight_lb	DECIMAL(6,2)				NOT NULL DEFAULT '0.00',
weight_oz	DECIMAL(6,2)				NOT NULL DEFAULT '0.00',
price		DECIMAL(6,2)				NOT NULL DEFAULT '0.00');


CREATE TABLE 	category_property(
id		INT(11)					NOT NULL AUTO_INCREMENT PRIMARY KEY,
category_id	INT(11)					NOT NULL,
property_id	INT(11)					NOT NULL);


CREATE TABLE 		promo(
id			INT(11)					AUTO_INCREMENT PRIMARY KEY,
category_id		INT(11)					NOT NULL,
name			VARCHAR(128)				NULL,
alt			VARCHAR(128)				NULL,
url			VARCHAR(128)				NULL,
image			VARCHAR(128)				NULL,
hidden			BINARY(1)				NOT NULL DEFAULT 0);


CREATE TABLE 		bbc_order(
id			INT(11)					AUTO_INCREMENT PRIMARY KEY,
user_id			INT(11)					NOT NULL,
status			TINYINT(1)				NOT NULL DEFAULT 1,
stamp			TIMESTAMP(10)				NOT NULL,
first_name		VARCHAR(128)				NULL,
last_name		VARCHAR(128)				NULL,
address1		VARCHAR(128)				NULL,
address2		VARCHAR(128)				NULL,
city			VARCHAR(128)				NULL,
state			VARCHAR(128)				NULL,
zip			VARCHAR(128)				NULL,
country			VARCHAR(128)				NULL,
shipping		DECIMAL(6,2)				NULL);
	

CREATE TABLE		line_item(
id     			INT(11)					AUTO_INCREMENT PRIMARY KEY,
order_id		INT(11)					NOT NULL,
variant_id		INT(11)					NOT NULL,
price			DECIMAL(6,2)				NOT NULL DEFAULT '0.00',
quantity		INT(11)					NOT NULL);

CREATE TABLE 		order_status(
id			INT(11)					AUTO_INCREMENT PRIMARY KEY,
status			VARCHAR(128)				NULL);	

CREATE TABLE		shipping_address(
id     			INT(11)					AUTO_INCREMENT PRIMARY KEY,
user_id			INT(11)					NOT NULL,
first_name		VARCHAR(128)				NULL,
last_name		VARCHAR(128)				NULL,
address1		VARCHAR(128)				NULL,
address2		VARCHAR(128)				NULL,
city			VARCHAR(128)				NULL,
state			VARCHAR(128)				NULL,
zip			VARCHAR(128)				NULL,
country			VARCHAR(128)				NULL);

CREATE TABLE 		product_colour(
id			INT(11)					AUTO_INCREMENT PRIMARY KEY,
product_id		INT(11)					NOT NULL,
property_option_id	INT(11)					NOT NULL,
image			VARCHAR(128)				NULL);	

