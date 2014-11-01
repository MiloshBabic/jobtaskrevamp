<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 30.10.2014
 * Time: 14:29
 */

class Model_Event
{
    private $title;
    private $description;
    private $startDate;
    private $recurringType;
    private $repetitionCycle;
    private $repeatOnDays;

    private $repetitionType;
    private $noOfOccurrences;
    private $endDate;

    private $db;
    private $events = array();



    public function __construct()
    {
        $this->templateShow = "tpl/ShowEvents.php";
        $this->templateCreate = "tpl/CreateEvent.php";

        $this->db = mysqli_connect("localhost", "root", "");

        if(mysqli_connect_errno())
            echo "Failed to connect to MySQL " . mysqli_connect_error();


        mysqli_select_db($this->db, "calendar");
        $checkTable = mysqli_query($this->db, "SHOW TABLES LIKE 'events'");

        /*
         *  Check if table is created if not create it
         */
        if(!mysqli_num_rows($checkTable))
            $this->createTable();

    }



    public function getDescription()
    {
        return $this->description;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getNoOfOccurrences()
    {
        return $this->noOfOccurrences;
    }

    public function getRecurringType()
    {
        return $this->recurringType;
    }

    public function getRepeatOnDays()
    {
        return $this->repeatOnDays;
    }

     public function getRepetitionCycle()
    {
        return $this->repetitionCycle;
    }

    public function getRepetitionType()
    {
        return $this->repetitionType;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setNoOfOccurrences($noOfOccurrences)
    {
        $this->noOfOccurrences = $noOfOccurrences;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }


    public function setRecurringType($recurringType)
    {
        $this->recurringType = $recurringType;
    }


    public function setRepeatOnDays($repeatOnDays)
    {
        $this->repeatOnDays = $repeatOnDays;
    }


    public function setRepetitionCycle($repetitionCycle)
    {
        $this->repetitionCycle = $repetitionCycle;
    }

    public function setRepetitionType($repetitionType)
    {
        $this->repetitionType = $repetitionType;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function setEvents($events)
    {
        $this->events = $events;
    }

    /*
     *  Adds a single instance of an Event
     */
    public function addARecurringEvent()
    {
        if($this->checkDuplicates($this->title, $this->startDate))
            echo "Events must have unique name and start date!!!";
        else
        {
            $sql = "INSERT INTO events (TITLE, DESCRIPTION, START_DATE, RECURRING_TYPE, REPETITION_CYCLE,
                    REPEAT_ON_DAYS, REPETITION_TYPE, No_OF_OCCURRENCES, END_DATE) VALUES("
                . "'" .$this->title . "',"
                . "'" .$this->description . "',"
                . "'" .$this->startDate. "',"
                . "'" .$this->recurringType. "',"
                . "'" .$this->repetitionCycle. "',"
                . "'" .$this->repeatOnDays. "',"
                . "'" .$this->repetitionType. "',"
                . "'" .$this->noOfOccurrences. "',"
                . "'" .$this->endDate . "');";

            if(!mysqli_query($this->db, $sql))
                echo "Error adding event " . mysqli_error($this->db);
        }
    }

    /*
     *  If a custom type is selected fill in parameters from that type
     */
    public function getDataForCustomType()
    {
        $sql = "SELECT * FROM recurringtype WHERE TITLE = '" . $this->recurringType. "'";
        $query = mysqli_query($this->db, $sql);

        $row = mysqli_fetch_array($query);
        //$this->recurringType = $row['RECURRING_TYPE'];
        $this->repetitionCycle = $row['REPETITION_CYCLE'];
        $this->repeatOnDays = $row['REPEAT_ON_DAYS'];
        $this->repetitionType = $row['REPETITION_TYPE'];
        $this->noOfOccurrences = $row['No_OF_OCCURRENCES'];
        $this->endDate = $row['END_DATE'];
    }

    /*
     * Gets recurring type for a custom recurring type :)
     */
    public function getCustomRecurringTypeForName($name)
    {
        $sql = "SELECT * FROM recurringtype WHERE TITLE = '" . $name. "'";
        $query = mysqli_query($this->db, $sql);
        $row = mysqli_fetch_array($query);

        return $row['RECURRING_TYPE'];
    }

    /*
     *  If certain days are selected check which are. If all the days are checked the number will be 127 or in binary 1111111
     *  If for instance monday is chosen the parameter $daysInInt will be 64 or in binary 1000000
     *  So the number is shifted and checked for each shift if the number 1 is on that position.
     */
    public function getDaysFromForm($daysInInt)
    {
        $counter = 1;
        $weekdays = array();

        while($daysInInt)
        {

            if($daysInInt & 1)
            {
                switch($counter)
                {
                    case 7: $weekdays[] = "Monday"; break;
                    case 6: $weekdays[] = "Tuesday"; break;
                    case 5: $weekdays[] = "Wednesday"; break;
                    case 4: $weekdays[] = "Thursday"; break;
                    case 3: $weekdays[] = "Friday"; break;
                    case 2: $weekdays[] = "Saturday"; break;
                    case 1: $weekdays[] = "Sunday"; break;
                }
            }

            $daysInInt = $daysInInt >> 1;
            $counter++;
        }

        return array_reverse($weekdays);
    }

    /*
     *  Check for duplicate entries of an event. Events must have a unique name and start date
     */
    public function checkDuplicates($title, $startDate)
    {
        $sql = "SELECT * FROM events WHERE TITLE = '" . $title . "' AND START_DATE = '" . $startDate . "'";
        $query = mysqli_query($this->db, $sql);

        if(mysqli_num_rows($query) == 0)
            return false;
        else
            return true;
    }

    /*
     *  Check events which have unlimited repetition. If some unlimited events are found in range dateFrom-dateTo
     *  generate those events
     */
    public function checkUnlimitedEvents($dateFrom, $dateTo)
    {
        $sql = "SELECT * FROM events WHERE REPETITION_TYPE = 'UNLIMITED'";
        $query = mysqli_query($this->db, $sql);

        while($row = mysqli_fetch_array($query))
        {
            $newDate = $row['START_DATE'];
            $newDate = strtotime($newDate);
            $repetitionCycle = "";
    /*
     *  Setting recurring cycle, if recurring type is weekly it should be 7 days times recurring cycle
     *  if its monday - wednesday - friday then its 7 day per day
     *  if its yearly it's number of years
     *  if its daily it's number of days
     */
            switch($row['RECURRING_TYPE'])
            {
                case "WEEKLY" :
                    $repetitionCycle = "+" . (7 * $row['REPETITION_CYCLE']) . " day";
                    break;
                case "MWF" :
                    $repetitionCycle = "+" . (7 * $row['REPETITION_CYCLE']) . " day";
                    break;
                case "YEARLY" :
                    $repetitionCycle = "+" . $row['REPETITION_CYCLE'] . " year";
                    break;
                case "DAILY" :
                    $repetitionCycle = "+" . $row['REPETITION_CYCLE'] . " day";
                    break;
            }

            while(1)
            {
                /*
                 * Checks if the $newDate is out of bounds on the left side
                 */
                if(strtotime($dateFrom) > $newDate)
                    $newDate = strtotime($repetitionCycle, $newDate);
                /*
                 *  Checks if the $newDate is out of bounds on the right side
                 */
                elseif(strtotime($dateTo) < $newDate)
                    break;

                /*
                 *  If the $newDate is between dateFrom and dateTo check if there are duplicate entries
                 *  and add them one by one
                 */
                else if(strtotime($dateFrom) <= $newDate && strtotime($dateTo) >= $newDate)
                {
                    if($newDate == strtotime($row['START_DATE']))
                        $newDate = strtotime($repetitionCycle, $newDate);

                    else
                    {
                        if($this->checkDuplicates($row['TITLE'], date('Y-m-d', $newDate)))
                            break;

                        else{
                            $this->title = $row['TITLE'];
                            $this->description = $row['DESCRIPTION'];
                            $this->startDate = date('Y-m-d', $newDate);
                            $this->recurringType =  $row['RECURRING_TYPE'];
                            $this->repetitionCycle = $row['REPETITION_CYCLE'];
                            $this->repeatOnDays = $row['REPEAT_ON_DAYS'];
                            $this->repetitionType = $row['REPETITION_TYPE'];
                            $this->noOfOccurrences =  $row['No_OF_OCCURRENCES'];
                            $this->endDate = $row['END_DATE'];
                            $this->addARecurringEvent();
                            $newDate = strtotime($repetitionCycle, $newDate);
                        }
                    }
                }

            }

        }

    }


    /*
     *  Checks for events in the range dateFrom-dateTo, if found put them in $events parameter
     *  If some of the events have unlimited repetition set, generate events in that range if there are any
     */
    public function getEventsForPeriod($dateFrom, $dateTo)
    {

        $sql = "SELECT * FROM events ORDER BY START_DATE ASC ";
        $query = mysqli_query($this->db, $sql);

        while($row = mysqli_fetch_array($query))
        {
            if($row['REPETITION_TYPE'] == "UNLIMITED")
            {
                $this->checkUnlimitedEvents($dateFrom, $dateTo);
                if(strtotime($dateFrom) <= strtotime($row['START_DATE']) && strtotime($dateTo) >= strtotime($row['START_DATE']))
                {
                    $this->events[] = $this->printEventsByTitle($row['TITLE'],$row['START_DATE']);
                }
            }
            else if(strtotime($dateFrom) <= strtotime($row['START_DATE']) && strtotime($dateTo) >= strtotime($row['START_DATE']))
                $this->events[] = $this->eventToString($row['ID']);
        }
    }

    /*
     *  Format events and return as a string
     */
    public function eventToString($id)
    {
        $sql = "SELECT * FROM events WHERE ID = ".$id;
        $query = mysqli_query($this->db, $sql);
        $row = mysqli_fetch_array($query);

        $event = "Title: " . $row["TITLE"] . "<br /> Event description: ". $row["DESCRIPTION"] . "<br /> Start date: ".date('M j, Y', strtotime($row['START_DATE'])) ."<br /> ";

        if($row["RECURRING_TYPE"] != null)
        {
            $event .="Repeats: ";

            switch($row["RECURRING_TYPE"])
            {
                case "WEEKLY":
                    $event .="weekly ";

                    if($row['REPEAT_ON_DAYS'] > 0)
                    {
                        $weekdays = $this->getDaysFromForm($row['REPEAT_ON_DAYS']);
                        $event .= "on ";

                        if(!empty($weekdays))
                        {    for($i = 0; $i < count($weekdays); $i++)
                            if($i != count($weekdays) - 1)
                                $event .= $weekdays[$i] . ", ";
                            else
                                $event .= $weekdays[$i] . ".";
                        }
                    }
                    break;
                case "DAILY":
                    $event .= "daily ";
                    break;
                case "MWF":
                    $event .="Monday - Wednesday - Friday ";
                    break;
                case "YEARLY":
                    $event .="yearly ";
                    break;
                default:
                    $event .= $row['RECURRING_TYPE'];
            }

            if($row["REPETITION_CYCLE"] != null &&(int)$row["REPETITION_CYCLE"] > 1 )
            {
                $event .= "every " .$row["REPETITION_CYCLE"] ;
                switch($row["RECURRING_TYPE"])
                {
                    case "WEEKLY":
                        $event .= " weeks ";
                        break;
                    case "DAILY":
                        $event .= " days ";
                        break;
                    case "YEARLY":
                        $event .= " years ";
                        break;
                }
            }

            if($row["REPETITION_TYPE"] == "N_TIMES")
                $event .=  $row["No_OF_OCCURRENCES"] . " times.";

            else if($row["REPETITION_TYPE"] == "UP_UNTIL")
                $event .=  "until " . date('M j, Y', strtotime($row['END_DATE']));

            $event .= "<br />";
        }
        $event .= "<br />";

        return $event;
    }

    /*
     *  Returns events as strings but given a title and start date
     */
    public function printEventsByTitle($title, $startDate)
    {
        $sql = "SELECT ID FROM events WHERE TITLE = '".$title . "' AND " . "START_DATE = '" . $startDate . "'";
        $query = mysqli_query($this->db, $sql);
        $row = mysqli_fetch_array($query);

        return $this->eventToString($row['ID']);
    }

    /*
     *  Create table
     */
    public function createTable()
    {

        if(mysqli_connect_errno())
            echo "Failed to connect too to MySQL " . mysqli_connect_error();

        $sql = "CREATE TABLE IF NOT EXISTS events ( "
            .  "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, "
            .  "TITLE VARCHAR(50), "
            .  "DESCRIPTION VARCHAR(300), "
            .  "START_DATE DATE NOT NULL, "
            .  "RECURRING_TYPE VARCHAR(200), "
            .  "REPETITION_CYCLE INT, "
            .  "REPEAT_ON_DAYS INT, "
            .  "REPETITION_TYPE ENUM('N_TIMES', 'UP_UNTIL', 'UNLIMITED'), "
            .  "No_OF_OCCURRENCES INT, "
            .  "END_DATE DATE);";

        mysqli_query($this->db, $sql);
    }

    public function __destruct()
    {
        mysqli_close($this->db);
    }
} 