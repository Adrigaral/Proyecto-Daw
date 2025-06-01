<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/vista/View.php");

class Controller{
    protected View $vista;

    public function __construct()
    {
        $this->vista = new View();
    }

}