<?php

function auth():bool {
    return \App\System\Classes\Facades\Auth::check();
}