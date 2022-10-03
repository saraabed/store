<?php
include "./admin/includes/connect.php";

if (isset($_SESSION["type"])) {
    header('location:index.php');
}

session_start();
//$_SESSION["type"] 0 => user, 1 => admin, 2 => super admin
function redirect($url)
{
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit;
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit;
    }
}
class Validation
{
    public $emailError           = "";
    public $passwordError        = "";
    public $passwordConfirmError = "";
    public $check                = 1 ;

    public function emailValidation($email )
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->emailError = ("$email is not a valid email address");
            $this->check=0;
            return false;
        }
        else if ($email == "") {
            $this->emailError = "The email shouldn't be empty!";
            $this->check=0;
            return false;
        }
        return true ;
    }
    public function passValidation($password)
    {
        if ($password == "") {
            $this->passwordError = "cant be empty";
            $this->check=0;
            return false;
        }
        else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $password)) {
            $this->passwordError = "your email or password is wrong";
            $this->check=0;
            return false;
        }  
        return true ;
    }
}

$trueValid = new Validation();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check               = 1;
    $email               = strtolower($_POST["email"]);
    $password            = $_POST['password'];
    $emailError          = "";
    $passwordError       = "";

    $trueValid->emailValidation($email);
    $trueValid->passValidation($password);


    if ($trueValid->check == 1) {
        $check_exist = "SELECT * FROM users WHERE user_email = '$email'";
        $result = mysqli_query($conn, $check_exist);
        $data = mysqli_fetch_array($result, MYSQLI_NUM);
        if ($result->num_rows != 0) {
            $sql = "SELECT * FROM users WHERE user_email = '$email'";
            $result = mysqli_query($conn, $sql);
            $users  = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($users as $user) {
                if ($email == $user["user_email"] && $password == $user["user_password"]) {
                    $_SESSION["type"] = 0;
                    $_SESSION["user_id"] = $user['user_id'];
                    if (isset($_GET['back_to_checkout'])) {
                        redirect('checkout.php');
                    } else {
                        redirect("index.php");
                    }
                } else {
                    $error = "your email or password is wrong";
                }
            }
        } else {
            $error = "your email isnt exist please register";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SignIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="css/signing_style.css">
</head>

<body>

    <div class="wrapper" style="background-image: url('images/bg-registration-form-1.jpg');">
        <div class="inner">
            <div class="image-holder">
                <img loading="lazy" src="https://cdn.discordapp.com/attachments/914883219546058815/917071612061319290/registration-form-1.jpg" alt="">
            </div>
            <form method="POST" id="signup_form">
                <h3 id="login_h3">LogIn Now</h3>
                <div style="color: red;font-weight:bold;" id="pass2Help"><?php echo @$trueValid->$error ?></div>
                <div class="form-wrapper">
                    <input type="email" name="email" placeholder="Email Address" class="form-control" id="signin_email_input" required autofocus auto style="text-transform:lowercase">
                    <i class="zmdi zmdi-email"></i>
                    <div style="color: red;font-weight:bold;" id="emailHelp">
                        <div style="color: red;font-weight:bold;" id="pass2Help"><?php echo @$trueValid->emailError ?></div>
                    </div>
                </div>
                <div class="form-wrapper">
                    <input type="password" name="password" placeholder="Password" class="form-control" id="signin_pass_input" required>
                    <i class="zmdi zmdi-lock"></i>
                    <div style="color: red;font-weight:bold;" id="passHelp">
                        <div style="color: red;font-weight:bold;" id="pass2Help"><?php echo $trueValid->passwordError ?></div>
                    </div>
                </div>
                <button id="signin_insignin_btn" type="submit">LogIn
                    <i class="zmdi zmdi-arrow-right"></i>
                </button>
                <div class="dont">
                    <span class="dont">Don't have an account? <a class="ms-1 regster-href" href="sign_up.php">Sign up</a> </span>
                </div>
            </form>
        </div>
    </div>
</body>

</html>