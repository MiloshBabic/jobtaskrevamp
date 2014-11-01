<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 30.10.2014
 * Time: 14:29
 */

class RecurringTypeView
{
    private $recurringTypeController;
    private $recurringTypeModel;

    public function __construct(RecurringTypeController $recurringTypeController, RecurringTypeModel $recurringTypeModel)
    {
        $this->recurringTypeModel = $recurringTypeModel;
        $this->recurringTypeController = $recurringTypeController;
    }

    public function output()
    {

        require_once($this->recurringTypeModel->templateRecurring);
    }

} 