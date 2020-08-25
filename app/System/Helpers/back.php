<?php

function back($default = '/') :\App\System\Interfaces\HTTP\ResponseInterface {
    return \App\System\Classes\Facades\Route::back($default);
}