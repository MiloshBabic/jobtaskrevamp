<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 30.10.2014
 * Time: 14:28
 */

class View_CreateEvent
{
    private $eventController;
    private $eventModel;
    private $recurringTypeModel;

    public function __construct(Controller_Event $eventController, Model_Event $eventModel,  Model_RecurringType $recurringTypeModel)
    {
        $this->eventController = $eventController;
        $this->eventModel = $eventModel;
        $this->recurringTypeModel = $recurringTypeModel;
    }

    public function output()
    {
        $data = $this->recurringTypeModel->getRecurringTypes();


        require_once($this->eventModel->templateCreate);
    }
} 