<?php

// Un exemple de fonction de rappel
function my_callback_function()
{
    echo 'hello world!';
}

// Un exemple de méthode de rappel
class MyClass
{
    public static function myCallbackMethod()
    {
        echo 'Hello World!';
    }
}

// Type 1 : Fonction de rappel simple
call_user_func('my_callback_function');


// Type 2 : Appel d'une méthode statique de classe
call_user_func(['MyClass', 'myCallbackMethod']);

// Type 3 : Appel d'une méthode objet
$obj = new MyClass();
call_user_func([$obj, 'myCallbackMethod']);

// Type 4 : Appel d'une méthode statique de classe (depuis PHP 5.2.3)
call_user_func('MyClass::myCallbackMethod');


// Type 5 : Appel à une méthode statique de classe relative (depuis PHP 5.3.0)
class A
{
    public static function who()
    {
        echo "A\n";
    }
}

class B extends A
{
    public static function who()
    {
        echo "B\n";
    }
}

call_user_func(['B', 'parent::who']); // A


// Type 6 : Les objets implémentants __invoke peuvent être utilisés comme callables (depuis PHP 5.3)
class C
{
    public function __invoke($name)
    {
        echo 'Hello ', $name, "\n";
    }
}

$c = new C();
call_user_func($c, 'PHP!');
