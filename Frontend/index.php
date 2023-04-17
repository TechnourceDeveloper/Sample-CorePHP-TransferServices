<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Multistep form</title>
      <link rel="stylesheet" href="booking.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.0/css/intlTelInput.css">
    </head>
    <body>
        <?php
            include 'menu.php';
            include '../functions.php';
            $fetchdata = new DB_con();
        ?>
        <div class="container">
            <header>Booking Form</header>
            <div class="progress-bar">
                <div class="step">
                    <p>Travel</p>
                    <div class="bullet">
                        <span>1</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>Vehicle</p>
                    <div class="bullet">
                        <span>2</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>Driver</p>
                    <div class="bullet">
                        <span>3</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>Book</p>
                    <div class="bullet">
                        <span>4</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
            </div>
            <div class="form-outer">
                <form validate>
                    <div class="page slide-page">
                        <div class="title">Basic Info:</div>
                        <div class="field">
                            <div class="label">From Addrees</div>
                            <?= $fetchdata->get_address('pick'); ?>
                        </div>
                        <span class="error" id="pick_error" style="display: none;">required</span>
                        <div class="field">
                            <div class="label">To Address</div>
                            <?= $fetchdata->get_address('drop'); ?>
                        </div>
                         <span class="error" id="drop_error" style="display: none;">required</span>
                        <div class="field">
                            <div class="label">Date</div>
                            <input class="form-control" type="date" name="date" id="date">
                        </div>
                        <span class="error" id="date_error"style="display: none;">required</span>
                        <div class="field">
                            <div class="label">Time</div>
                            <input class="form-control" type="time" name="time" id="time">
                        </div>
                        <span class="error" id="time_error"style="display: none;">required</span>
                        <div class="field">
                            <select class="form-control" name="passengers" id="passengers">
                                <option value="">--Passengers--</option>
                                <option value="1">1 Passengers</option>
                                <option value="2">2 Passengers</option>
                                <option value="3">3 Passengers</option>
                                <option value="4">4 Passengers</option>
                                <option value="5">5 Passengers</option>
                                <option value="6">6 Passengers</option>
                                <option value="7">7 Passengers</option>
                            </select>
                        </div>
                        <span class="error" id="passengers_error" style="display: none;">required</span>
                        <div class="field">
                            <button class="firstNext next">Next</button>
                        </div>
                    </div>
                    <div class="page">
                        <div class="title">Vehicles:</div>
                        <div id="vehicle_table">             
                        </div>
                        <span class="error" id="vehicle_error" style="display: none;">required</span>
                        <div class="field btns">
                            <button class="prev-1 prev">Previous</button>
                            <button class="next-1 next">Next</button>
                        </div>
                    </div>
                    <div class="page">
                        <div class="title">Drivers:</div>
                        <div id="driver_table">             
                        </div>
                        <div class="field btns">
                            <button class="prev-2 prev">Previous</button>
                            <button class="next-2 next">Next</button>
                        </div>
                    </div>
                    <div class="page">
                        <div class="title">User Information:
                            <input type="radio" class="user_type" name="user_type" value="individual" checked="checked"> Individual
                            <input type="radio" class="user_type" name="user_type" value="agency"> Agency 
                        </div>
                        <div class="row" id="individual_form">
                            <div class="field">
                                <div class="label">First Name</div>
                                <input class="form-control" type="text" name="first_name" id="first_name" placeholder="First Name">
                            </div>
                            <span class="error" id="first_name_error" style="display: none;">required</span> 
                    
                            <div class="field">
                                <div class="label">Last Name</div>
                                <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Last Name"> 
                            </div>
                            <span class="error" id="last_name_error" style="display: none;">required</span>
                    
                            <div class="field">
                                <div class="label">Phone</div>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone">
                            </div>
                            <span id="phone_valid" class="hide" style="display: none;">✓ Valid</span>
                            <span class="error" id="phone_error" style="display: none;">required</span>
                            <span id="phone_no_error" class="error hide"></span>
                    
                            <div class="field">
                                <div class="label">Email</div>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            </div>
                            <span class="error" id="email_error" style="display: none;">required</span>
                    
                            <div class="field">
                                <div class="label">Password</div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" maxlength="32">
                            </div>
                            <span class="error" id="password_error" style="display: none;">required</span>
                        </div>
                        <div class="row" id="agency_form" style="display:none;">
                            
                                <div class="field">
                                    <div class="label">Agency Name</div> 
                                    <input type="text" name="agency_name" id="agency_name" class="form-control"placeholder="Agency Name">
                                </div>
                                <span class="error" id="agency_name_error" style="display: none;">required</span>
                    
                                <div class="field">
                                    <div class="label">Agency Email</div> 
                                    <input type="email" name="agency_email" id="agency_email" class="form-control" placeholder="Email">
                                </div>
                                <span class="error" id="agency_email_error" style="display: none;">required</span>
                    
                                <div class="field">
                                    <div class="label">Agency Phone</div> 
                                    <input type="number" name="agency_phone" id="agency_phone" class="form-control" placeholder="Agency Phone"> 
                                </div>
                                <span class="error" id="agency_phone_error" style="display: none;">required</span>
                                <span id="agency_phone_valid" class="hide" style="display: none;">✓ Valid</span>
                                <span id="agency_phone_no_error" class="error hide"></span>
                    
                                <div class="field">
                                    <div class="label">Agency Password</div> 
                                    <input type="password" name="agency_password" id="agency_password" class="form-control" placeholder="Password" maxlength="32">
                                </div>
                                <span class="error" id="agency_password_error" style="display: none;">required</span>
                    
                                <div class="field">
                                    <div class="label">Agency User First Name</div> 
                                    <input class="form-control" type="text" name="agency_user_first_name" id="agency_user_first_name" placeholder="First Name"> 
                                </div>
                                <span class="error" id="agency_user_first_name_error" style="display: none;">required</span>
                    
                                <div class="field">
                                    <div class="label">Agency User Last Name</div> 
                                    <input class="form-control" type="text" name="agency_user_last_name" id="agency_user_last_name" placeholder="Last Name"> 
                                </div>
                                <span class="error" id="agency_user_last_name_error" style="display: none;">required</span>
                    
                                <div class="field">
                                    <div class="label">Agency User Email</div> 
                                    <input type="email" name="agency_user_email" id="agency_user_email" class="form-control" placeholder="Email">
                                </div>
                                <span class="error" id="agency_user_email_error" style="display: none;">required</span>
                    
                                <div class="field">
                                    <div class="label">Agency User Phone</div> 
                                    <input type="number" name="agency_user_phone" id="agency_user_phone" class="form-control" placeholder="Phone">
                                </div>
                                <span class="error" id="agency_user_phone_error" style="display: none;">required</span>
                                <span id="agency_user_phone_valid" class="hide" style="display: none;">✓ Valid</span>
                                <span id="agency_user_phone_no_error" class="error hide"></span>
                        </div>
                        <div class="field btns">
                            <button class="prev-3 prev">Previous</button>
                            <button class="next-3 next">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.0/js/intlTelInput.min.js"></script>
        <script src="index.js"></script>
    </body>
</html>
