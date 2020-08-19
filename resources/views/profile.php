<h1>ユーザーページ</h1>
<div>
    <h2><?=$user['name'];?></h2>
    <p>@<?=$user['unique_name'];?></p>
</div>

<div>
    <?php foreach ($tweets as $tweet) {?>
        <div style="border: #6e6e6e solid 1px; width: 30%; margin-bottom:2px; padding: 6px">
            <div><?=$user['name'];?> <span style="color: #6e6e6e">@<?=$user['unique_name'];?></span></div>
            <div><?=$tweet['text'];?></div>
        </div>
    <?php } ?>
</div>

<ul>
    <li><a href="<?= url('/home'); ?>">タイムライン</a></li>
    <li><a href="<?= url('/logout'); ?>">ログアウト</a></li>
</ul>