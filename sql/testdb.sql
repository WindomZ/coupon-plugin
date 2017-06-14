DROP SCHEMA IF EXISTS testdb;

CREATE SCHEMA testdb;

create table testdb.cp_activity
(
	id char(36) not null
		primary key,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	name varchar(64) default '' not null,
	note varchar(512) default '' not null,
	url varchar(256) default '' not null,
	class int default '0' not null,
	kind int default '0' not null,
	coupon_size int default '0' not null,
	coupon_used int default '0' not null,
	coupon_limit int default '0' not null,
	level int default '0' not null,
	valid tinyint(1) default '1' not null,
	dead_time datetime default CURRENT_TIMESTAMP not null,
	constraint activity_id_uindex
		unique (id)
)
;

create table testdb.cp_coupon
(
	id char(36) not null
		primary key,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	owner_id char(36) not null,
	activity_id char(36) not null,
	template_id char(36) not null,
	class int default '0' not null,
	kind int default '0' not null,
	product_id varchar(36) default '' not null,
	name varchar(64) default '' not null,
	`desc` varchar(256) default '' not null,
	min_amount decimal(10,2) default '0.00' not null,
	offer_amount decimal(10,2) default '0.00' not null,
	valid tinyint(1) default '1' not null,
	dead_time datetime default CURRENT_TIMESTAMP not null,
	used_count int default '0' not null,
	used_time datetime default CURRENT_TIMESTAMP not null,
	constraint coupon_id_uindex
		unique (id)
)
;

create table testdb.cp_coupon_template
(
	id char(36) not null
		primary key,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	class int default '0' not null,
	kind int default '0' not null,
	product_id varchar(36) default '' not null,
	name varchar(64) default '' not null,
	`desc` varchar(256) default '' not null,
	min_amount decimal(10,2) default '0.00' not null,
	offer_amount decimal(10,2) default '0.00' not null,
	valid tinyint(1) default '1' not null,
	constraint coupon_template_id_uindex
		unique (id)
)
;

create table testdb.cp_pack
(
	id char(36) not null
		primary key,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	name varchar(64) default '' not null,
	activity_id char(36) not null,
	template_id char(36) not null,
	level int default '0' not null,
	valid tinyint(1) default '1' not null,
	dead_time datetime default CURRENT_TIMESTAMP not null,
	constraint cp_pack_id_uindex
		unique (id)
)
;

create table testdb.cp_test
(
	id char(36) not null
		primary key,
	name varchar(16) default '' not null,
	email varchar(32) default '' not null,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	constraint test_id_uindex
		unique (id)
)
;

