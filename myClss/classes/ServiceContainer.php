<?php

namespace myClss;


use Exception;

class ServiceContainer
{
    private array $services = [];

    public function setService($service, $function): void
    {
        $this->services[$service] = $function;
    }

    public function getService($service)
    {
        if (isset($this->services[$service]))
            return call_user_func($this->services[$service]);
        else
            throw new Exception("Сервис не найден");
    }
}