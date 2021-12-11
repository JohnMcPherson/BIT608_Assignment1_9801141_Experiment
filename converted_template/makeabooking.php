// ASSUMPTIONS

// Clients cannot set a check in date earlier than today

// Clients will be booking from NZ, and their web client will working in NZ time

// Using ".$_SESSION['username']" to display the logged in user
// TODO change the display of the logged in user when we know what is required
// (may be in a later assignment)

<?php
include "header.php";
include "menu.php";
include "checksession.php";
loginStatus(); //show the current login status

echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';


include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; //stop processing the page further
}
// TODO include ajax to query the database to populate the room field
// TODO remove test values for roomid

//prepare a query and send it to the server
?>
<body>
<script>
    // TODO check that we can convert checkindate and checkoutdate fields
    // to a date format suitable for the back end. (Datepicker works with text, not date).
    // (Should be fine - but check when we do the back end)

    // When the page DOM is ready: setup checkindate and checkoutdate formatting and event listeners
    $(document).ready( function() {
        // set to NZ date format
        var localDateFormat = "dd/mm/yy";
        var numMonthsDisplayed = 2;

        // setup checkindate with jquery datepicker
        var checkindate = $("#checkindate");
        checkindate.datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: new Date(), // minDate is today
            numberOfMonths: numMonthsDisplayed,
            dateFormat : localDateFormat
        });
        checkindate.on( "change", function() {
            // allowable check out date is constrained by the (newly set) check in date
            checkoutdate.datepicker( "option", "minDate", getDateOfNextDay(this));
        })

        //setup checkoutdate with jquery datepicker
        var checkoutdate = $( "#checkoutdate" );
        checkoutdate.datepicker({
            changeMonth: true,
            changeYear: true,
            numberOfMonths: numMonthsDisplayed,
            dateFormat : localDateFormat
        });
        checkoutdate.on( "change", function() {
            // allowable check in date is constrained by the (newly set) check in date
            checkindate.datepicker( "option", "maxDate", getDateOfPreviousDay( this));
        });


        // date functions to support the rule that check in day is always less than check out day
        function getDateOfNextDay( element) {
            return getDateWithOffset(element, 1);
        }

        function getDateOfPreviousDay( element) {
            return getDateWithOffset(element, -1);
        }

        function getDateWithOffset( element , offset) {
            var date;
            try {
                date = $.datepicker.parseDate( localDateFormat, element.value );
                date.setDate(date.getDate() + offset)
            } catch( error ) {
                date = null;
            }
            return date;
        }
    } );
</script>
<h1>Make a Booking</h1>
<h2><a href='currentbookings.php'>[Return to the Bookings listing]</a><a href="/bnb/converted_template/">[Return to main
        page]</a></h2>
<?PHP
echo "<h2>Booking for ".$_SESSION['username']."</h2>"
?>
<form method="POST" action="makeabooking.php">
    <div class=form_settings>
        <p>
            <span><label for="roomid">Room (name,type,beds):</label></span>
            <select class="booking" id="roomid" name="room">
                // the following values are test values to be
                // removed once the back-end connection is done
                <option value="1">Kellie,S,5</option>
                <option value="2">Herman,D,5</option>
            </select>
        </p>
        <p>
            <span><label for="checkindate">Checkin date:</label></span>
            <input class="booking" type="text" id="checkindate" name="checkindate" required>
        </p>
        <p>
            <span><label for="checkoutdate">Checkout date:</label></span>
            <input class="booking" type="text" id="checkoutdate" name="checkoutdate" required>
        </p>
        <p>
            <span><label for="contactnumber">Contact number:</label></span>
            <input class="booking" type="text" id="contactnumber" name="contactnumber" required
                   pattern="^\([0-9][0-9][0-9]\) [0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]$"
                   placeholder="(###) ###-####">
        </p>
        <p>
            <span><label for="bookingextras">Booking Extras:</label></span>
            <textarea class="booking" id="bookingextras" name="bookingextras" rows="8" cols="50"></textarea>
        </p>

        <p style="padding-top: 15px">
            <span>&nbsp;</span><input class="submit" type="submit" name="booking_submitted" value="Book"/>
        </p>
    </div>
</form>
</body>
<?php
mysqli_close($DBC); //close the connection once done

echo '</div></div>';
require_once "footer.php";
?>

  