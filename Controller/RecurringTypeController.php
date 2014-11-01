<?php


class RecurringTypeController
{
    private $recurringTypeModel;

    public function __construct(RecurringTypeModel $recurringTypeModel)
    {
        $this->recurringTypeModel = $recurringTypeModel;
    }

    /*
     *  Action that sets model's parameters
     */
    public function recurringTypeSubmitted()
    {
        $this->recurringTypeModel->setTitle($_POST['title']);
        $this->recurringTypeModel->setRecurringType($_POST['recurringType']);
        $this->recurringTypeModel->setRepetitionCycle($_POST['repeatCount']);
        $this->recurringTypeModel->setRepetitionType($_POST['occurrenceType']);
        $this->recurringTypeModel->setNoOfOccurrences($_POST['numberOfOccurrences']);
        $this->recurringTypeModel->setEndDate(date('Y-m-d', strtotime($_POST['dateEnd'])));


        /*
         *  If certain days are chosen, calculate the sum of the value of days picked
         */
        if(isset($_POST['day']))
        {
            $repetitionOnDays = $_POST['day'];
            $repetitionOnDays = array_map('intval', $repetitionOnDays);
            $repetitionOnDays = array_sum($repetitionOnDays);

            $this->recurringTypeModel->setRepeatOnDays($repetitionOnDays);
        }
        /*
         *  Send model a signal to start generating events and go back to index
         */

        $this->recurringTypeModel->addRecurringType();

        header("Location: index.php?page=createevent");
    }

} 