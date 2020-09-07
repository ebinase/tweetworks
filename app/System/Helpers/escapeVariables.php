<?php
/**
 * 配列(多次元やネストしたものを含む)のすべての要素をエスケープ
 *
 * @param array | string $variables
 * @return array | string $escaped_variables
 */
function escapeVariables($variables)
{
    if (is_array($variables)) {
        foreach ($variables as $key => $value) {
            if (is_array($value)) {
                $variables[$key] = escapeVariables($value);
            }else {
                $variables[$key] = escape($value);
            }
        }
    } else {
        $variables = escape($variables);
    }

    return $variables;
}

function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}