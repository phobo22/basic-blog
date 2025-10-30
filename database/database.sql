create database blogdb;
use blogdb;

create table users (
	id int primary key auto_increment,
	username varchar(20) unique not null,
    pwd varchar(255) not null,
    email varchar(30) unique not null,
    created datetime not null
);

create table password_reset (
  id int primary key auto_increment,
  user_id int not null,
  token_hash char(64) not null,
  expires_at datetime not null,
  used tinyint default 0,
  created_at datetime default CURRENT_TIMESTAMP,
  foreign key (user_id) references users (id)
);

create table tasks (
	id int primary key auto_increment,
    user_id int not null,
    title varchar(50) not null,
    descriptions varchar(100) not null,
    start_date date not null,
    end_date date not null,
    foreign key (user_id) references users (id)
);

create table articles (
	id int primary key auto_increment,
    user_id int not null,
    posted_at datetime default CURRENT_TIMESTAMP,
    text_content varchar(10000),
    file_name varchar(30),
    foreign key (user_id) references users (id)
);

create table comments (
	id int primary key auto_increment,
    article_id int not null, 
    user_id int not null,
    commented_at datetime default CURRENT_TIMESTAMP not null,
    content varchar(1000),
    foreign key (article_id) references articles (id) on delete cascade,
    foreign key (user_id) references users (id)
);

create table likes (
	article_id int,
    user_id int,
    primary key (article_id, user_id),
    foreign key (article_id) references articles (id) on delete cascade,
    foreign key (user_id) references users (id)
);