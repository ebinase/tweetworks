<?php


namespace Database\migration;


use App\System\CreateTable;

class CreateFavoritesTable extends CreateTable
{
    public static function getQuerySentence(): string
    {
        return <<< EOF

create table tweets
(
    user_id int(10) not null,
    tweet_id int(10) not null,
    updated_at TIMESTAMP not null
);
EOF;
    }
}