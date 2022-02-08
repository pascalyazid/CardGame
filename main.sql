create table Card (
card_id serial,
cardname varchar(255) not null,
api_id varchar(255) not null,
imageURL varchar(255) not null

primary key(card_id)
);

create table User (
user_id serial,
username varchar(255) not null,
password varchar(16) not null,
email varchar(255) not null,

card_id bigint unsigned not null,

primary key (user_id)
foreign key(card_id) references Card(card_id) on update cascade on delete cascade
);



create table Card_User (
card_user_id serial,
card_id bigint unsigned not null,
user_id bigint unsigned not null,

primary key(card_user_id),
foreign key(card_id) references Card(card_id) on update cascade on delete cascade,
foreign key(user_id) references User(user_id) on update cascade on delete cascade

)
