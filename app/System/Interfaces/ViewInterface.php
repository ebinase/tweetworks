<?php


namespace App\System\Interfaces;

interface ViewInterface
{
    //Input---------------------------------------------------------------
    public function __construct(string $base_dir, array $defaults = []);

    public function registerDefaults($variables);

    //Output--------------------------------------------------------------
    //関数内で配列の変数展開を行うため重複防止で変数名にアンダーバーを付与
    public function render(string $_path, $_layout_path = false): string;
}