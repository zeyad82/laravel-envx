<?php

namespace Zeyad82\LaravelEnvx;

use Exception;
use Validator;

class EnvxValidator
{
    private $envx;    
    private $validator;

    public function __construct()
    {
        $this->envx = app('envx');
        $this->validator = $this->build();
    }

    private function build()
    {
        $rules = config('envx-validator');
        $keys = array_keys($rules);
        
        return Validator::make($this->envx->getAll(), $rules, [], array_combine($keys, $keys));
    }

    public function validate()
    {
        if ($this->validator->fails()) {

            $messages = [];
            
            foreach ($this->validator->messages()->all() as $message) {
                $messages[] = $message;
            }

            $msg = 'The envx.php file has some problems:'
                . PHP_EOL
                . implode(PHP_EOL, $messages);

            throw new Exception($msg);
        }
    }
    
}
