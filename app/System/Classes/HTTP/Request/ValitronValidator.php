<?php

namespace App\System\Classes\HTTP\Request;

use Valitron\Validator;

//valitronのラッピングクラス
//使用しない
class ValitronValidator extends BaseValidator
{

    /**
     *
     */
    public function validate()
    {
        //laravel風定義からvalitronの形式へ変換
        $compiledRules = $this->compileRules($this->_rules);

        $v = $this->bootValitron($this->_request->getAllPost());

        $default = '{field}にエラーがあります。';
        foreach ($compiledRules as $format => $fields) {
            //requiredなどに対するエラーメッセージが設定されていたらそのメッセージを設定
            $message = $this->_messages[$format] ?? $default;
            // ルールを定義
            // 例：rule('required', ['name', 'email', 'password'])
            $v->rule($format, $fields)->message($message);
        }

        $v->labels($this->_labels);

        return $v->validate();
    }

    /**
     * 定義配列の形式を変換する
     *
     * laravel風の形式(名前 => 条件)
     * ['email' => ['required', 'email'] ]
     * ...
     * ⬇
     * valitronの形式(条件 => 名前)
     * ['required' => ['email', ...] ],
     * ['email' => ['email', ...] ]
     *
     * @param $rules
     * @return array
     */
    private function compileRules($rules)
    {
        $compiledRules = [];
        foreach ($rules as $field => $formats) {
            foreach ($formats as $format) {
                $compiledRules[$format][] = $field;
            }
        }
        return $compiledRules;
    }

    private function bootValitron($post)
    {
        Validator::lang('ja');
        return new Validator($post);
    }
}