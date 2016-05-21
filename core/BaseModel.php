<?php

abstract class BaseModel
{
    public $id;
    
    /** @var PDO $db */
    public static $db;
    private static $_models = [];
    
    private $_errors = [];
    
    public function setAttributes(array $attributes)
    {
        $safeAttributes = $this->safeAttributes();
        foreach ($attributes as $attribute=>$value) {
            if (in_array($attribute, $safeAttributes) and property_exists($this, $attribute))
                $this->$attribute = $value;
        }
    }

    public function getAttributes()
    {
        return get_object_vars($this);
    }
    
    public function addError($attribute, $message)
    {
        $this->_errors[$attribute][] = $message;
    }
    
    public function getError($attribute)
    {
        if (isset($this->_errors[$attribute])) {
            return implode(' | ', $this->_errors[$attribute]);
        }
        
        return '';
    }
    
    public function getErrors()
    {
        return $this->_errors;
    }
    
    public function hasError($attribute)
    {
        return isset($this->_errors[$attribute]);
    }
    
    public function hasErrors()
    {
        return !empty($this->_errors);
    }

    public function pdoSet($allowed, &$values, $source = []) {
        $set = '';
        $values = array();
        foreach ($allowed as $field) {
            if (isset($source[$field])) {
                $set.="`".str_replace("`","``",$field)."`". "=:$field, ";
                $values[$field] = $source[$field];
            }
        }
        return substr($set, 0, -2);
    }
    
    public function isNewRecord()
    {
        return (bool) !$this->id;
    }
    
    public static function model($className=__CLASS__)
    {
        if(isset(self::$_models[$className]))
            return self::$_models[$className];
        else
        {
            $model=self::$_models[$className]=new $className(null);
            return $model;
        }
    }
    
    abstract public function safeAttributes();
}