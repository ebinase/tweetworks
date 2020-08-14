<?php


namespace Database\migration;


use App\System\CreateTable;

class CreateFollowsTable extends CreateTable
{
    public static function getCreateQuery(): string
    {
        return <<< EOF
create table follows
(
	user_id int(10) not null,
	user_followed_id int(10) not null,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
EOF;
    }
}