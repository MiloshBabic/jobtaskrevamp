<?php

    function __autoload($class_name)
    {

        $filename = str_replace("_", "/", $class_name). ".php";

        if(file_exists($filename))
        {
            include $filename;
        }
        else
            throw new Exception("Unable to load $class_name");
    }

    /*
     * Gets page parameter
     */
    if(isset($_GET['page']))
        $page = $_GET['page'];
    else
        $page = "";

    $data = array();

    /*
     *  I have decided to go with static routing because of the project size
     *  if the page parameter is empty set the MVC triad to Show Event
     */
    if(!empty($page))
    {
        $data = array(
            'showevents' => array('model' => 'Model_Event', 'controller' => 'Controller_ShowEvent', 'view' => 'View_ShowEvent'),
            'createevent' => array('recModel' => 'Model_RecurringType', 'evModel' => 'Model_Event', 'controller' => 'Controller_Event', 'view' => 'View_CreateEvent'),
            'createrecurringtype' => array('model' => 'Model_RecurringType', 'controller' => 'Controller_RecurringType', 'view' => 'View_RecurringType')
        );
    }
    else
    {
        $data = array(
            "" => array('model' => 'Model_Event', 'controller' => 'Controller_ShowEvent', 'view' => 'View_ShowEvent')
        );
    }

    /*
     *  Instantiate MVC triad depending on the page parameter
     */
    foreach($data as $key => $components)
    {
        if($page == $key)
        {
            if($key == 'createevent')
            {
                $recModel = $components['recModel'];
                $evModel = $components['evModel'];
                $view = $components['view'];
                $controller = $components['controller'];
            }
            else
            {
                $model = $components['model'];
                $view = $components['view'];
                $controller = $components['controller'];
            }

            break;
        }
    }

    $v = null;
    if(isset($model))
    {
        $m = new $model();
        $c = new $controller($m);
        $v = new $view($c, $m);
    }
    else
    {

        $recM = new $recModel();
        $evM = new $evModel();
        $c = new $controller($evM);
        $v = new $view($c, $evM ,$recM);
    }


    /*
     *  Route actions to a proper controller
     */
    if (isset($_GET['action']))
        $c->{$_GET['action']}();



    /*
     *  Output a proper view
     */
    echo $v->output();