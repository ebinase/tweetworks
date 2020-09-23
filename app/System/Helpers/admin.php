<?php

function admin(): bool {
    return \App\System\Classes\Facades\Admin::check();
}