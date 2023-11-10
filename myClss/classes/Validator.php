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

    private function checkRule(string $key, mixed $data, string $rule, $n = null): void
    {
        if (in_array($rule, $this->rules_list)) {
            if (!$this->$rule($key, $data, $n)) {
                $this->addError($key, $rule, $n);
            }
        }
    }

    private function addError(string $key, string $rule, string $n = null): void
    {
        $this->errors[$key][] = str_replace(":number:", $n, $this->errors_list[$rule]);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function required($key, $data, $n): bool
    {
        return !empty($data);
    }

    private function min($key, $data, $n): bool
    {
        return mb_strlen($data, 'UTF-8') >= $n;
    }

    private function max($key, $data, $n): bool
    {
        return mb_strlen($data, 'UTF-8') <= $n;
    }

    private function number($key, $data, $n): bool
    {
        return is_numeric($data);
    }

    private function string($key, $data, $n): bool
    {
        return is_string($data);
    }

    private function hasCap($key, $data, $n): bool
    {
        preg_match('/[A-Z]+/', $data, $matches);
        return $matches != [];
    }

    private function hasUncap($key, $data, $n): bool
    {
        preg_match('/[a-z]+/', $data, $matches);
        return $matches != [];
    }

    private function hasNum($key, $data, $n): bool
    {
        preg_match('/\d+/', $data, $matches);
        return $matches != [];
    }

    private function unique($key, $data, $n): bool
    {
        /**
         * @var Db $db
         */
        $db = db();
        $res = $db->rawSql("SELECT * FROM $n WHERE $key = ?", [$data])->findAll();
        return $res == [];
    }
}