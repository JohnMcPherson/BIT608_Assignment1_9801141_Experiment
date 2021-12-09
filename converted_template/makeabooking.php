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
    // TODO check that we can convert checkindate and checkoutdate fields to a suitable date format
    // when we do the back-end. (Should be fine - but check at that stage)

    // When the page DOM is ready: setup checkindate and checkoutdate formatting and event listeners
    $(document).ready( function() {
        // set to NZ date format
        var localDateFormat = "dd/mm/yy";
        var numMonthsDisplayed = 2

        // setup checkindate with jquery datepicker
        var checkindate = $("#checkindate");
        checkindate.datepicker({
            changeMonth: true,
            changeYear: true,
            numberOfMonths: numMonthsDisplayed,
            dateFormat : localDateFormat
        });
        checkindate.on( "change", function() {
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
            checkindate.datepicker( "option", "maxDate", getDateOfPreviousDay( this));
        });


        // date functions to support checkin day is always less than checkout day
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
<h2><a href='bookingslisting.php'>[Return to the Bookings listing]</a><a href="/bnb/converted_template/">[Return to main
        page]</a></h2>
<h2>Booking for [name of logged in user]</h2>
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

  