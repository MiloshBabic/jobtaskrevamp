<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 30.10.2014
 * Time: 14:29
 */

class View_RecurringType
{
    private $recurringTypeController;
    private $recurringTypeModel;

    public function __construct(Controller_RecurringType $recurringTypeController, Model_RecurringType $recurringTypeModel)
    {
        $this->recurringTypeModel = $recurringTypeModel;
        $this->recurringTypeController = $recurringTypeController;
    }

    public function output()
    {

        require_once($this->recurringTypeModel->templateRecurring);
    }

} 