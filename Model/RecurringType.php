<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 30.10.2014
 * Time: 14:30
 */

class Model_RecurringType
{
    private $title;
    private $recurringType;
    private $repetitionCycle;
    private $repeatOnDays;
    private $repetitionType;
    private $noOfOccurrences;
    private $endDate;
    private $recurringTypes = array();

    private $db;

    public function __construct()
    {
        $this->templateRecurring = "tpl/CreateRecurringType.php";

        $this->db = mysqli_connect("localhost", "root", "");

        if(mysqli_connect_errno())
            echo "Failed to connect to MySQL " . mysqli_connect_error();

        mysqli_select_db($this->db, "calendar");

        $checkTable = mysqli_query($this->db, "SHOW TABLES LIKE 'recurringtype'");

        if(!mysqli_num_rows($checkTable))
            $this->createTable();
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function setNoOfOccurrences($noOfOccurrences)
    {
        $this->noOfOccurrences = $noOfOccurrences;
    }

   public function setRepetitionCycle($repetitionCycle)
    {
        $this->repetitionCycle = $repetitionCycle;
    }

    public function setRepeatOnDays($repeatOnDays)
    {
        $this->repeatOnDays = $repeatOnDays;
    }

    public function setRecurringType($recurringType)
    {
        $this->recurringType = $recurringType;
    }

    public function setRepetitionType($repetitionType)
    {
        $this->repetitionType = $repetitionType;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }


    /*
     * Creates table
     */
    public function createTable()
    {
        $sql =  "CREATE TABLE RecurringType ( "
            .   "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, "
            .   "TITLE VARCHAR(50) NOT NULL, "
            .   "RECURRING_TYPE ENUM('DAILY', 'WEEKLY', 'MWF', 'YEARLY'), "
            .   "REPETITION_CYCLE INT, "
            .   "REPEAT_ON_DAYS INT, "
            .   "REPETITION_TYPE ENUM('N_TIMES', 'UP_UNTIL', 'UNLIMITED'), "
            .   "No_OF_OCCURRENCES INT, "
            .   "END_DATE DATE);";

        mysqli_query($this->db, $sql);
    }


    /*
     *  Adds new custom recurring type with a unique name
     */
    public function addRecurringType()
    {
        if($this->checkDuplicates($this->title))
            echo "Recurring type must have unique name!!!";
        else {
                $sql = "INSERT INTO recurringtype (TITLE, RECURRING_TYPE, REPETITION_CYCLE,
                        REPEAT_ON_DAYS, REPETITION_TYPE, No_OF_OCCURRENCES, END_DATE) VALUES("
                    . "'" . $this->title . "',"
                    . "'" . $this->recurringType . "',"
                    . "'" . $this->repetitionCycle . "',"
                    . "'" . $this->repeatOnDays . "',"
                    . "'" . $this->repetitionType . "',"
                    . "'" . $this->noOfOccurrences . "',"
                    . "'" . $this->endDate . "');";

            if(!mysqli_query($this->db, $sql))
                echo "Error adding Recurring type " . mysqli_error($this->db);
        }

    }

    /*
     *  Checks if the recurring type with that name exists in the db
     */
    public function checkDuplicates($title)
    {
        $sql = "SELECT * FROM recurringtype WHERE TITLE = '" . $title . "'";
        $query = mysqli_query($this->db, $sql);

        if(mysqli_num_rows($query) == 0)
            return false;
        else
            return true;
    }

    /*
     *  Fetching recurring types for the form for event creation
     *  first 4 are pre defined
     */
    public function getRecurringTypes()
    {
        $this->recurringTypes[0] = "WEEKLY";
        $this->recurringTypes[1] = "DAILY";
        $this->recurringTypes[2] = "YEARLY";
        $this->recurringTypes[3] = "MWF";

        $sql = "SELECT * FROM recurringtype";
        $query = mysqli_query($this->db, $sql);

        while($row = mysqli_fetch_array($query))
        {
            $this->recurringTypes[] = $row['TITLE'];
        }

        return $this->recurringTypes;
    }

    public function __destruct()
    {
        mysqli_close($this->db);
    }

} 