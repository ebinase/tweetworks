<style>
    .pgn-container {
        display: flex;
        justify-content: center;

    }

    .pgn-item {
        border: #6e6e6e 1px solid;
        width: 2rem;
        height: 2rem;
    }

    .pgn-item > a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .pgn-item > a:hover {
        background-color: #cff0ff;
    }

    .pgn-text {
        display: inline-block;
        margin-top: 0.4rem;
        line-height: 1rem;

    }

    /*アクティブなページ番号につけるクラス*/
    .pgn-active {
        background-color: #3bb3e0;
        color: white;
        font-weight: bold;
    }

</style>

<div class="pgn-container ">
    <?php if ($prev_btn) {?>
        <div class="pgn-item">
            <a href="<?=currentUrl() . '?page=' . ($current - 1);?>">
                <i class="fas fa-angle-left pgn-text"></i>
            </a>
        </div>
    <?php } ?>

    <?php if ($skip_back) {?>
        <div class="pgn-skip pgn-item">
            <a href="<?=currentUrl() . '?page=' . $first;?>">
                <span class="pgn-text"><?=$first?></span>
            </a>
        </div>
        <div class="pgn-item">
            <span class="pgn-text">...</span>
        </div>
    <?php } ?>

    <?php for ($i = $start; $i <= $end; $i++) {
        $pgn_active = ($i == $current) ? 'pgn-active' : '';
        ?>
        <div class="pgn-item <?= $pgn_active ?>">
            <a href="<?=currentUrl() . '?page=' . $i;?>">
                <span class="pgn-text"><?=$i?></span>
            </a>
        </div>
    <?php } ?>

    <?php if ($skip_forth) {?>
        <div class="pgn-item">...</div>
        <div class="pgn-skip pgn-item">
            <a href="<?=currentUrl() . '?page=' . $last;?>">
                <span class="pgn-text"><?=$last?></span>
            </a>
        </div>
    <?php } ?>

    <?php if ($next_btn) {?>
        <div class="pgn-item">
            <a href="<?=currentUrl() . '?page=' . ($current + 1);?>">
                <i class="fas fa-angle-right pgn-text"></i>
            </a>
        </div>
    <?php } ?>
</div>