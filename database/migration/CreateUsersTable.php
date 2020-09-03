<?php


namespace Database\migration;


use App\System\Classes\CreateTable;

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
	bio varchar(160) null,
	password varchar(256) not null,
	remenber_token char(16) DEFAULT null,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	constraint users_pk
		primary key (id)
);

create unique index users_email_uindex
	on users (email);

create unique index users_token_uindex
	on users (remenber_token);

create unique index users_unique_name_uindex
	on users (unique_name);
EOF;
    }
}