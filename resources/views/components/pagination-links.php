<style>
    .pgn-container {
        display: flex;
        justify-content: center;

    }

    .pgn-item {
        border: #6e6e6e 1px solid;
        display: flex;
        justify-content: center;
        align-content: center;
        width: 2rem;
        height: 2rem;
    }

    .pgn-active {
        background-color: #00acee;
        color: white;
    }
</style>

<div class="pgn-container ">
    <?php if ($prev_btn) {?>
        <div class="pgn-move-btn pgn-item">
            <a href="<?=currentUrl() . '?page=' . ($current - 1);?>">
                <i class="fas fa-angle-left"></i>
            </a>
        </div>
    <?php } ?>

    <?php if ($skip_back) {?>
        <div class="pgn-skip pgn-item">
            <a href="<?=currentUrl() . '?page=' . $first;?>">
                <?=$first?>
            </a>
        </div>
        <div class="pgn-item">...</div>
    <?php } ?>

    <?php for ($i = $start; $i <= $end; $i++) {
        $pgn_active = ($i == $current) ? 'pgn-active' : '';
        ?>
        <div class="pgn-item <?= $pgn_active ?>">
            <a href="<?=currentUrl() . '?page=' . $i;?>">
                <?=$i?>
            </a>
        </div>
    <?php } ?>

    <?php if ($skip_forth) {?>
        <div class="pgn-item">...</div>
        <div class="pgn-skip pgn-item">
            <a href="<?=currentUrl() . '?page=' . $last;?>">
                <?=$last?>
            </a>
        </div>
    <?php } ?>

    <?php if ($next_btn) {?>
        <div class="pgn-move-button pgn-item">
            <a href="<?=currentUrl() . '?page=' . ($current + 1);?>">
                <i class="fas fa-angle-right"></i>
            </a>
        </div>
    <?php } ?>
</div>