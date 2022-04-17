create table part 
(
	id int unsigned not null auto_increment,
	part varchar(255) not null,
	primary key(id)
)

create table word 
(
	id int unsigned not null auto_increment,
	word varchar(255) not null,
	part_id int unsigned not null,
	definition varchar(255) not null,
	primary key(id),
	constraint part_fk foreign key(part_id) references part(id)
);

