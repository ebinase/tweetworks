<style>
    .btn-follow {
        background-color: white;
        color: #00acee;
        border: #00acee 1px solid;
        border-radius: 20px;
</style>

<a href="<?=prevUrl()?>" class="back">←戻る</a>
<div class="container">
    <h2><?=$title?></h2>
    <?php foreach ($users as $user) { ?>
        <div style="border: #6e6e6e 1px solid">
            <div style="display: flex">
                <div><?=$user['name'];?>@<?=$user['unique_name'];?></div>
                <div><button class="btn-follow">フォロー</button></div>
            </div>
            <div>
                bioooooooooooooooooooooooooooooo
            </div>
        </div>
    <?php } ?>
</div>
