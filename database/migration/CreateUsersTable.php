<?php


namespace Database\migration;


use App\System\CreateTable;

class CreateUsersTable extends CreateTable
{
    public static function getQuerySentence(): string
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
	created_at TIMESTAMP not null,
	updated_at TIMESTAMP,
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