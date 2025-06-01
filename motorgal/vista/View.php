<?php
class View{
    public function show($vista, $data=null){
        include($vista.'-view.php');
    }
}