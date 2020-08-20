<?php
function userInfo($key) {
    return \App\System\Classes\Facades\Auth::info($key);
}