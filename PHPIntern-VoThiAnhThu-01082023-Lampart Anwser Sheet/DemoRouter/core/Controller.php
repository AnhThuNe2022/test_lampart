<?php

class Controller
{
    public function model($model)
    {
        if (file_exists(_DIR_ROOT.'/app/repositories/'.$model.'.php')) {
            require_once _DIR_ROOT.'/app/repositories/'.$model.'.php';
            if (class_exists($model)) {
                $modelInstance = new $model();
                return $modelInstance;
            }
        }
        return false;
    }


    public function render($view,$data=[])
    {
        if(file_exists(_DIR_ROOT.'/app/views/'.$view.'.php')){
            require_once _DIR_ROOT.'/app/views/'.$view.'.php';
  
        }      
    }
}
