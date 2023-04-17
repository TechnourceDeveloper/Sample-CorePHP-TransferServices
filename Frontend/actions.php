<?php

include '../functions.php';

$fetchdata = new DB_con(); 

if(isset($_POST["action"]))  
{  
	if($_POST["action"] == "drivers")  
	{  
	    echo $fetchdata->get_drivers($_POST);
	} 

	if($_POST["action"] == "vehicles")  
	{  
	    echo $fetchdata->get_vehicles($_POST);
	}

	if($_POST["action"] == "list")  
	{  
	    echo $fetchdata->get_booking_list($_POST);
	}  

	if($_POST["action"] == "submit")  
	{  
	    echo $fetchdata->submit($_POST);
	}  
} 


