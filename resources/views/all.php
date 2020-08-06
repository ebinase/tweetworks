<h1>全ツイート一覧</h1>

<?php
foreach ($data as $datum)
{
?>
<table>
<tr>
    <th>id</th><td><?= $datum['id'] ?></td>
</tr>
<tr>
    <th>user_id</th><td><?= $datum['user_id'] ?></td>
</tr>
<tr>
    <th>ツイート内容</th><td><?= $datum['text'] ?></td>
</tr>
<tr>
    <th>日時</th><td><?= $datum['created_at'] ?></td>
</tr>
</table>

<?php

    $tweet_id = $datum['id'] ;
    var_dump($tweet_id);
  ?>

    <div>
<!--        <a href="./detail/--><?//= $tweet_id ?><!--">ツイート詳細表示へ</a>-->
<!--        <a href="./detail/--><?//= $tweet_id ?><!--">ツイート詳細表示へ</a>-->
        <a href="./detail/1">ツイート詳細表示へ</a>


    </div>
    <br>

<?php
}
?>