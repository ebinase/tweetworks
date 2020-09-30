<?php $this->setLayoutVar('page_title', $title);?>

<style>
    .js-btn-follow {
        background-color: white;
        color: #00acee;
        border: #00acee 1px solid;
        border-radius: 20px;
</style>

<a href="<?=prevUrl()?>" class="back">←戻る</a>
<div class="container">
    <?php foreach ($users as $user) { ?>
        <div style="border: #6e6e6e 1px solid">
            <div style="display: flex">
                <div>
                    <a href="<?=url('/user/').$user['unique_name'];?>">
                        <?=$user['name'];?>@<?=$user['unique_name'];?>
                    </a>
                </div>
                <div>
                    <button class="js-btn-follow" type="button"
                             data-follow-id="<?=$user['id']?>"
                             data-address="<?=url('/follow/update');?>">
                        フォロー
                    </button>
                </div>
            </div>
            <div>
                bioooooooooooooooooooooooooooooo
            </div>
        </div>
    <?php } ?>
</div>