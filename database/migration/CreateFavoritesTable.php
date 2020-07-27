<?php


namespace Database\migration;


use App\System\CreateTable;

class CreateFavoritesTable extends CreateTable
{
    public static function getQuerySentence(): string
    {
        return <<< EOF

create table favorites
(
    user_id int(10) not null,
    tweet_id int(10) not null,
    created_at TIMESTAMP not null
);
EOF;
    }
}