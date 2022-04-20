/*
*
Hengyi Li
Version: 0.2.0
A sql file to create tables.
*/

use hl3265;

drop table if exists part, word;
create table part
(
	id int unsigned not null auto_increment,
	part varchar(255) not null,
	primary key(id)
);

create table word
(
	id int unsigned not null auto_increment,
	word varchar(255) not null,
	part_id int unsigned not null,
	definition varchar(255) not null,
	primary key(id),
	constraint part_fk foreign key(part_id) references part(id)
);


