# Sample-CorePHP-TransferServices

This is a code sample from one of our projects for review.
# Installation
Compatible with php 7.0,7.4 or 8.1 

1) Clone bitbucket
```bash
   git clone https://github.com/TechnourceDeveloper/Sample-CorePHP-TransferServices.git
```   
2) Set below varibales for database connection with your database in functions.php
 ```bash
   $host = "localhost" // host
   $username = 'root'  // user
	$password = ''  //password
	$database = 'bookings'  //database

 ```
 3) How to Run the Project
  - This repository must be run on a virtual host. The steps below explain how to set up a virtual host.
  - For MacOS, Run project by setting up virtual host -
https://laravel-school.com/posts/how-to-set-up-the-virtual-host-on-macos-59

- For Windows OS and xampp server, Run project using -
http://localhost:80/Sample-CorePHP-TransferServices/ 
Or you can also setup virtual host by following below link-
https://www.educative.io/answers/how-to-set-up-virtual-hosts-on-windows

 - For Ubuntu, Run project by setting up virtual host-
https://www.vultr.com/docs/set-up-virtual-hosts-with-apache-on-ubuntu-20-04-lts

# Project Description

 - It is a Vehicle Booking System.
 - User will have to select pick up & drop up locations, with number of passengers and date time.
 - Vehicles will be available based on passengers.
 - Drivers will be allocated according to pick up or drop up address.
 - In the final step syestem will ask for type selection like Individual or Agnecy.
 - User can visit their booked details by given email.
 - No login page available, Backend menu display list of Addresses,Drivers,Customers,Customer Bookings,Vechicle classes,Vehicles  
