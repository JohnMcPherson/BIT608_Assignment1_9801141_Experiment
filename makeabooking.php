<!--
ASSUMPTIONS

Clients cannot set a check-in date earlier than today

Clients will be booking from NZ, and their web client will working in NZ time

The 'logged in" user is hardcoded as Test (in "Booking for Test")

Styling is not part of the assignment. But the stylesheet is included to make the datepicker
(a bit) more readable. I want the 2 months to display horizontally, but I will leave that to
when full styling is applied
-->


<body>
<link rel="stylesheet" type="text/css" href="style/style.css" title="style"/>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
    // TODO check that we can convert checkindate and checkoutdate fields
    // to a date format suitable for the back end. (Datepicker works with text, not date).
    // (Should be fine - but check when we do the back end)

    // When the page DOM is ready: set-up checkindate and checkoutdate formatting and event listeners
    $(document).ready( function() {
        // set to NZ date format
        var localDateFormat = "dd/mm/yy";
        var numMonthsDisplayed = 3;

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
<h2><a href=''>[Return to the Bookings listing]</a><a href="">[Return to main
        page]</a></h2>
<h2>Booking for Test</h2>
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
            <input class="booking" type="text" id="checkindate" name="checkindate" required autocomplete="off">
        </p>
        <p>
            <span><label for="checkoutdate">Checkout date:</label></span>
            <input class="booking" type="text" id="checkoutdate" name="checkoutdate" required autocomplete="off">
        </p>
        <p>
            <span><label for="contactnumber">Contact number:</label></span>
            <input class="booking" type="text" id="contactnumber" name="contactnumber" required
                   pattern="^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$"
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

  