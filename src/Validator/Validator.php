<?php

namespace Src\Validator;

class Validator
{

    private const STRING = 'Поле должно быть строкой';
    private const NUMBER = 'Поле должно быть числом';
    private const REQUIRED='Поле обязательно для заполнения';
    private const LENGTH = 'В поле должно быть не менее';
    private const LETTER = 'В поле должно быть не менее 1 прописной буквы';
    private const CAP_LETTER = 'В поле должно быть не менее 1 заглавной буквы';
    private const HAS_NUMBER = 'В поле должно быть не менее 1 цифры';
    private const AT_LEAST_ONE = 'Хотя бы 1 поле должно быть заполнено';
    public static function validate (array $data, array $rules) : array
    {
        $res = [];
        $errors = [];
        foreach ($data as $key => $value)
        {
            foreach ($rules[$key] as $param)
            {
                if (strpos($param, ":"))
                {
                    $val = explode(':', $param);
                    $method = $val[0];
                    $result = self::$method($value, $val[1]);
                }
                else
                {
                    $result = self::$param($value);
                }
                if($result !== true)
                {
                    $errors[] = $result;
                }
            }
            if ($errors != [])
            {
                $res[$key] = $errors;
            }
            $errors = [];
        }

        if (count($res) != 0 )
        {
            return $res;
        }
        else
        {
            return [];
        }
    }

    public static function atLeastOne(array $data) : bool|string
    {
        foreach ($data[0] as $item)
        {
            if ($item != '')
            {
                return true;
            }
        }
        return self::AT_LEAST_ONE;
    }
    private static function length($data, $len): bool|string
    {
        return strlen($data) == $len ? true : self::LENGTH . ' ' . $len . ' символов';

    }

    private static function string($data): bool|string
    {
        return is_string($data) ? true : self::STRING;
    }

    private static function required($data): bool|string
    {
        return $data != '' ? true : self::REQUIRED;
    }
    private static function number($data): bool|string
    {
        return is_int($data) ? true : self::NUMBER;
    }

    private static function letter($data):  bool|string
    {

        preg_match('/[a-z]+/', $data, $matches);
        return $matches != [] ? true : self::LETTER;
    }
    private static function capLetter($data):  bool|string
    {
        preg_match('/[A-Z]+/', $data, $matches);
        return $matches != [] ? true : self::CAP_LETTER;
    }
    private static function hasNumber($data): bool|string
    {
        preg_match('/\d+/', $data, $matches);
        return $matches != [] ? true : self::HAS_NUMBER;
    }
}