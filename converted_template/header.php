<!DOCTYPE HTML>
<html>

<head>
    <title>Ongaonga Bed & Breakfast</title>
    <meta name="description" content="Ongaonga Bed & Breakfast"/>
    <meta name="keywords" content="Bed & Breakfast"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="style/style.css" title="style"/>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script>
        $(document).ready( function() {
            var dateFormat = "dd/mm/yy";
            var from = $("#from");
            from.datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 3
            });
            from.on( "change", function() {
                to.datepicker( "option", "minDate", getDate( this ) );
            })
            var to = $( "#to" );
            to.datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 3
            });
            to.on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
            });

            function getDate( element ) {
                var date;
                try {
                    date = $.datepicker.parseDate( dateFormat, element.value );
                } catch( error ) {
                    date = null;
                }

                return date;
            }
        } );
    </script>
</head>

<body>
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
            <input class="booking" type="date" id="checkindate" name="checkindate" required>
        </p>
        <p>
            <span><label for="checkoutdate">Checkout date:</label></span>
            <input class="booking" type="date" id="checkoutdate" name="checkoutdate" required>
        </p>
        <p>
            <span><label for="contactnumber">Contact number:</label></span>
            <input class="booking" type="text" id="contactnumber" name="contactnumber" required
                   pattern="^\([0-9][0-9][0-9]\) [0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]$"
                   placeholder="(###) ###-####"
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

<div id="main">