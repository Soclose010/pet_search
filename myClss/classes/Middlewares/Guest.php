<?php

namespace myClss\Middlewares;

class Guest implements MiddlewareInterface
{
    public function handle()
    {
        if (isset($_SESSION['user']))
        {
            redirect('/');
        }
    }
}