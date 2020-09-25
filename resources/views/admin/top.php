<?php $this->setLayoutVar('page_title', '管理画面トップ');?>

<div class="container">
    <h2>データベース</h2>
    <ul>
        <li><a href="<?= url('/admin/database') ?>">マイグレーション</a></li>
        <li><a href="<?= url('/admin/database/refresh') ?>">リフレッシュ</a></li>
        <li><a href="<?= url('/admin/database/seed') ?>">シーディング</a></li>
        <li><a href="<?= url('/admin/database/refresh-seed') ?>">リフレッシュ&シーディング</a></li>
    </ul>
</div>