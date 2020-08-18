<?php

function redirect($url) :\App\System\Interfaces\HTTP\ResponseInterface  {
    return \App\System\Classes\Facades\Route::redirect($url);
}
