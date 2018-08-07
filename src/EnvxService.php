<?php

namespace Zeyad82\LaravelEnvx;

class EnvxService
{
    private $variables = [];

    public function __construct()
    {
        if(file_exists(base_path('envx.php'))) {
            $this->variables = require base_path('envx.php');
        }        
    }

    public function getAll()
    {
        return $this->variables;
    }

    public function get($key)
    {
        return array_get($this->variables, $key);
    }
}
