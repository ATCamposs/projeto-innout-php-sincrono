<?php

namespace Src\Config;

class Loader
{
    public function loadModel(string $modelName): void
    {
        $final_file = realpath(dirname(__FILE__) . '/../Model/' . $modelName . '.php');
        if (is_string($final_file) && file_exists($final_file)) {
                require_once(realpath(dirname(__FILE__) . '/../Model/' . $modelName . '.php'));
        }
        if (!is_string($final_file)) {
            var_dump("Arquivo inexistente");
        }
    }

    /**
     * @param mixed $params
     */
    public function loadView(string $viewName, $params = []): void
    {
        foreach ($params as $key => $value) {
            if (!empty($key)) {
                ${$key} = $value;
            }
        }
        $final_file = realpath(dirname(__FILE__) . '/../View/' . $viewName . '.php');
        if (is_string($final_file) && file_exists($final_file)) {
            require_once(realpath(dirname(__FILE__) . '/../View/' . $viewName . '.php'));
        }
        if (!is_string($final_file)) {
            var_dump("Arquivo inexistente");
        }
    }
}