<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 30.10.2014
 * Time: 14:29
 */

class Controller_Event
{

    private $eventModel;

    public function __construct(Model_Event $eventModel)
    {
        $this->eventModel = $eventModel;
    }

    /*
     *  Action that sets model's parameters
     */
    public function eventSubmitted()
    {
        $this->eventModel->setTitle($_POST['title']);
        $this->eventModel->setDescription($_POST['description']);
        $this->eventModel->setStartDate(date('Y-m-d', strtotime($_POST['dateFrom'])));
        /*
        *  If the checkbox in the form is set, set the rest of the parameters
        */
        if(!isset($_POST['repeat']))
            $this->eventModel->addARecurringEvent();
        else
        {
            $this->eventModel->setEndDate(date('Y-m-d', strtotime($_POST['dateEnd'])));
            $this->eventModel->setRecurringType($_POST['recurringType']);
            $this->eventModel->setRepetitionCycle($_POST['repeatCount']);
            $this->eventModel->setRepetitionType($_POST['occurrenceType']);
            $this->eventModel->setNoOfOccurrences($_POST['numberOfOccurrences']);

            /*
            *  If certain days are chosen, calculate the sum of the value of days picked
            */
            if(isset($_POST['day']))
            {
                $repetitionOnDays = $_POST['day'];
                $repetitionOnDays = array_map('intval', $repetitionOnDays);
                $repetitionOnDays = array_sum($repetitionOnDays);

                $this->eventModel->setRepeatOnDays($repetitionOnDays);
            }
            /*
             *  Send model a signal to start generating events and go back to index
             */
            Utility_EventGenerator::generateEvents($this->eventModel);
        }

        header("Location: index.php");
    }



} 