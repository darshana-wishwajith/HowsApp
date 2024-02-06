var show = false;
function passwordViewer(id){
    if(!show){
        document.getElementById(id).type = "text";
        document.getElementById("passwordIcon").classList = "bi bi-eye-slash-fill";
        show = true;
    }
    else{
        document.getElementById(id).type = "password";
        document.getElementById("passwordIcon").classList = "bi bi-eye-fill";
        show = false;
    }
}

function register(){

   var fname = document.getElementById("fname");
   var lname = document.getElementById("lname");
   var genderSelector = document.getElementById("genderSelector");
   var RegistrationMail = document.getElementById("RegistrationMail");
   var vcode = document.getElementById("vcode");
   var RegistrationPass = document.getElementById("RegistrationPass");

   var form = new FormData();

   form.append("fname",fname.value);
   form.append("lname",lname.value);
   form.append("genderSelector",genderSelector.value);
   form.append("RegistrationMail",RegistrationMail.value);
   form.append("vcode",vcode.value);
   form.append("RegistrationPass",RegistrationPass.value);

   var request = new XMLHttpRequest();

   request.onreadystatechange = function(){
    if(request.readyState == 4 && request.status == 200){
        var response = request.responseText;
        if(response == "success"){
            alert("Registration successfull! Please login to your account");
            window.location = "login.php";
        }
        else{
            alert(response);
        }
    }
   }

   request.open("POST", "server/registrationProcess.php", true);
   request.send(form);
}

var vRespone;
function sendVerification(mail){

    document.getElementById("vcodeSenderSpan").classList = "spinner-border spinner-border-sm";
    document.getElementById("vcodeSender").toggleAttribute("disabled");

    var form = new FormData();
    form.append("unverifiedEmail",mail.value);

    var request = new XMLHttpRequest();

   request.onreadystatechange = function(){
    if(request.readyState == 4 && request.status == 200){
        vRespone = request.responseText 
        document.getElementById("vcodeSenderSpan").classList = "";
        document.getElementById("vcodeSender").toggleAttribute("disabled");
        alert(vRespone);
       }
       
    }

   request.open("POST", "server/sendVerificationProcess.php", true);
   request.send(form);

}


var fpModal;

function fogotPassword(){

    var mail = document.getElementById("loginMail").value;
    
    if(mail == ""){
        alert("please enter your email address");
    }
    
    else{
        var modal_design = document.getElementById("fpmodal");
        fpModal = new bootstrap.Modal(modal_design);
        fpModal.show();
    }

}

function changePassword(){

    var email = document.getElementById("loginMail");
    var np = document.getElementById("np");
    var rtp = document.getElementById("rtp");
    var vcode = document.getElementById("vcode");

    
        var form = new FormData();
        form.append("email", email.value);
        form.append("vcode", vcode.value);
        form.append("newPassword", np.value);
        form.append("rtPassword", rtp.value);

        var request = new XMLHttpRequest();
    
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var response =  request.responseText;

                if(response == "success"){
                    alert("Password updated successfully");
                    fpModal.hide();
                }
                else{
                    alert(response);
                }
            }
        }
    
        request.open("POST", "server/changePasswordProcess.php", true);
        request.send(form);
        
    

}

function checkEmail(email){

    var form = new FormData();
    form.append("email", email);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            alert(response);
            return response;
        }
    }

    request.open("POST", "server/checkEmailProcess.php", true);
    request.send(form);
}

function login(){

    var email = document.getElementById("loginMail");
    var password = document.getElementById("loginPass");

    var form = new FormData();
    form.append("email", email.value);
    form.append("password", password.value);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            if(response == "success"){
                window.location = "index.php";
            }
            else{
                alert(response);
            }
        }
    }

    request.open("POST", "server/loginProcess.php", true);
    request.send(form);
}

function logout(){
   
    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            if(response == "success"){
                window.location = "login.php";
            }
            else{
                alert(response);
            }
        }
    }

    request.open("GET", "server/logoutProcess.php", true);
    request.send();
}

function friendSearch(){

    var femail = document.getElementById("friendSearch");

    var form = new FormData();
    form.append("femail", femail.value);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;

            if(response == "Something went wrong"){
                alert(response);
            }
            else if(response == "Please enter an email of your friend"){
                alert(response);
            }
            else if(response == "Invalid email"){
                alert(response);
            }
            else if(response == "faild"){
                document.getElementById("friendNotFound").classList = "row";
            }
            else{
                document.getElementById("friendNotFound").classList = "row d-none";
                document.getElementById("friendSearchProfile").innerHTML = response;
            }
           
        }
    }

    request.open("POST", "server/findFriendProcess.php", true);
    request.send(form);
}

function addFriend(email){
    
    var form = new FormData();
    form.append("toEmail", email);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            if(response == "success"){
                alert("Friend request has been sent Successfully!");
                window.location.reload();
            }
            else{
                alert(response);
            }
        }
    }

    request.open("POST", "server/addFriendProcess.php", true);
    request.send(form);

}

function acceptFr(friendId){
    var form = new FormData();
    form.append("friendId", friendId);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            if(response == "success"){
                alert("Friend request accepted");
                window.location.reload();
            }
            else{
                alert(response);
            }
        }
    }

    request.open("POST", "server/acceptFriendRequestProcess.php", true);
    request.send(form);
}

function rejectFr(friendId){
    var form = new FormData();
    form.append("friendId", friendId);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            if(response == "success"){
                alert("Friend request rejected");
                window.location.reload();
            }
            else{
                alert(response);
            }
        }
    }

    request.open("POST", "server/rejectFriendRequestProcess.php", true);
    request.send(form);
}

function viewInbox(friendEmail){
    var form = new FormData();
    form.append("friendEmail", friendEmail);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            if(response == "success"){
                window.location = "inbox.php";
            }
            else{
                alert(response);
            }
           
        }
    }

    request.open("POST", "server/viewInboxProcess.php", true);
    request.send(form);
}

function msgLoader(){
    

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            if(response == "Somthing went wrong"){
                alert(response);
            }
            else{
                document.getElementById("msg-container").classList = "";
                document.getElementById("msg-container").innerHTML = response;
                window.scrollTo(0, document.body.scrollHeight);
            }
           
        }
    }

    request.open("GET", "server/loadMsgProcess.php", true);
    request.send();
}

var firstRequest = true;
function loader(){
    if(firstRequest){
        document.getElementById("inboxSpinner").classList = "spinner-border spinner-border";
        firstRequest = false;
    }
    else{
        document.getElementById("inboxSpinner").classList = "d-none";
    }
    setInterval(msgLoader, 2500);
}


function sendMsg(){
    var msg = document.getElementById("sendMsg");

    var form = new FormData();
    form.append("msg", msg.value);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            if(response != "success"){
                alert(response);
            }
            else{
                msg.value = "";
            }
        }
    }

    request.open("POST", "server/sendMsgProcess.php", true);
    request.send(form);
}

function getNewChat(){
    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
        }
    }

    request.open("GET", "index.php", true);
    request.send();
}

function chatLoader(){
    setInterval(getNewChat, 2500);
}

function openFileUploader(){
    document.getElementById("ProfilePicUpload").click();
}

var uploadProfileImg = false;
function ProfilePicUpload(){
    var img = document.getElementById("ProfilePicUpload");

    var tmp_paath = URL.createObjectURL(img.files[0]);

    document.getElementById("profile_img").src = tmp_paath;

    uploadProfileImg = true;
}

function uploadProfile(email){

    document.getElementById("profileUpdateSpinner").classList = "spinner-border spinner-border-sm";
    document.getElementById("profileUpdateBtn").toggleAttribute("disabled");

    var fname = document.getElementById("profileFname");
    var lname = document.getElementById("profileLname");
    var password = document.getElementById("profilePass");
    var mobile = document.getElementById("profileMobile");
    var dob = document.getElementById("profiledob");
    var adl1 = document.getElementById("profileAdLine1");
    var adl2 = document.getElementById("profileAdLine2");
    var city = document.getElementById("profilecity");

    var img = document.getElementById("ProfilePicUpload");
    
    var form = new FormData();

    form.append("fname",fname.value);
    form.append("lname",lname.value);
    form.append("email",email);
    form.append("password",password.value);
    form.append("mobile",mobile.value);
    form.append("dob",dob.value);
    form.append("adl1",adl1.value);
    form.append("adl2",adl2.value);
    form.append("city",city.value);


    if(uploadProfileImg){
        form.append("img",img.files[0]);
    }

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            document.getElementById("profileUpdateSpinner").classList = "";
            document.getElementById("profileUpdateBtn").toggleAttribute("disabled");
            if(response == "success"){
                alert("Profile Updated successfully!");
                window.location.reload();
            }
            else{
                alert(response);
            }
        }
    }

    request.open("POST", "server/updateProfileProcess.php", true);
    request.send(form);

}

function gotoPublicProfile(email){

    window.location = "publicProfile.php?e="+email;
}

function getPublicProdile(email){
    var form = new FormData();
    form.append("femail",email);

    var request = new XMLHttpRequest();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response =  request.responseText;
            document.getElementById("publicProfile").innerHTML = response;
        }
    }

    request.open("POST", "server/findFriendProcess.php", true);
    request.send(form);
}