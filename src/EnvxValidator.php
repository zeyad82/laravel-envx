<?php

namespace Zeyad82\LaravelEnvx;

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

            $msg = 'The envx.php file has errors, have a look at config/envx-validator.php:'
                . PHP_EOL
                . implode(PHP_EOL, $messages);

            throw new LaravelEnvxException($msg);
        }
    }
    
}
