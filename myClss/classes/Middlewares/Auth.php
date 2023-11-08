<?php

namespace myClss\Middlewares;

class Auth implements MiddlewareInterface
{
    public function handle()
    {
        if (!isset($_SESSION['user']))
        {
            redirect('/register');
        }
    }
}