<h1>全ツイート一覧</h1>

<?php
foreach ($data as $datum) {?>
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

    <div>
        <a href="<?= url('/detail'); ?>/<?= $datum['id'] ?>">ツイート詳細表示へ</a>
    </div>
    <br>
<?php
}
?>