<html>
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="javascript/mainJS.js"></script>
    <link href="css/basic-grey.css" type="text/css" rel="stylesheet" />

</head>
<body>
<form method="post" action="index.php?action=showevents" class="basic-grey">
    <label>
        <h1>Show events</h1>
    </label>
    <label>
        <span>Date from</span>
        <input type="text" name="dateFrom" id="dateFrom">
    </label>
    <label>
        <span>Date To</span>
        <input type="text"  name="dateTo" id="dateTo">
    </label>
    <label>
        <button type="button" id="newEventButton" onclick="window.location.href = 'index.php?page=createevent'">New Event</button>
        <input type="submit"  id="showButton" value="Show" /><br /><br /><br />
    </label>
    <label id="eventShow">
        <?php foreach($event as $member)
                echo $member; ?>
    </label>
</form>

</body>
</html>
