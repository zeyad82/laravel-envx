<?php
if (! function_exists('envx')) {
    function envx($key, $default = null) {
        return app('envx')->get($key, $default);
    }
}
