/**
 * Created by Milos on 20.10.2014.
 */
$(function() {
    $( "#dateFrom").datepicker();
    $( "#dateTo").datepicker();
});

$(function() {
    $( "#dateFrom").datepicker();
    $( "#dateUntil").datepicker();
    $( "#dateEnd").datepicker();

});

function hide(){
    document.getElementById('repeatType').style.display = "none";

    document.getElementById('repeatType').reset();
}

function show(){

    if(document.getElementById('repeatCheckbox').checked == true)
    {
        document.getElementById('repeatType').style.display = "initial";

    }
    else{
        document.getElementById('repeatType').style.display = "none";
    }
}

function hideOptions() {
    var value = document.getElementById('repetitionTypeSelect').value;

    if (value == 'DAILY' || value == 'YEARLY') {
        document.getElementById('dayChooser').style.display = "none";
        document.getElementById('repeatNo').style.display = "block";
        document.getElementById('hideIfCustom').style.display = "block";
        checkboxes(false);
    }
    else if (value == 'WEEKLY') {
        document.getElementById('dayChooser').style.display = "block";
        document.getElementById('repeatNo').style.display = "block";
        document.getElementById('hideIfCustom').style.display = "block";
        checkboxes(false);
    }
    else if (value == 'MWF') {
        document.getElementById('dayChooser').style.display = "block";
        document.getElementById('repeatNo').style.display = "none";
        document.getElementById('hideIfCustom').style.display = "block";
        checkboxes(true);
    }
    else
    {
        document.getElementById('hideIfCustom').style.display = "none";
    }


}

    function checkboxes(checked)
    {

        document.getElementById('dayMonday').checked = checked;
        document.getElementById('dayMonday').disabled = checked;

        document.getElementById('dayWednesday').checked = checked;
        document.getElementById('dayWednesday').disabled = checked;

        document.getElementById('dayFriday').checked = checked;
        document.getElementById('dayFriday').disabled = checked;

        document.getElementById('dayTuesday').disabled = checked;
        document.getElementById('dayThursday').disabled = checked;
        document.getElementById('daySaturday').disabled = checked;
        document.getElementById('daySunday').disabled = checked;
    }