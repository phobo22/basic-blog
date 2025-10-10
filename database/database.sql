create database blogdb;
use blogdb;

create table users (
	id INT primary key auto_increment not null,
	username varchar(20) unique not null,
    pwd varchar(255) not null,
    email varchar(30) unique not null,
    created datetime not null
);

create table password_reset (
    id INT primary key auto_increment,
    user_id INT not null,
    token_hash char(64) not null,
    expires_at datetime not null,
    used TINYINT default 0,
    created_at datetime default CURRENT_TIMESTAMP,
    foreign key (user_id) references users (id)
);