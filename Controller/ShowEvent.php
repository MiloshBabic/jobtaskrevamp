<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 30.10.2014
 * Time: 16:52
 */

class Controller_ShowEvent {

    private $eventModel;

    public function __construct(Model_Event $eventModel)
    {
        $this->eventModel = $eventModel;
    }

    /*
     *  Tell model to fetch events from dateFrom to dateTo
     */
    public function showEvents()
    {
        $this->eventModel->getEventsForPeriod($_POST['dateFrom'], $_POST['dateTo']);

    }
} 