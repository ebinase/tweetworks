<?php


namespace App\System\Interfaces;

interface ViewInterface
{
    //Input---------------------------------------------------------------
    function __construct(string $base_dir, array $defaults = []);

    //Output--------------------------------------------------------------
    //関数内で配列の変数展開を行うため重複防止で変数名にアンダーバーを付与
    function render(string $_path, $_variables = [], $_layout_path = false): string;
}