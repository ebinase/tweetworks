<?php

namespace Database\migration;

use App\System\Classes\CreateTable;

class CreateTweetsTable extends CreateTable
{
    public static function getCreateQuery(): string
    {
        return <<< EOF
create table tweets
(
	id int(10) auto_increment,
	user_id int(10) not null,
	text varchar(140) not null,
	reply_to_id int(10) null,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	constraint tweets_pk
		primary key (id)
);
EOF;
    }
}