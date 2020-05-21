<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once('vendor/autoload.php');

//Instantiate the F3 Base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

//Survey route
$f3->route('GET|POST /survey', function ($f3) {

    $options = array("This midterm is easy", "I like midterms", "Today is Monday", "I will get 100/100 on this midterm");

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        var_dump($_POST);

        //Store the data in the session array
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['options'] = $_POST['options'];

        //Redirect to Summary page
        $f3->reroute('summary');
    }

    $f3->set('options', $options);

    $view = new Template();
    echo $view->render('views/survey.html');

});

//Summary route
$f3->route('GET /summary', function () {
    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();
});


//Run fat free
$f3->run();