<?php

namespace Zeyad82\LaravelEnvx;

class EnvxService
{
    private $variables = [];

    public function __construct()
    {
        $path = base_path('envx.php');

        if(file_exists($path) && substr(`php -l $path`, 0, 16) == 'No syntax errors') {
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
