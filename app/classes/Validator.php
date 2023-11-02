<?php

class Validator
{
    private array $errors = [];
    private array $rules_list = [
        'required',
        'min',
        'max',
        'string',
        'number',
    ];
    private array $errors_list = [
        'required' => 'Поле является обязательным',
        'min' => 'Поле должно быть не менее :number: символов',
        'max' => 'Поле должно быть не более :number: символов',
        'string' => 'Поле должно быть строкой',
        'number' => 'Поле должно быть числом',
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

    private function checkRule(string $key, mixed $data, string $rule, int $n = null): void
    {
        if (in_array($rule, $this->rules_list)) {
            if (!$this->$rule($data, $n)) {
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

    private function required($data, $n): bool
    {
        return !empty(trim($data));
    }

    private function min($data, $n): bool
    {
        return mb_strlen($data, 'UTF-8') >= $n;
    }

    private function max($data, $n): bool
    {
        return mb_strlen($data, 'UTF-8') <= $n;
    }

    private function number($data, $n): bool
    {
        return is_numeric($data);
    }

    private function string($data, $n): bool
    {
        return is_string($data);
    }
}