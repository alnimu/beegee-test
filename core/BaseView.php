<?php

class BaseView
{
    public $context;
    
    public function render($viewPath, $vars)
    {
        if (!is_file($viewPath))
            throw new ApplicationException('View file not exists.');
        
        extract($vars);

        ob_start();
        include ($viewPath);
        $renderedView = ob_get_clean();

        return $renderedView;
    }
}