<?php

namespace myClss;
class Validator
{
    private array $errors = [];
    private array $rules_list = [
        'required',
        'min',
        'max',
        'string',
        'number',
        'hasCap',
        'hasUncap',
        'hasNum',
        'unique',
        'image',
        'size',
    ];
    private array $errors_list = [
        'required' => 'Поле является обязательным',
        'min' => 'Поле должно быть не менее :number: символов',
        'max' => 'Поле должно быть не более :number: символов',
        'string' => 'Поле должно быть строкой',
        'number' => 'Поле должно быть числом',
        'hasCap' => 'Поле должно иметь хотя бы 1 заглавную букву',
        'hasUncap' => 'Поле должно иметь хотя бы 1 строчную букву',
        'hasNum' => 'Поле должно иметь хотя бы 1 цифру',
        'unique' => 'Пользователь с таким значением поля уже есть',
        'image' => 'Файл неверного формата',
        'size' => 'Файл слишком большой',
    ];

    public function validate(array $data, array $rules): static
    {
        foreach ($data as $key => $item) {
            if (in_array($key, array_keys($rules))) {
                $this->check($key, $item, $rules[$key]);
            }
        }
        return $this;
    }

    private function check(string $key, mixed $data, array $rules): void
    {
        foreach ($rules as $rule) {
            if (str_contains($rule, ":")) {
                $rule = explode(":", $rule);
                $this->checkRule($key, $data, $rule[0], $rule[1]);
            } else {
                $this->checkRule($key, $data, $rule);
            }
        }
    }

    private function checkRule(string $key, mixed $data, string $rule, $param = null): void
    {
        if (in_array($rule, $this->rules_list)) {
            if (!$this->$rule($key, $data, $param)) {
                $this->addError($key, $rule, $param);
            }
        }
    }

    private function addError(string $key, string $rule, string $param = null): void
    {
        $this->errors[$key][] = str_replace(":number:", $param, $this->errors_list[$rule]);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function required($key, $data, $param): bool
    {
        return !empty($data);
    }

    private function min($key, $data, $param): bool
    {
        return mb_strlen($data, 'UTF-8') >= $param;
    }

    private function max($key, $data, $param): bool
    {
        return mb_strlen($data, 'UTF-8') <= $param;
    }

    private function number($key, $data, $param): bool
    {
        return is_numeric($data);
    }

    private function string($key, $data, $param): bool
    {
        return is_string($data);
    }

    private function hasCap($key, $data, $param): bool
    {
        preg_match('/[A-Z]+/', $data, $matches);
        return $matches != [];
    }

    private function hasUncap($key, $data, $param): bool
    {
        preg_match('/[a-z]+/', $data, $matches);
        return $matches != [];
    }

    private function hasNum($key, $data, $param): bool
    {
        preg_match('/\d+/', $data, $matches);
        return $matches != [];
    }

    private function unique($key, $data, $param): bool
    {
        /**
         * @var Db $db
         */
        $db = db();
        $res = $db->rawSql("SELECT * FROM $param WHERE $key = ?", [$data])->findAll();
        return $res == [];
    }

    private function image($key, $data, $param): bool
    {
        $types = explode('|', $param);
        $types = array_map(fn ($value) => $value = 'image/' . $value, $types);
        return in_array($data['type'], $types);
    }

    private function size($key, $data, $param): bool
    {
        return $data['size'] <= $param * 1024 * 1024;
    }
}