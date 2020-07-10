<?php

namespace App\Interfaces;

interface ControllerInterface
{
    function __construct(ApplicationInterface $application);

    //todo: 返り値がstringでいいのかチェック($contentの中身はHTML)
    function run(string $action_name, array $params): string;
    //Viewクラスを呼び出して$contentを返してもらう
    function render(array $variables, $template, $layoute): string;
}