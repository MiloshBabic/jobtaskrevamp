<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 31.10.2014
 * Time: 20:41
 */

class EventGenerator
{

    /*
     *  Generates events which have recurring type : weekly
     */
    public static function generateWeeklyEvents(EventModel $model)
    {
        if ($model->getRepetitionCycle() == 0)
            $model->setRepetitionCycle(1);

        $newDate = strtotime($model->getStartDate());

       /*
        * Checks if certain days are hadn't been selected
        */
        if (!$model->getRepeatOnDays()) {
            /*
             * Checks if the repetition type is set to set number of times. If it is create NoOfOccurrences number of events
             */
            if ($model->getRepetitionType() == "N_TIMES") {
                for ($i = 0; $i < $model->getNoOfOccurrences(); $i++) {
                    $model->setStartDate(date('Y-m-d', $newDate));
                    $model->addARecurringEvent();
                    $cycleDays = $model->getRepetitionCycle() * 7;
                    $newDate = strtotime("+" . $cycleDays . "day", $newDate);
                }
            /*
             *  Checks if the end date is set. If it is generate events up until that date
             */
            } else if ($model->getRepetitionType() == "UP_UNTIL") {
                while ($newDate < strtotime($model->getEndDate())) {
                    $model->setStartDate(date('Y-m-d', $newDate));
                    $model->addARecurringEvent();
                    $cycleDays = $model->getRepetitionCycle() * 7;
                    $newDate = strtotime("+" . $cycleDays . "day", $newDate);
                }
            /*
             *  Check if the event repetition is set to unlimited. If it is create one event, the rest will be generated when
             *  dateFrom - dateTo is given
             */
            } else if ($model->getRepetitionType() == "UNLIMITED") {
                $model->setStartDate(date('Y-m-d', $newDate));
                $model->addARecurringEvent();
            }
        /*
         *  If certain days had been selected
         */
        } else
        {
            $firstWeekday = array();
            /*
             *  Gets selected weekday names
             */
            $weekdays = $model->getDaysFromForm($model->getRepeatOnDays());
            $currentDate = strtotime($model->getStartDate());
            for ($j = 0; $j < count($weekdays); $j++)
           /*
            *  Gets first possible date for the select weekday and puts it in $firstWeekday
            */
            for ($i = 0; $i < 7; $i++) {
                for ($j = 0; $j < count($weekdays); $j++)
                    if (date('l', $currentDate) == $weekdays[$j])
                        $firstWeekday[] = $currentDate;

                $currentDate = strtotime("+1 day", $currentDate);
            }
            /*
             *  If the repetition type is set to a set number of times, create that many events
             */
            if ($model->getRepetitionType() == "N_TIMES") {
                for ($i = 0; $i < $model->getNoOfOccurrences(); $i++) {
                    for ($j = 0; $j < count($firstWeekday); $j++) {
                        $model->setStartDate(date('Y-m-d', $firstWeekday[$j]));
                        $model->addARecurringEvent();
                        $cycleDays = $model->getRepetitionCycle() * 7;
                        $firstWeekday[$j] = strtotime("+" . $cycleDays . "day", $firstWeekday[$j]);
                    }
                }
            /*
             *  if the repetition type is up_until, the end date has to be set and generates events until that date
             */
            } else if ($model->getRepetitionType() == "UP_UNTIL") {
                while ($firstWeekday[0] < strtotime($model->getEndDate())) {
                    for ($j = 0; $j < count($firstWeekday); $j++) {
                        $model->setStartDate(date('Y-m-d', $firstWeekday[$j]));
                        $model->addARecurringEvent();
                        $cycleDays = $model->getRepetitionCycle() * 7;
                        $firstWeekday[$j] = strtotime("+" . $cycleDays . "day", $firstWeekday[$j]);
                    }
                }
            /*
             *  Generate only one event, the rest will be generated when a period is given
             */
            } else if ($model->getRepetitionType() == "UNLIMITED") {
                for ($j = 0; $j < count($firstWeekday); $j++) {
                    $model->setStartDate(date('Y-m-d', $firstWeekday[$j]));
                    $model->addARecurringEvent();
                    $cycleDays = $model->getRepetitionCycle() * 7;
                    $firstWeekday[$j] = strtotime("+" . $cycleDays . "day", $firstWeekday[$j]);
                }
            }
        }
    }
    /*
     *  Generates events which have recurring type : yearly
     */
    public static function generateYearlyEvents(EventModel $model)
    {
        if ($model->getRepetitionCycle() == 0)
            $model->setRepetitionCycle(1);

        $newDate = strtotime($model->getStartDate());

        /*
         * If a certain number of times that event should be formed is given, generate event that number of times
         */
        if ($model->getRepetitionType() == "N_TIMES") {
            for ($i = 0; $i < $model->getNoOfOccurrences(); $i++) {
                $model->setStartDate(date('Y-m-d', $newDate));
                $model->addARecurringEvent();
                $newDate = strtotime("+" . $model->getRepetitionCycle() . "year", $newDate);
            }
        /*
         *  If the end date is given, generate events up until that date
         */
        } else if ($model->getRepetitionType() == "UP_UNTIL") {
            while ($newDate < strtotime($model->getEndDate())) {
                $model->setStartDate(date('Y-m-d', $newDate));
                $model->addARecurringEvent();
                $newDate = strtotime("+" . $model->getRepetitionCycle() . "year", $newDate);
            }
        /*
         *  If an unlimited repetition type is set, generate one event, the rest generate when a period is given
         */
        } else if ($model->getRepetitionType() == "UNLIMITED") {

            $model->addARecurringEvent();
        }
    }
    /*
     *  Generates events which have recurring type : daily
     */
    public static function generateDailyEvents(EventModel $model)
    {

        if ($model->getRepetitionCycle() == 0)
            $model->setRepetitionCycle(1);

        $newDate = strtotime($model->getStartDate());

        /*
         * If a certain number of times that event should be formed is given, generate event that number of times
         */
        if ($model->getRepetitionType() == "N_TIMES") {
            for ($i = 0; $i < $model->getNoOfOccurrences(); $i++) {
                $model->setStartDate(date('Y-m-d', $newDate));
                $model->addARecurringEvent();
                $newDate = strtotime("+" . $model->getRepetitionCycle() . "day", $newDate);
            }
       /*
        *  If the end date is given, generate events up until that date
        */
        } else if ($model->getRepetitionType() == "UP_UNTIL") {
            while ($newDate < strtotime($model->getEndDate())) {
                $model->setStartDate(date('Y-m-d', $newDate));
                $model->addARecurringEvent();
                $newDate = strtotime("+" . $model->getRepetitionCycle() . "day", $newDate);
            }
       /*
        *  If an unlimited repetition type is set, generate one event, the rest generate when a period is given
        */
        } else if ($model->getRepetitionType() == "UNLIMITED") {
            $model->setStartDate(date('Y-m-d', $newDate));
            $model->addARecurringEvent();
        }


    }

    /*
     *  Generates events which have recurring type : monday-wednesday-friday
     */
    public static function generateMondayWednesdayFridayEvents(EventModel $model)
    {
        /*
         * Find first monday, first wednesday and first friday
         */
        $currentDate = strtotime($model->getStartDate());
        for ($i = 0; $i < 7; $i++) {
            if (date('D', $currentDate) == 'Mon')
                $firstMonday = $currentDate;
            if (date('D', $currentDate) == 'Wed')
                $firstWednesday = $currentDate;
            if (date('D', $currentDate) == 'Fri')
                $firstFriday = $currentDate;

            $currentDate = strtotime("+1 day", $currentDate);
        }
        $nextMonday = $firstMonday;
        $nextWednesday = $firstWednesday;
        $nextFriday = $firstFriday;

        /*
        * If a certain number of times that event should be formed is given, generate event that number of times
        */
        if ($model->getRepetitionType() == "N_TIMES") {

            for ($i = 0; $i < $model->getNoOfOccurrences(); $i++) {
                $model->setStartDate(date('Y-m-d', $nextMonday));
                $model->addARecurringEvent();
                $model->setStartDate(date('Y-m-d', $nextWednesday));
                $model->addARecurringEvent();
                $model->setStartDate(date('Y-m-d', $nextFriday));
                $model->addARecurringEvent();

                $nextMonday = strtotime("+7 day", $nextMonday);
                $nextWednesday = strtotime("+7 day", $nextWednesday);
                $nextFriday = strtotime("+7 day", $nextFriday);
            }
        /*
         *  If the end date is given, generate events up until that date
         */
        } else if ($model->getRepetitionType() == "UP_UNTIL") {
            while ($nextMonday < strtotime($model->getEndDate()) || $nextWednesday < strtotime($model->getEndDate()) || $nextFriday < strtotime($model->getEndDate())) {
                $model->setStartDate(date('Y-m-d', $nextMonday));
                $model->addARecurringEvent();
                $model->setStartDate(date('Y-m-d', $nextWednesday));
                $model->addARecurringEvent();
                $model->setStartDate(date('Y-m-d', $nextFriday));
                $model->addARecurringEvent();

                $nextMonday = strtotime("+7 day", $nextMonday);
                $nextWednesday = strtotime("+7 day", $nextWednesday);
                $nextFriday = strtotime("+7 day", $nextFriday);
            }
        /*
         *  If an unlimited repetition type is set, generate one event, the rest generate when a period is given
         */
        } else if ($model->getRepetitionType() == "UNLIMITED") {
            $model->setStartDate(date('Y-m-d', $nextMonday));
            $model->addARecurringEvent();
            $model->setStartDate(date('Y-m-d', $nextWednesday));
            $model->addARecurringEvent();
            $model->setStartDate(date('Y-m-d', $nextFriday));
            $model->addARecurringEvent();
        }
    }

    /*
     *  Generates all events
     */
    public static function generateEvents(EventModel $model)
    {
        /*
         *  RECURRING TYPE WEEKLY
         */

        if ($model->getRecurringType() == "WEEKLY")
            EventGenerator::generateWeeklyEvents($model);

        /*
         * RECURRING TYPE YEARLY
         */
        else if ($model->getRecurringType() == "YEARLY")
            EventGenerator::generateYearlyEvents($model);

        /*
         * RECURRING TYPE DAILY
         */
        else if ($model->getRecurringType() == "DAILY")
            EventGenerator::generateDailyEvents($model);

        /*
         *  RECURRING TYPE MONDAY - WEDNESDAY - FRIDAY
         */
        else if ($model->getRecurringType() == "MWF")
            EventGenerator::generateMondayWednesdayFridayEvents($model);

        else {
            /*
             *  RECURRING TYPE WEEKLY
             */
            $model->getDataForCustomType();
            if ($model->getCustomRecurringTypeForName($model->getRecurringType()) == "WEEKLY")
                EventGenerator::generateWeeklyEvents($model);

            /*
             * RECURRING TYPE YEARLY
             */
            else if ($model->getCustomRecurringTypeForName($model->getRecurringType()) == "YEARLY")
                EventGenerator::generateYearlyEvents($model);

            /*
             * RECURRING TYPE DAILY
             */
            else if ($model->getCustomRecurringTypeForName($model->getRecurringType()) == "DAILY")
                EventGenerator::generateDailyEvents($model);

            /*
             *  RECURRING TYPE MONDAY - WEDNESDAY - FRIDAY
             */
            else if ($model->getCustomRecurringTypeForName($model->getRecurringType()) == "MWF")
                EventGenerator::generateMondayWednesdayFridayEvents($model);
        }
    }
}