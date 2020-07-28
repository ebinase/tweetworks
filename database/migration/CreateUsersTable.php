<?php


namespace Database\migration;


use App\System\CreateTable;

class CreateUsersTable extends CreateTable
{
    public static function getCreateQuery(): string
    {
        return <<< EOF
    create table users
(
	id int(10) auto_increment,
	name varchar(30) not null,
	email varchar(256) not null,
	unique_name varchar(30) not null,
	password varchar(256) not null,
	token char(16) not null,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	constraint users_pk
		primary key (id)
);

create unique index users_email_uindex
	on users (email);

create unique index users_token_uindex
	on users (token);

create unique index users_unique_name_uindex
	on users (unique_name);
EOF;
    }
}