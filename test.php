<?php

class base{
    public static $var = 1;
}

class sub1 extends base{
    public function __construct(){
        //base::$var = 2;
    }
}

class sub2 extends base{
    public function __construct(){

    }
}

$child = new sub1();
$child2 = new sub2();
echo base::$var;
echo sub1::$var;
echo sub2::$var;