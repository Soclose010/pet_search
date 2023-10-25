<?php

namespace Src;
use Src\Model\User;
use Src\Validator\Validator;

class Auth
{

    public static function login(array $data)
    {
        $errors = Validator::validate($data,[
            'phone' => ['required'],
            'password' => ['required']
        ]);

        if ($errors == [])
        {
            $user = new User();
            dd($user->allQuery()->where('phone',$data['phone'])->where('password',$data['password'])->get());
        }
        else
        {
            dd($errors);
        }
    }
    public static function register(string $phone, string $password)
    {
        $errors = Validator::validate([
            $phone => ['required', 'number', 'length:11'],
            $password => ['required', 'string', 'length:6', 'letter', 'hasNumber', 'capLetter']
        ]);
        if ($errors == [])
        {

        }
    }
}