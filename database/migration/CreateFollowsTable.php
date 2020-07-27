<?php


namespace Database\migration;


use App\System\CreateTable;

class CreateFollowsTable extends CreateTable
{
    public static function getQuerySentence(): string
    {
        return <<< EOF
create table follows
(
	following_id int(10) not null,
	followed_id int(10) not null,
	created_at TIMESTAMP not null
);
EOF;
    }
}