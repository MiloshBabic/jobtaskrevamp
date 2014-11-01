<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 30.10.2014
 * Time: 14:28
 */


class View_ShowEvent {

    private $eventModel;
    private $eventController;

    public function __construct(Controller_ShowEvent $eventController, Model_Event $eventModel)
    {
        $this->eventController = $eventController;
        $this->eventModel = $eventModel;
    }

    public function output()
    {
        $event = array();
        foreach($this->eventModel->getEvents() as $member)
            $event[] = $member;
        require_once($this->eventModel->templateShow);

    }
}