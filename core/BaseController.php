<?php

class BaseController
{
    public $layout = 'views.layouts.main';
    public $defaultAction = 'index';
    
    private $_view;
    private $_name;

    public function getName()
    {
        if ($this->_name === null) {
            $this->_name = mb_strtolower(str_replace('Controller', '', get_class($this)), 'utf8');
        }
        return $this->_name;
    }

    public function runAction()
    {
        $action = 'action' . ucfirst(mb_strtolower($this->defaultAction, 'utf8'));
        $route = Application::$app->getRoute();

        if (isset($route[1]) and $route[1]) {
            $action = 'action' . ucfirst(mb_strtolower($route[1], 'utf8'));
        }

        if (!method_exists($this, $action))
            throw new ApplicationException('Action not exists.');
        
        echo call_user_func([$this, $action]);
    }
    
    public function render($alias, $vars = [])
    {
        $content = $this->renderPartial($alias, $vars);
        return $this->renderPartial($this->layout, ['content' => $content]);
    }
    
    public function renderPartial($alias, $vars = [])
    {
        $view = Application::getPathOfAlias($alias) . '.php';
        $viewInstance = $this->getView();
        return $viewInstance->render($view, $vars);
    }

    public function redirect($route)
    {
        header("Location: " . Application::$app->createUrl($route));
        die();
    }

    /**
     * @return BaseView
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = new BaseView();
            $this->_view->context = $this;
        }
        return $this->_view;
    }
}