initMultiStepForm();

function initMultiStepForm() {
    const progressNumber = document.querySelectorAll(".step").length;
    const slidePage = document.querySelector(".slide-page");
    const progressText = document.querySelectorAll(".step p");
    const progressCheck = document.querySelectorAll(".step .check");
    const bullet = document.querySelectorAll(".step .bullet");
    const pages = document.querySelectorAll(".page");
    const nextButtons = document.querySelectorAll(".next");
    const prevButtons = document.querySelectorAll(".prev");
    const stepsNumber = pages.length;

    if (progressNumber !== stepsNumber) {
        console.warn(
            "Error, number of steps in progress bar do not match number of pages"
        );
    }

    document.documentElement.style.setProperty("--stepNumber", stepsNumber);

    let current = 1;
    var error = false;
    for (let i = 0; i < nextButtons.length; i++) {
        nextButtons[i].addEventListener("click", function (event) {
            event.preventDefault();
            inputsValid = validateInputs(this);
            // inputsValid = true;
            if(current == 1){
                step1  = ['pick','drop','date','time','passengers'];
                $.each(step1,function(index,key) {
                    if ($('#'+key).val().length < 1) {  
                        $('#'+key+'_error').show();
                        $('#'+key).parents('.field').css('margin','15px 0 15px 0');
                        error = true;
                    }else{
                        error = false;
                    }
                });
                if(error == false){
                    var action = "vehicles"; 
                    $('form').append('<input type="hidden" name="action" value="vehicles">');
                    var data = $('form').serialize();
                    $.ajax({
                        url:"actions.php",  
                        type:"POST",  
                        data:data, 
                        success:function(response){
                            NextPrev();
                            $('#vehicle_table').html(response); 
                        }
                    });
                }
            }else if(current == 2){
                vehicle = $('.vehicle_id:checked').val();
                if (vehicle == undefined) {  
                    $('#vehicle_error').show();
                    error = true;
                }else{
                    error = false;
                    $('input[name="action"]').val('drivers');
                    var data = $('form').serialize(); 
                    $.ajax({
                        url:"actions.php",  
                        type:"POST",  
                        data:data, 
                        success:function(response){
                            $('#driver_table').html(response); 
                        }
                    });
                }
            }else if(current == 3){
                // driver = $('.driver_id:checked').val();
                // if (driver == undefined) {  
                //     $('#driver_error').show();
                //     error = true;
                // }else{
                //     error = false;
                // }
            }else if(current == 4){

                var user_type = $('.user_type:checked').val();
                var step4 = [];

                if(user_type == 'individual'){
                    step4  = ['first_name','last_name','phone','email','password'];
                }else if(user_type == 'agency'){
                    step4 = ['agency_name', 'agency_email', 'agency_phone', 'agency_password', 'agency_user_first_name', 'agency_user_last_name', 'agency_user_email', 'agency_user_phone'];
                }

                $.each(step4,function(index,key) {
                    if ($('#'+key).val().length < 1) {  
                        $('#'+key+'_error').show();
                        $('#'+key).parents('.field').css('margin','15px 0 15px 0');
                        error = true;   
                    }else{
                        error = false;
                    }
                }); 

                if(user_type == 'individual'){
                    if($("#phone_valid").hasClass('hide')) {
                        error = true;
                    }else{
                        error = false;
                    }
                }else if(user_type == 'agency'){
                    if($("#agency_phone_valid").hasClass('hide') || $("#agency_user_phone_valid").hasClass('hide')){
                        error = true;
                    }else{
                        error = false;
                    }
                }
                if(error == false){
                    var action = "submit";
                    $('input[name="action"]').val('submit');
                    var data = $('form').serialize(); 
                    $.ajax({
                        url:"actions.php",  
                        type:"POST",  
                        data:data, 
                        success:function(data){
                            if(data){
                                alert('Success');
                                window.location.reload();
                            }
                        }
                    });
                }
            }
            if (inputsValid && error == false && current !== 4 && current !== 1) {
                NextPrev();
            }
        });
    }

    function NextPrev(){
        slidePage.style.marginLeft = `-${
            (100 / stepsNumber) * current
        }%`;
        bullet[current - 1].classList.add("active");
        progressCheck[current - 1].classList.add("active");
        progressText[current - 1].classList.add("active");
        current += 1;
    }

    for (let i = 0; i < prevButtons.length; i++) {
        prevButtons[i].addEventListener("click", function (event) {
            event.preventDefault();
            slidePage.style.marginLeft = `-${
                (100 / stepsNumber) * (current - 2)
            }%`;
            bullet[current - 2].classList.remove("active");
            progressCheck[current - 2].classList.remove("active");
            progressText[current - 2].classList.remove("active");
            current -= 1;
        });
    }

    function validateInputs(ths) {
        let inputsValid = true;

        const inputs =
            ths.parentElement.parentElement.querySelectorAll("input");
        for (let i = 0; i < inputs.length; i++) {
            const valid = inputs[i].checkValidity();
            if (!valid) {
                inputsValid = false;
                inputs[i].classList.add("invalid-input");
            } else {
                inputs[i].classList.remove("invalid-input");
            }
        }
        return inputsValid;
    }
}

const phone = document.querySelector("#phone");
const phonevalidMsg = document.querySelector("#phone_valid");
const phoneerrorMsg = document.querySelector("#phone_no_error");

var agency_phone = document.querySelector("#agency_phone");
const agency_phonevalidMsg = document.querySelector("#agency_phone_valid");
const agency_phoneerrorMsg = document.querySelector("#agency_phone_no_error");

var agency_user_phone = document.querySelector("#agency_user_phone");
const agency_user_phonevalidMsg = document.querySelector("#agency_user_phone_valid");
const agency_user_phoneerrorMsg = document.querySelector("#agency_user_phone_no_error");

// here, the index maps to the error code returned from getValidationError - see readme
const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
const phone_iti = window.intlTelInput(phone, {
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.3/js/utils.js",initialCountry: "in"
});
const agency_phone_iti = window.intlTelInput(agency_phone, {
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.3/js/utils.js",initialCountry: "in"
});
const agency_user_phone_iti = window.intlTelInput(agency_user_phone, {
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.3/js/utils.js",initialCountry: "in"
});

const phone_reset = () => {
  phone.classList.remove("error");
  phoneerrorMsg.innerHTML = "";
  phoneerrorMsg.classList.add("hide");
  phonevalidMsg.classList.add("hide");
};

const agency_phone_reset = () => {
  agency_phone.classList.remove("error");
  agency_phoneerrorMsg.innerHTML = "";
  agency_phoneerrorMsg.classList.add("hide");
  agency_phonevalidMsg.classList.add("hide");
};

const agency_user_phone_reset = () => {
  agency_user_phone.classList.remove("error");
  agency_user_phoneerrorMsg.innerHTML = "";
  agency_user_phoneerrorMsg.classList.add("hide");
  agency_user_phonevalidMsg.classList.add("hide");
};

// on blur: validate
phone.addEventListener('blur', () => {
  phone_reset();
  if (phone.value.trim()) {
    if (phone_iti.isValidNumber()) {
      phonevalidMsg.classList.remove("hide");
    } else {
      phone.classList.add("error");
      const errorCode = phone_iti.getValidationError();
      phoneerrorMsg.innerHTML = errorMap[errorCode];
      $('#phone').parents('.field').css('margin','15px 0 15px 0');
      phoneerrorMsg.classList.remove("hide");
    }
  }
});

agency_phone.addEventListener('blur', () => {
  agency_phone_reset();
  if (agency_phone.value.trim()) {
    if (agency_phone_iti.isValidNumber()) {
      agency_phonevalidMsg.classList.remove("hide");
    } else {
      agency_phone.classList.add("error");
      const errorCode = agency_phone_iti.getValidationError();
      agency_phoneerrorMsg.innerHTML = errorMap[errorCode];
      $('#agency_phone').parents('.field').css('margin','15px 0 15px 0');
      agency_phoneerrorMsg.classList.remove("hide");
    }
  }
});

agency_user_phone.addEventListener('blur', () => {
  agency_user_phone_reset();
  if (agency_user_phone.value.trim()) {
    if (agency_user_phone_iti.isValidNumber()) {
      agency_user_phonevalidMsg.classList.remove("hide");
    } else {
      agency_user_phone.classList.add("error");
      const errorCode = agency_user_phone_iti.getValidationError();
      agency_user_phoneerrorMsg.innerHTML = errorMap[errorCode];
      $('#agency_user_phone').parents('.field').css('margin','15px 0 15px 0');
      agency_user_phoneerrorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
phone.addEventListener('change', phone_reset);
phone.addEventListener('keyup', phone_reset);

agency_phone.addEventListener('change', agency_phone_reset);
agency_phone.addEventListener('keyup', agency_phone_reset);

agency_user_phone.addEventListener('change', agency_user_phone_reset);
agency_user_phone.addEventListener('keyup', agency_user_phone_reset);

$(function(){
    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate() + 1;
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var minDate = year + '-' + month + '-' + day;
    $('#date').attr('min', minDate);
});

$(document).on('change','.vehicle_id',function(){
    vehicle = $('.vehicle_id:checked').val();
    if (vehicle == undefined) {  
        $('#vehicle_error').show();
    }else{
        $('#vehicle_error').hide();
    }
});

$('#drop').on('change',function(){
    var drop = $(this).val();
    $("#pick option").attr("disabled", false);
    if(drop){
        $("#pick option[value="+drop+"]").attr("disabled",true);
    }
    $('#drop_error').hide();
    $('#drop').parents('.field').css('margin','45px 0 45px 0'); 
});

$('#pick').on('change',function(){
    var pick = $(this).val();
    $("#drop option").attr("disabled", false);
    if(pick){
         $("#drop option[value="+pick+"]").attr("disabled",true);
    }
    $('#pick_error').hide();
    $('#pick').parents('.field').css('margin','45px 0 45px 0'); 
});

$('input[name="user_type"]').change(function(){
    if($(this).val() == "individual"){
        $('#individual_form').show();
        $('#agency_form').hide();
    }else{
        $('#individual_form').hide();
        $('#agency_form').show();
    }
});

var elems = ['pick','drop','date','time','passengers','first_name','last_name','phone','email','password','agency_name','agency_email','agency_phone','agency_password','agency_user_first_name','agency_user_last_name','agency_user_email','agency_user_phone'];

$.each(elems,function(index,key) {
   $('#'+key).on('change',function(){
        if($('#'+key).val().length < 1){
            $('#'+key+'_error').show();
            $('#'+key).parents('.field').css('margin','15px 0 15px 0');    
        }else{
            $('#'+key+'_error').hide();  
            $('#'+key).parents('.field').css('margin','45px 0 45px 0');  
        }
    });
});
