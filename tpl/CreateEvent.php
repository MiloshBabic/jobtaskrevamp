<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create a new event</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link href="css/basic-grey.css" type="text/css" rel="stylesheet" />
    <script src="javascript/mainJS.js"></script>

</head>
<body onload="hide()">

<form action="index.php?page=createevent&action=eventsubmitted" method="post" class="basic-grey">
    <h1>Create an event</h1>

    <label>
        <span>Title</span>
        <input  type="text" name="title" maxlength="500" required>
    </label>
    <label>
        <span>Event description</span>
        <input  type="text" name="description" maxlength="500" required>
    </label>

    <label>
        <span>Date from</span>
        <input type="text" name="dateFrom" id="dateFrom" required>
    </label>

    <label>
        <span>Repeat</span>
        <input onclick="show()" type="checkbox" id="repeatCheckbox" value="yes" name="repeat" maxlength="30">
    </label>
    <div id="repeatType">
        <label >
            <span>Repeats</span>

            <select id="repetitionTypeSelect" name="recurringType" onchange="hideOptions()">
              <?php
               for($i = 0; $i < count($data); $i++)
                   echo  "<option value='". $data[$i] . "' > ". strtolower($data[$i]) . "</option>";
               ?>

            </select>
        </label>
        <div id="hideIfCustom">
            <div id="repeatNo">
                <label>
                    <span>Repeat every</span>
                    <input type="text" name="repeatCount" id="repeatCount">
                </label>
            </div>
            <div id="dayChooser">
                <label>
                    <span>Repeat on</span>
                    <input type="checkbox" id="dayMonday" name="day[]" value="64" >
                    <span class="weekday">M</span>
                    <input type="checkbox" id="dayTuesday" name="day[]" value="32" >
                    <span class="weekday">T</span>
                    <input type="checkbox" id="dayWednesday" name="day[]" value="16" >
                    <span class="weekday">W</span>
                    <input type="checkbox" id="dayThursday" name="day[]"  value="8">
                    <span class="weekday">T</span>
                    <input type="checkbox" id="dayFriday" name="day[]"  value="4">
                    <span class="weekday">F</span>
                    <input type="checkbox" id="daySaturday" name="day[]"  value="2">
                    <span class="weekday">S</span>
                    <input type="checkbox" id="daySunday" name="day[]" value="1" >
                    <span class="weekday">S</span>
                </label>
            </div>
            <label>
                <span>Ends</span>
                <input type="radio" name="occurrenceType" id="occurrenceNever"  value="UNLIMITED" checked="checked">Never<br>
                <span></span>
                <input type="radio" name="occurrenceType" id="occurrenceAfter" value="N_TIMES" ">After
                <input  type="text" name="numberOfOccurrences" id="numberOfOccurrences" class="occurrences"> occurrences<br>
                <input type="radio" name="occurrenceType"  id="occurrenceDate" value="UP_UNTIL" ">On
                <span></span>
                <input type="text" name="dateEnd" id="dateEnd" class="occurrences">
            </label>
        </div>
    </div>



        <span>&nbsp;</span>
        <input type="button" class="button" value="Cancel" onclick="window.location.href = 'index.php'" />
        <input type="button" class="button" value="New Recurring Type" onclick="window.location.href = 'index.php?page=createrecurringtype'" />
        <input type="submit" class="button" value="Send" />

    </label>


</form>



</body>
</html>