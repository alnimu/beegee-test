<?php

class Application
{
    public static $app;
    
    public $defaultController = 'default';
    public $user;

    private $_config = [];
    private $_route = [];
    private $_controller;

    public function __construct(array $config=[])
    {
        self::$app = $this;
        set_exception_handler([self::$app, 'exceptionHandler']);

        session_start();
        
        $this->_config = $config;
        $this->user = new UserIdentity();
        self::$app = $this;

        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        BaseModel::$db = new PDO($this->_config['db']['dsn'], $this->_config['db']['username'], $this->_config['db']['password'], $opt);
    }

    public function run()
    {
        $this->_parseRequest();
        $this->_controller = $this->_initController();
        $this->_controller->runAction();
    }
    
    public function getRoute()
    {
        return $this->_route;
    }
    
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @param Exception $exception
     */
    public function exceptionHandler($exception)
    {
        echo 'Exception: ' . $exception->getMessage();
    }

    public function createUrl($route, $params=[])
    {
        $params['route'] = $route;
        return $_SERVER['HTTP_HOST'] . '?' . http_build_query($params);
    }

    private function _parseRequest()
    {
        if (isset($_GET['route']) and $_GET['route']) {
            $route = array_filter(explode('/', $_GET['route']));
            $this->_route = array_map('trim', $route);
        }
    }

    /**
     * @return BaseController
     * @throws ApplicationException
     */
    private function _initController()
    {
        $controllerClass = ucfirst(mb_strtolower($this->defaultController, 'utf8')) . 'Controller';
        if (isset($route[0]) and $route[0]) {
            $controllerClass = ucfirst(mb_strtolower($route[0], 'utf8')) . 'Controller';
        }

        if (class_exists($controllerClass, false))
            throw new ApplicationException('Controller not exists.');
            
        return new $controllerClass();
    }
    
    public static function getPathOfAlias($alias)
    {
        return BASE_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $alias);
    }
}