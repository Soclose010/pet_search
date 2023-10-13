<?php

namespace Src\Validator;

class Validator
{

    private const STRING = 'Поле должно быть строкой';
    private const REQUIRED='Поле обязательно для заполнения';
    private const LENGTH = 'В поле должно быть не менее';
    public static function validate (mixed $data, array $params) : mixed
    {
        $res = [];
        foreach ($params as $param)
        {
            if (strpos($param, ":"))
            {
                $val = explode(':', $param);
                $method = $val[0];
                $result = self::$method($data, $val[1]);
                if($result !== true)
                {
                    $res[] = $result;
                }
            }
            else
            {
                $result = self::$param($data);
                if($result !== true)
                {
                    $res[] = $result;
                }
            }
        }
        if (count($res) == 0 )
        {
            return $data;
        }
        else
        {
            return $res;
        }

    }
    public static function length($data, $len): bool|string
    {
        if (strlen($data) == $len)
        {
            return true;
        }
        else
        {
            return self::LENGTH . ' ' . $len . ' символов';
        }

    }

    public static function string($data): bool|string
    {
        if (is_string($data))
        {
            return true;
        }
        else
        {
            return self::STRING;
        }
    }

    public static function required($data): bool|string
    {
        if ($data != '')
        {
            return true;
        }
        else
        {
            return self::REQUIRED;
        }
    }
}