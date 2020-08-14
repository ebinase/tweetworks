<h1>ユーザーページ</h1>
<div>
    <h2><?=$user['name'];?></h2>
    <p>@<?=$user['unique_name'];?></p>
</div>

<form action="<?=$_url['/follow/:user_id'];?>" method="post" onsubmit="return check()">
<!--   hiddenぱラーメーた（事前に埋め込む）にuser_idを送ってあげる　Controller側ではuser_idがフォローされる側で、セッションからのがfollowing_idってわかる/-->
<!--    user_idをhiddenするためにはUserContrlooer編集（すでにuser＿idは埋め込んである-->
    <input type="hidden" name="unique_name" value="<?= $this->escape($unique_name);?>">

    <input type="submit" value="フォローする">
</form>


<div>
    <?php foreach ($tweets as $tweet) {?>
        <div style="border: #6e6e6e solid 1px; width: 30%; margin-bottom:2px; padding: 6px">
            <div><?=$user['name'];?> <span style="color: #6e6e6e">@<?=$user['unique_name'];?></span></div>
            <div><?=$tweet['text'];?></div>
        </div>
    <?php } ?>
</div>

<ul>
    <li><a href="<?=$_url['/home'];?>">タイムライン</a></li>
    <li><a href="<?=$_url['/logout'];?>">ログアウト</a></li>
</ul>