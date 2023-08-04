<?php

class Category extends Controller
{

    //public $model_home;
    public $data = [];
    // public function __construct()
    // {
    //     $this -> model_home= $this -> model('CategoryModel');
    //     var_dump ($this -> model_home);

    // }

    function index()
    {
        $category = $this ->model('CategoryModel');
        $dataCategory = $category->getList();
        
        $this-> data['cate_list'] = $dataCategory;
        //reder view
        $this->render('Category_index',$this->data);



    }

    


    function show()
    {
        $data = $this ->model_home -> getList();
        echo '<pre>';
        print_r($data);
        echo '<pre>';
    }

    function test()
    {
        echo 'test';
    }
}
