<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="icon" href="./logo512.png">
    <title class="tr">Madares</title>
    <link rel="icon" href={{ asset('emails/logo512.png') }}>
	<script>
		window.addEventListener('load', (event) => {
            var timeleft = 5;
            var downloadTimer = setInterval(function(){  
                if(timeleft <= 0){
                    clearInterval(downloadTimer);
                    window.location.replace('https://dashboard-madares.mvp-apps.ae/login')
                }
                document.getElementById("progressBar").innerHTML = `You will be redirected after ${timeleft} seconds`;
                timeleft -= 1;
            }, 1000);
        });
	</script>
    <style>
        .login_page {
          min-height: 100vh;
          display: flex;
          position: relative;
          /* padding: 10px; */
        }
        .login_img {
          height: 100vh;
          width: 100%;
          object-fit: cover;
          object-position: top;
        }
        .login_card_wrapper {
          position: absolute;
          top: 20vh;
          /* width: 60%; */
          width: 700px;
          left: calc( 50% - 350px );
          display: flex;
          flex-direction: column;
        }
        .login_card_wrapper h1 {
          color: #fff;
          text-shadow: 1px 0px 8px gray;
        }
        .page-bg-image .card {
          box-shadow: none;
          /* overflow: hidden; */
        }
        .page-bg-image .card-body {
          box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
          border-radius: 10px;
          /* padding: 3% 5%; */
        }
        .card {
          position: relative;
          display: flex;
          flex-direction: column;
          min-width: 0;
          word-wrap: break-word;
          background-color: #fff;
          background-clip: border-box;
          border: 1px solid rgba(0, 0, 0, 0.125);
          border-radius: 0.75rem; 
        }
        .card-body {
          flex: 1 1 auto;
          padding: 1rem 1rem; 
        }
        .innerCardBody {
            padding: 40px;
        }
        .overflow-hidden {
          overflow: hidden !important; 
        }
        .login_form {
          display: flex;
          flex-direction: column;
          align-items: center;
          width:100%
        }
        .regular_login {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            min-height: 200px;
            width:100%

        }
        .regular_login h3 {
            color: gray;
            text-align: center;
        }
        .regular_login label {
            color: gray !important;
            text-decoration: none;
            text-align: center;
        }
        .green-bg {
          background-color: rgba(16, 75, 8);
          position: absolute;
          top:0;
          left:0;
          right:0;
          height: 10px;
          /* border-top-left-radius: 50%;
          border-top-right-radius: 50%;
          height: 15px;
          width: 98%;
          margin: 0px 1%; */
          
        }
        @media (max-width: 700px) {
          .login_card_wrapper {
            width: 90%;
            left: 5%;
          }
          .widthMedia {
            width: 100%;
          }
          .page-title {
              font-size: 30px;
          }
          .regular_login h3 {
            font-size: 20px;
          }
          #progressBar {
            font-size: 13px;
          }
        }
    </style>
</head>
<body>
    <div class="login_page">
      <img src={{ asset('emails/authBC.png') }} alt='login_img' class='login_img'/>
      <div class='login_card_wrapper'>
            <h1 class="page-title">Help Me</h1>
            <h4>{{$email}}</h4>
            <div class='card overflow-hidden'>
                <div class="card-body innerCardBody">
                    <div class="green-bg"></div>
                    <div  class="login_form">
                        <div class='regular_login'>
                            <label id="progressBar">{{$subject}}</label>
                            <label id="progressBar">body</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
  </html>