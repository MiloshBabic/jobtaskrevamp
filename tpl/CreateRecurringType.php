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

<form action="index.php?page=createrecurringtype&action=recurringTypeSubmitted" method="post" class="basic-grey">
    <h1>New recurring type</h1>

    <label>
        <span>Title</span>
        <input  type="text" name="title" maxlength="500" required>
    </label>
        <label >
            <span>Repeats</span>
            <select id="repetitionTypeSelect" name="recurringType" onchange="hideOptions()">
                <option value="WEEKLY"> Weekly </option>
                <option value="DAILY"> Daily </option>
                <option value="YEARLY"> Yearly </option>
                <option value="MWF"> Monday - Wednesday - Friday </option>
            </select>
        </label>
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


    <label>
        <span>&nbsp;</span>
        <input type="button" class="button" value="Cancel" onclick="window.location.href = 'index.php?page=createevent'" />
        <input type="submit" class="button" value="Send" />

    </label>


</form>



</body>
</html>