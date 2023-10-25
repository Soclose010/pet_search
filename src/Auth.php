<?php

namespace Src;
use Src\Model\User;
use Src\Validator\Validator;

class Auth
{

    public static function login(array $data): bool|array
    {
        $errors = Validator::validate($data,[
            'phone' => ['required'],
            'password' => ['required']
        ]);

        if ($errors == [])
        {
            $user = new User();
            $user = $user->allQuery()
                ->where('phone',$data['phone'])
                ->where('password',$data['password'])
                ->get();
            if ($user != [])
            {
                $_SESSION['phone'] = $user[0]['phone'];
                $_SESSION['name'] = $user[0]['name'];
                return true;
            }
            else
            {
                return ['login' => ['Пользователь с таким сочетанием логина и пароля не найден']];
            }
        }
        else
        {
            return $errors;
        }
    }
    public static function register(array $data): array|bool
    {
        $errors = Validator::validate($data,[
            'name' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'phone' => ['required', 'number', 'length:11'],
            'password' => ['required', 'string', 'length:6', 'letter', 'hasNumber', 'capLetter']
        ]);
        if ($errors == [])
        {
            $user = new User();
            if ($user->allQuery()->where('phone', $data['phone'])->get() == [])
            {
                return $user->create($data);
            }
            else
            {
                return ['register' => ['Пользователь с таким номером уже существует']];
            }
        }
        else
        {
            return $errors;
        }
    }
}