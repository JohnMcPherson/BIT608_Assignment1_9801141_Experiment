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
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}
// TODO include ajax to query the database to populate the room field

//prepare a query and send it to the server
$query = 'SELECT roomID,roomname,roomtype FROM room ORDER BY roomtype';
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result); 
?>
<h1>Make a Booking</h1>
<h2><a href='junk.php'>[Return to the Bookings listing]</a><a href="/bnb/converted_template/">[Return to main page]</a></h2>
<h2>Booking for [name of logged in user]</h2>
<form method="POST" action="makeabooking.php">
    <p>
        <label for="room">Room (name,type,beds):</label>
        <select type="text" id ="room" list="rooms" name="room">
            // the following values are test values to be
            // removed once the back-end connection is done
            <option value = "1">Kellie,S,5</option>
            <option value = "2">Herman,D,5</option>
        </select>
    </p>
    <p>
        <label for="checkindate">Checkin date: </label>
        <input type="date" id="checkindate" name="checkindate" required>
    </p>
    <p>
        <label for="checkoutdate">Checkout date: </label>
        <input type="date" id="checkoutdate" name="checkoutdate" required>
    </p>
    <p>
        <label for="contactnumber">Contact number: </label>
        <input type="text" id="contactnumber" name="contactnumber" required
               pattern="^\([0-9][0-9][0-9]\) [0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]$"
               placeholder="(###) ###-####"
    </p>

    <input type="submit" name="submit" value="Register">
</form>
<?php
mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done

echo '</div></div>';
require_once "footer.php";
?>

  