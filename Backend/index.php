<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
      <title>Bookings</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.0/css/intlTelInput.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="index.css">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  </head>
  <body>
    <?php
      include '../functions.php';
      $fetchdata = new DB_con();
    ?>
    <div class="tab">
      <button class="tablinks active" id="Addresses">Addresses</button>
      <button class="tablinks" id="Drivers">Drivers</button>
      <button class="tablinks" id="Customers">Customers</button>
      <button class="tablinks" id="Customer_Bookings">Customer Bookings</button>
      <button class="tablinks" id="Vehicle_classes">Vehicle classes</button>
      <button class="tablinks" id="Vehicle">Vehicle</button>
      <button class="pull-right"><a href="../Frontend">Home</a></button>
    </div>

    <div id="Addresses" class="tabcontent">
      <h3>Addresses</h3>
      <?= $fetchdata->get_address_table(); ?> 
    </div>

    <div id="Drivers" class="tabcontent">
      <h3>Drivers</h3>
      <?= $fetchdata->get_driver_table(); ?> 
    </div>

    <div id="Customers" class="tabcontent">
      <h3>Customers</h3>
      <?= $fetchdata->get_user_table(); ?> 
    </div>

    <div id="Customer_Bookings" class="tabcontent">
      <h3>Customer Bookings</h3>
      <?= $fetchdata->get_booking_table(); ?> 
    </div>

    <div id="Vehicle_classes" class="tabcontent">
      <h3>Vehicle classes</h3>
      <?= $fetchdata->get_vehicle_class_table(); ?> 
    </div>

    <div id="Vehicle" class="tabcontent">
      <h3>Vehicle</h3>
      <?= $fetchdata->get_vehicle_table(); ?> 
    </div>
    
    <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="index.js"></script>
  </body>
</html>