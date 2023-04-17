<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Multistep form</title>
  <link rel="stylesheet" href="booking.css">
    <body>
        <?php
            include 'menu.php';
            include '../functions.php';
            $fetchdata = new DB_con();
        ?>
        <div class="container">
            <header>Check Your Bookings</header>
            <div class="form-outer">
                <form action="#">
                    <div class="page slide-page">
                        <div class="field">
                            <div class="label">Email</div>
                            <input type="email" name="email" id="email" required />
                        </div>
                        <div class="field">
                            <button class="firstNext next">Confirm</button>
                        </div>
                    </div>

                    <div class="page">
                        <div id="booking_list"></div>
                        <div class="field">
                            <button><a href="booking.php">back</a></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
        <script src="booking.js"></script>
    </body>
</html>
