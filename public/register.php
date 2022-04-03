<?php

    require( __DIR__ . '/../env/config.php' );

    if( mysqli_connect_errno() ){
        echo 'Failed to connect: ' . mysqli_connect_errno(); ;
    }

    $_SESSION['first_name'] = stripInput( $_POST['first_name'] );
    $_SESSION['last_name '] = stripInput( $_POST['last_name'] );
    $_SESSION['email']      = stripInput( $_POST['email'] );
    $_SESSION['password']   = stripInput( $_POST['password'] );

    // Small sanitize funtion
    function stripInput( $input ){
        $input = strip_tags( $input );
        $input = str_replace( ' ', '', $input );
        return $input;
    }
    function validateEmail( $email ){
        if( !filter_var( $email, FILTER_VALIDATE_EMAIL) ) return;
        return $email;
    }
    function stringLengthLT( $string, $length ){
        if( strlen($string) > $length || strlen($string) < 2  ) return false;
        return $string;
    }

    if( isset( $_POST['register']) ){
        $first_name = stripInput( $_POST['first_name'] );
        $last_name = stripInput( $_POST['last_name'] );
        $email = stripInput( $_POST['email'] );
        $password = stripInput( $_POST['password'] );
        $error = [];


        if( validateEmail( $email ) ){
            $e_check = mysqli_query( $conn, "SELECT email FROM users WHERE email = '$email'" );
            $num_rows = mysqli_num_rows( $e_check );
            if($num_rows) array_push( $error, 'mail exists');
            
        }

        if( stringLengthLT( $first_name, 10 ) ){
            echo 'Proceed to First name Happy Ending';
        } else {
            array_push( $error, 'First name length error');
        }

        if( stringLengthLT( $last_name, 10 ) ){
            echo 'Proceed to Last name Happy Ending';
        } else {
            array_push( $error, 'Last name length error');
        }

        if( empty( $error ) ){

            $options = [
                'cost' => 12,
            ];

            $password = password_hash( $password, PASSWORD_BCRYPT, $options);
            
            $user_name = strtolower( $first_name . '-' .$last_name );
            $check_user_name_query = mysqli_query( $conn, "SELECT user_name FROM users WHERE user_name = '$user_name'" );
            $i = 0;
            // if username exists add nnumver to username
            while( mysqli_num_rows( $check_user_name_query ) != 0 ){
                $i++;
                $username = $username ."_" . $i;
                $check_username_query = mysqli_query( $conn, "SELECT user_name FROM users WHERE user_name = '$user_name'" );
            }

            // profile pic default
            $avatar = "/assets/media/images/profile/default-avatar.png";
            $avatar = "https://via.placeholder.com/100x100/cc6699/ffffee";


            $query = "INSERT INTO `social`.`users`
             ( first_name, last_name, user_name, email, password)
             VALUES ( '$first_name', '$last_name', '$user_email', '$email', '$password' )";

            $insert = mysqli_query( $conn, $query );

        }
    }




function callback($buffer)
{
  // replace all the apples with oranges
//   return (str_replace("apples", "oranges", $buffer));
echo '1';
return $buffer;
}

ob_start("callback");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="register.php" method="POST">
    <input type="text" name="first_name" placeholder="First Name" value="<?= isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '' ?>" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password">
    <input type="password" name="password_confirmation" placeholder="Confirm your password">
    <button type="submit" name="register">FART!</button>
</form>
    <p>It's like comparing apples to oranges.</p>
    
</body>
</html>

<?php

ob_end_flush();

?>