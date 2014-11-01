<?php

    include('Utility/EventGenerator.php');
    include('Model/EventModel.php');
    include('Model/RecurringTypeModel.php');

    include('Controller/EventController.php');
    include('Controller/RecurringTypeController.php');
    include('Controller/ShowEventController.php');

    include('View/ShowEventView.php');
    include('View/CreateEventView.php');
    include('View/RecurringTypeView.php');

    /*
     * Gets page parameter
     */
    if(isset($_GET['page']))
        $page = $_GET['page'];
    else
        $page = "";

    $data = array();

    /*
     *  Static routing
     *  if the page parameter is empty set the MVC triad to Show Event
     */
    if(!empty($page))
    {
        $data = array(
            'showevents' => array('model' => 'EventModel', 'controller' => 'ShowEventController', 'view' => 'ShowEventView'),
            'createevent' => array('recModel' => 'RecurringTypeModel', 'evModel' => 'EventModel', 'controller' => 'EventController', 'view' => 'CreateEventView'),
            'createrecurringtype' => array('model' => 'RecurringTypeModel', 'controller' => 'RecurringTypeController', 'view' => 'RecurringTypeView')
        );
    }
    else
    {
        $data = array(
            "" => array('model' => 'EventModel', 'controller' => 'ShowEventController', 'view' => 'ShowEventView')
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