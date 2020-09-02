<?php
$this->setLayoutVar('page_title', 'WORLD');
echo $this->render('components/tweet_index', [
    'tweets' => $data,
    '_token' => $_token
]);
?>

<div class="text-center w-100 border-top">
    <p>最大<?=$paginate['tweets_per_page'];?>件を表示中</p>
    <?= \App\System\Classes\Facades\Paginate::renderPageList($paginate)?>
    <p><?=$paginate['page'];?>ページ目</p>
</div>