create database blogdb;
use blogdb;

create table users (
	id INT primary key auto_increment not null,
	username varchar(20) unique not null,
    pwd varchar(255) not null,
    email varchar(30) unique not null,
    created datetime not null
);