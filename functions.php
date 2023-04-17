<?php

error_reporting(E_ALL);

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

class DB_con
{
    public $connect;  
	private $host = "localhost";  
	private $username = 'root';  
	private $password = '';  
	private $database = 'bookings'; 

	/**
	 * Execute Database Connection 
	 */
    public function __construct()
	{
		$this->database_connect();
	}

	/**
	 * Create Database Connection 
	 */
	public function database_connect()  
    {  
        $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);  
    } 

	/**
	 * Execution of Database Query
	 *
	 * @param string $query
	 * @return mysqli_result|bool
	 */
    public function execute_query($query)  
    {  
       return mysqli_query($this->connect, $query);  
    } 

	/**
	 * Get Addresses dropdown
	 *
	 * @param int $type
	 * @return string
	 */
    public function get_address($type)  
    {  
       $output = '';  
       $result = $this->execute_query('SELECT * FROM addresses');  
       $output .= '<select class="form-control" name='.$type.' id="'.$type.'" required>';
       $output .= '<option value="">-- Address --</option>';
       while($row = mysqli_fetch_object($result))  
       {  
           $output .= '<option value="'.$row->id.'">'.$row->full_address.'</option>';  
       }  
       $output .= '</select>';  
       return $output;  
    } 

	/**
	 * Get Address table
	 *
	 * @return string
	 */
    public function get_address_table()  
    {  
       $output = '';  
       $result = $this->execute_query('SELECT * FROM addresses');  
       $output .= '  
       <table class="table table-bordered table-striped display dataTable">  
            <thead>
            <tr>  
                 <th>ID</th>
                 <th>Full Address</th>  
                 <th>Latitude</th>  
                 <th>Longitude</th>
                 <th>Created At</th>  
                 <th>Update</th>  
                 <th>Delete</th>  
            </tr>
            </thead>
			<tbody> 
       ';  
       while($row = mysqli_fetch_object($result))  
       {  
            $output .= '  
            <tr>       
                 <td>'.$row->id.'</td>
                 <td>'.$row->full_address.'</td>  
                 <td>'.$row->latitude.'</td>  
                 <td>'.$row->longitude.'</td> 
                 <td>'.$row->created_at.'</td>  
                 <td><button type="button" name="update" data-id="'.$row->id.'" class="btn btn-success btn-xs update">Update</button></td>  
                 <td><button type="button" name="delete" data-id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button></td>  
            </tr> 
            ';  
       }  
       $output .= '</tbody></table>';  
       return $output; 
    } 

	/**
	 * Get Driver table
	 *
	 * @return string
	 */
    public function get_driver_table()  
    {  
       $output = '';  
       $result = $this->execute_query('SELECT * FROM drivers INNER JOIN addresses ON drivers.address_id = addresses.id');  
       $output .= '<table class="table table-bordered table-striped display dataTable">  
                <thead>
                <tr>  
                     <th>ID</th>
                     <th>Full Name</th>
                     <th>Email</th>
                     <th>Full Address</th>  
                     <th>Driving License No</th>  
                     <th>Phone</th>
                     <th>Created At</th>  
                     <th>Update</th>  
                     <th>Delete</th>  
                </tr>
                </thead>
    			<tbody> ';  
           while($row = mysqli_fetch_object($result))  
           {  
                $output .= '<tr>       
                     <td>'.$row->id.'</td>
                     <td>'.$row->fullname.'</td>
                     <td>'.$row->email.'</td>
                     <td>'.$row->full_address.'</td>  
                     <td>'.$row->driving_license_no.'</td>  
                     <td>'.$row->phone.'</td> 
                     <td>'.$row->created_at.'</td>  
                     <td><button type="button" name="update" data-id="'.$row->id.'" class="btn btn-success btn-xs update">Update</button></td>  
                     <td><button type="button" name="delete" data-id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button></td>  
                </tr>';  
           }  
        $output .= '</tbody></table>';  
        return $output; 
    }

	/**
	 * Get Drivers list by pick or drop address
	 *
	 * @param array $data
	 * @return string
	 */
	public function get_drivers($data = null)  
    {  
	     $output = ''; 
	  
	     $query = 'SELECT *,drivers.id as driver_id FROM drivers INNER JOIN addresses ON drivers.address_id = addresses.id';
	  
	     $pick = mysqli_real_escape_string($this->connect,$data['pick']);
	     $drop = mysqli_real_escape_string($this->connect,$data['drop']);
	  
	     if($pick || $drop){
	       	$query .= ' WHERE address_id = '.$pick.' OR address_id = '.$drop.'';
	     }

	     $result = $this->execute_query($query);

	     if(mysqli_num_rows($result) > 0){
		     while($row = mysqli_fetch_object($result))  
		     {  
		          $all_drivers[] = $row->driver_id;
		     }

			$bookings = $this->execute_query('SELECT * FROM bookings WHERE `date` = "'.$data['date'].'" AND driver_id IN ('.implode(',',$all_drivers).')');

			if(mysqli_num_rows($bookings) > 0){
				while($rows = mysqli_fetch_object($bookings))  
				{  
					$booked_drivers[] = $rows->driver_id;
				}
				$available_drivers = array_diff($all_drivers,$booked_drivers);
			}else{
				$available_drivers = $all_drivers;
			}

			$final_query = 'SELECT *,drivers.id as driver_id FROM drivers INNER JOIN addresses ON drivers.address_id = addresses.id WHERE drivers.id = '.$available_drivers[array_rand($available_drivers, 1)].'';

			$final_result = $this->execute_query($final_query);
	    }  

		if(mysqli_num_rows($final_result) > 0){
	          $output .= '<table class="table table-bordered table-striped">  
	               <tr>  
	                    <th>Full Name</th>
	                    <th>Email</th>
	                    <th>Full Address</th>  
	                    <th>Driving License No</th>  
	                    <th>Phone</th> 
	               </tr>';  
	          while($final_row = mysqli_fetch_object($final_result))  
	          {  
	               $output .= '<tr>       
	                    <td><input type="hidden" data-id="'.$final_row->driver_id.'" name="driver_id" class ="driver_id" value="'.$final_row->driver_id.'">'.$final_row->fullname.'</td>
	                    <td>'.$final_row->email.'</td>
	                    <td>'.$final_row->full_address.'</td>  
	                    <td>'.$final_row->driving_license_no.'</td>  
	                    <td>'.$final_row->phone.'</td>  
	               </tr>';  
	          }  
	          $output .= '</table>';  
	          return $output;
          }else{
	     	return '<br><h3>No Relevant Drivers found according to pick & drop location</h3>';
	     } 
    }  

	/**
	 * Get User Table
	 *
	 * @return string
	 */
	public function get_user_table()  
	{  
        $output = '';  
        $result = $this->execute_query('SELECT * FROM users');  
        $output .= '  
        <table class="table table-bordered table-striped display dataTable">  
            <thead>
            <tr>  
                 <th>ID</th>
                 <th>Full Name</th>
                 <th>Email</th>
                 <th>Phone</th>  
                 <th>Type</th>  
                 <th>Agency ID</th>
                 <th>Created At</th>  
                 <th>Update</th>  
                 <th>Delete</th>  
            </tr>
            </thead>
            <tbody>
       ';  
        while($row = mysqli_fetch_object($result))  
        {  
            $output .= '  
            <tr>       
                 <td>'.$row->id.'</td>
                 <td>'.$row->fullname.'</td>
                 <td>'.$row->email.'</td>
                 <td>'.$row->phone.'</td>  
                 <td>'.$row->type.'</td>  
                 <td>'.$row->agency_id.'</td> 
                 <td>'.$row->created_at.'</td>  
                 <td><button type="button" name="update" data-id="'.$row->id.'" class="btn btn-success btn-xs update">Update</button></td>  
                 <td><button type="button" name="delete" data-id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button></td>  
            </tr>  
            ';  
        }  
        $output .= '</tbody></table>';  
        return $output; 
	} 

	/**
	 * Get Booking Table
	 *
	 * @return string
	 */
	public function get_booking_table()  
	{  
	    $output = '';  
	    $result = $this->execute_query('SELECT * FROM bookings 
	    INNER JOIN drivers ON bookings.driver_id = drivers.id 
	    INNER JOIN addresses ON bookings.from_address_id = addresses.id
	    INNER JOIN vehicles ON bookings.vehicle_id = vehicles.id');  
	    $output .= '  
	        <table class="table table-bordered table-striped display dataTable">  
	            <thead>
	            <tr>  
	                 <th>ID</th>
	                 <th>From Address</th>
	                 <th>To Address</th>
	                 <th>Vehicle</th>
	                 <th>Driver</th>  
	                 <th>No Of Passengers</th>  
	                 <th>Date</th>
	                 <th>Time</th>
	                 <th>Created At</th>  
	                 <th>Update</th>  
	                 <th>Delete</th>  
	            </tr>
	            </thead>
	            <tbody>
	       ';  
	       while($row = mysqli_fetch_object($result))  
	       {  
	            $output .= '  
	            <tr>       
	                 <td>'.$row->id.'</td>
	                 <td>'.$row->full_address.'</td>
	                 <td>'.$row->full_address.'</td>
	                 <td>'.$row->name.'</td>
	                 <td>'.$row->fullname.'</td>  
	                 <td>'.$row->no_of_passengers.'</td>
	                 <td>'.$row->date.'</td>
	                 <td>'.$row->time.'</td>  
	                 <td>'.$row->created_at.'</td>  
	                 <td><button type="button" name="update" data-id="'.$row->id.'" class="btn btn-success btn-xs update">Update</button></td>  
	                 <td><button type="button" name="delete" data-id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button></td>  
	            </tr>  
	            ';  
	        }  
       $output .= '</tbody></table>';  
       return $output; 
	} 

	/**
	 * Get Booking List
	 *
	 * @param array $data
	 * @return string
	 */
	public function get_booking_list($data)  
	{  
	    $output = '';  
	    $query = 'SELECT * FROM booking_customer_details 
	    INNER JOIN bookings ON booking_customer_details.booking_id = bookings.id
	    INNER JOIN users ON booking_customer_details.customer_id = users.id
	    INNER JOIN addresses ON bookings.from_address_id = addresses.id
	    INNER JOIN vehicles ON bookings.vehicle_id = vehicles.id'; 

	    $email = mysqli_real_escape_string($this->connect,$data['email']);
         
        if(!empty($email)){
        	$query .= ' WHERE users.email = "'.$email.'"';
        } 

        $result = $this->execute_query($query);
       	if(mysqli_num_rows($result) > 0){ 
	        $output .= '  
	       <table class="table table-bordered table-striped">  
	            <thead>
	            <tr>  
	                 <th>From Address</th>
	                 <th>To Address</th>
	                 <th>Vehicle</th>
	                 <th>Driver</th>  
	                 <th>No Of Passengers</th>  
	                 <th>Date</th>
	                 <th>Time</th>
	            </tr>
	            </thead>
	            <tbody>
	       ';  
	       while($row = mysqli_fetch_object($result))  
	       {  
	            $output .= '  
	            <tr>       
	                 <td>'.$row->full_address.'</td>
	                 <td>'.$row->full_address.'</td>
	                 <td>'.$row->name.'</td>
	                 <td>'.$row->fullname.'</td>  
	                 <td>'.$row->no_of_passengers.'</td>
	                 <td>'.$row->date.'</td>
	                 <td>'.$row->time.'</td>  
	            </tr>  
	            ';  
	       }  
	       $output .= '</tbody></table>';  
	       return $output; 
	    }else{
	    	return '<p>No Bookings found</p>';
	    }
	} 

	/**
	 * Get vehicle class Table
	 *
	 * @return string
	 */
	public function get_vehicle_class_table()  
	{  
        $output = '';  
        $result = $this->execute_query('SELECT * FROM vehicle_classes');  
        $output .= '  
        <table class="table table-bordered table-striped display dataTable">  
            <thead>
            <tr>  
                 <th>ID</th>
                 <th>Class Name</th>
                 <th>Created At</th>  
                 <th>Update</th>  
                 <th>Delete</th>  
            </tr>
            </thead>
            <tbody>
        ';  
        while($row = mysqli_fetch_object($result))  
        {  
            $output .= '  
            <tr>       
                 <td>'.$row->id.'</td>
                 <td>'.$row->class_name.'</td> 
                 <td>'.$row->created_at.'</td>  
                 <td><button type="button" name="update" data-id="'.$row->id.'" class="btn btn-success btn-xs update">Update</button></td>  
                 <td><button type="button" name="delete" data-id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button></td>  
            </tr>  
            ';  
        }  
        $output .= '</tbody></table>';  
        return $output; 
	} 

	/**
	 * Get Vehicle Table
	 *
	 * @return string
	 */
	public function get_vehicle_table()  
	{  
	     $output = '';  
	     $result = $this->execute_query('SELECT * FROM vehicles INNER JOIN vehicle_classes ON vehicles.class_id = vehicle_classes.id'); 
		$output .= '  
		       <table class="table table-bordered table-striped display dataTable">  
		            <thead>
		            <tr>  
		                 <th>ID</th>
		                 <th>Name</th>
		                 <th>Class</th>
		                 <th>Price</th>
		                 <th>Offer Price</th>
		                 <th>No of Passengers</th>
		                 <th>Created At</th>  
		                 <th>Update</th>  
		                 <th>Delete</th>  
		            </tr>  
		            </thead>
		            <tbody>
		       ';  
		    while($row = mysqli_fetch_object($result))  
		    {  
				$output .= '  
				<tr>       
						<td>'.$row->id.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->class_name.'</td>
						<td>'.$row->price.'</td> 
						<td>'.$row->offer_price.'</td>
						<td>'.$row->no_of_passengers.'</td>
						<td>'.$row->created_at.'</td>  
						<td><button type="button" name="update" data-id="'.$row->id.'" class="btn btn-success btn-xs update">Update</button></td>  
						<td><button type="button" name="delete" data-id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button></td>  
				</tr>  
				';  
		    }  
		$output .= '</tbody></table>';  
		return $output;
	}
	
	/**
	 * Get Vehicles Table
	 *
	 * @param array $data
	 * @return string
	 */
	public function get_vehicles($data = null)
	{
		$output = '';
				
		$query = 'SELECT *,vehicles.id as vehicle_id FROM vehicles INNER JOIN vehicle_classes ON vehicles.class_id = vehicle_classes.id';

		if($data['passengers']){
			$query .= ' WHERE no_of_passengers = '.$data['passengers'].'';
		}

		$result = $this->execute_query($query);

		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_object($result))  
			{  
				$output .= '<label class="card"><input name="vehicle_id" class="radio vehicle_id" type="radio" value='.$row->vehicle_id.'> <div class="card-image"> <span class="card-notify-badge car_name">'.$row->name.'</span> <img class="img-fluid" src="https://imageonthefly.autodatadirect.com/images/?USER=eDealer&PW=edealer872&IMG=CAC80HOC021B121001.jpg&width=440&height=262" alt="Car" /> </div> <div class="card-image-overlay m-auto"> <span class="card-detail-badge car_class_name">'.$row->class_name.'</span> <span class="card-detail-badge car_price">$'.$row->price.'</span> <span class="card-detail-badge">$'.$row->offer_price.'</span> <span class="card-detail-badge car_offer_price">'.$row->no_of_passengers.'Seater</span> </div> <div class="card-body text-center"></div> </label>';
			}
		}else{
     		$output.= '<br><h3>No Relevant vehicles found according to number of passengers</h3>';
    		} 

	    return $output; 
	}

	/**
	 * Create Booking with cutomer details
	 *
	 * @param array $data
	 * @return int
	 */
	public function submit($data)
	{
		$from_address_id = mysqli_real_escape_string($this->connect, $data['pick']);
		$to_address_id = mysqli_real_escape_string($this->connect, $data['drop']);
		$vehicle_id = mysqli_real_escape_string($this->connect, $data['vehicle_id']);
		$driver_id = mysqli_real_escape_string($this->connect, $data['driver_id']);
		$no_of_passengers = mysqli_real_escape_string($this->connect, $data['passengers']);
		$date = mysqli_real_escape_string($this->connect, $data['date']);
		$time = mysqli_real_escape_string($this->connect, $data['time']);
		$user_type = mysqli_real_escape_string($this->connect,$data['user_type']);
		
		if(!empty($user_type)){
			$password = mysqli_real_escape_string($this->connect,$data['password']);
			if($user_type == 'individual'){
				$fullname = mysqli_real_escape_string($this->connect,$data['first_name']).' '.mysqli_real_escape_string($this->connect,$data['last_name']);
				$email = mysqli_real_escape_string($this->connect,$data['email']);
				$phone = mysqli_real_escape_string($this->connect,$data['phone']);
				$this->execute_query("insert into users(fullname,email,phone,type,password) values('$fullname','$email','$phone','$user_type','$password')");
				$customer_id = mysqli_insert_id($this->connect);
				$agency_id = 0;
			}else if($user_type == 'agency'){
				$agency_name = mysqli_real_escape_string($this->connect,$data['agency_name']);
				$agency_email = mysqli_real_escape_string($this->connect,$data['agency_email']);
				$agency_phone = mysqli_real_escape_string($this->connect,$data['agency_phone']);
				$agency_password = mysqli_real_escape_string($this->connect,$data['agency_password']);
				$fullname = mysqli_real_escape_string($this->connect,$data['agency_user_first_name']).' '.mysqli_real_escape_string($this->connect,$data['agency_user_last_name']);
				$email = mysqli_real_escape_string($this->connect,$data['agency_user_email']);
				$phone = mysqli_real_escape_string($this->connect,$data['agency_user_phone']);

				$this->execute_query("insert into users(fullname,email,phone,type,password) 
					values('$agency_name','$agency_email','$agency_phone','$user_type','$agency_password')");

				$agency_id = mysqli_insert_id($this->connect);
				
				$this->execute_query("insert into users(fullname,email,phone,type,agency_id) 
					values('$fullname','$email','$phone','$user_type','$agency_id')");

				$customer_id = mysqli_insert_id($this->connect);
			}
		}

		$this->execute_query("insert into bookings(from_address_id,to_address_id,vehicle_id,driver_id,no_of_passengers,date,time) 
		values('$from_address_id','$to_address_id','$vehicle_id','$driver_id','$no_of_passengers','$date','$time')");
		$booking_id = mysqli_insert_id($this->connect);

		$result = $this->execute_query("insert into booking_customer_details(booking_id,customer_id) 
		values('$booking_id','$customer_id')");

		//trigger mail
		try {
			$customer = $this->execute_query('SELECT * FROM users WHERE id IN ('.$customer_id.','.$agency_id.')');
			while($row = mysqli_fetch_object($customer))  
		    {
		    	$customer_name = mysqli_real_escape_string($this->connect,$row->fullname);
		    	$customer_email = mysqli_real_escape_string($this->connect,$row->email);
		    	$customer_pass = mysqli_real_escape_string($this->connect,$row->password);
		    	$this->sendMail($customer_email,$customer_name,$customer_pass);
		    }
		    return $result;
		}catch(Exception $e) {
		  return 0;
		}		
	}

	/**
	 * Send Mail after booking generated
	 *
	 * @return bool
	 */
	function sendMail($email,$name,$password = null) {
		$mail = new PHPMailer;
		// Server settings
		$mail->SMTPDebug = 3;                      // Enable verbose debug output
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'technource.test@gmail.com';                     // SMTP username
		$mail->Password   = 'aftopzliouibinte';                               // SMTP password
		$mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
		// Recipients
		$mail->setFrom('bookings@mailinator.com', 'Booking Mailer');
		$mail->addAddress($email,$name);     // Add a recipient
		//$mail->addAddress('ellen@mailinator.com');               // Name is optional
		$mail->addReplyTo('bookings@mailinator.com', 'Confirmation');
		//$mail->addCC('cc@mailinator.com');
		//$mail->addBCC('bcc@mailinator.com');
		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Booking Successful';
		$message_body = 'Congratulations! Your Booking has been generated successfully.';
		if($password){
			$message_body .= '<br> Your password is '.$password;
		}
		$mail->Body    = $message_body;
		$mail->AltBody = $message_body;
		$mail->send();
		return true;
	}	

	/**
	 * Close Database Connection
	 */
	public function __destruct(){
        $this->connect->close();
    }
}
?>