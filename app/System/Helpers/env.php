<?php

function env($name) {
    return \App\System\Classes\Services\Env::get($name);
}