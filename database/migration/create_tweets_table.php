<?php
function createTweetsTable() {
    $sql = <<< EOF
create table tweets
(
	id int(10) auto_increment,
	user_id int(10) null,
	text varchar(140) not null,
	created_at timestamp not null,
	constraint tweets_pk
		primary key (id)
);
EOF;

}