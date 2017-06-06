create table testdb.coupon
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
	name varchar(64) default '' not null,
	`desc` varchar(256) default '' not null,
	min_amount float default '0' not null,
	offer_amount float default '0' not null,
	valid tinyint(1) default '1' not null,
	dead_time datetime default CURRENT_TIMESTAMP not null,
	used_count int default '0' not null,
	used_time datetime default CURRENT_TIMESTAMP not null,
	constraint coupon_id_uindex
		unique (id)
)
;

create table testdb.coupon_template
(
	id char(36) not null
		primary key,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	class int default '0' not null,
	kind int default '0' not null,
	name varchar(64) default '' not null,
	`desc` varchar(256) default '' not null,
	min_amount float default '0' not null,
	offer_amount float default '0' not null,
	valid tinyint(1) default '1' not null,
	dead_time datetime default CURRENT_TIMESTAMP not null,
	constraint coupon_template_id_uindex
		unique (id)
)
;

create table testdb.test
(
	id char(36) null,
	name varchar(16) default '' not null,
	email varchar(32) default '' not null,
	post_time datetime default CURRENT_TIMESTAMP not null,
	put_time datetime default CURRENT_TIMESTAMP not null,
	constraint test_id_uindex
		unique (id)
)
;

