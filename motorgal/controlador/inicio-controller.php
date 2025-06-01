<?php
include_once("controller.php");
class InicioController extends Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function principal(){
        $this->vista->show('inicio');

    }
}