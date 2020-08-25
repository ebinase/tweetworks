<?php


namespace Database\migration;


use App\System\Classes\CreateTable;

class CreateFavoritesTable extends CreateTable
{
    public static function getCreateQuery(): string
    {
        return <<< EOF
create table favorites
(
    user_id int(10) not null,
    tweet_id int(10) not null,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
EOF;
    }
}