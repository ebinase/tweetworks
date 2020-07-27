<?php


namespace Database\migration;


use App\System\CreateTable;

class CreateRepliesTable extends CreateTable
{
    public static function getQuerySentence(): string
    {
        return <<< EOF
create table replies
(
	tweet_id int(10) not null,
	reply_to_id int(10) not null,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
EOF;
    }
}
