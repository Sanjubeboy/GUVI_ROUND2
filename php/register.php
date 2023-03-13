<?php

    // console.log("hii");
    $conn = mysqli_connect("localhost","root","","guvi_db");        //connecting the database
    if(!$conn)
    {
        // console.log("success");
        echo "Database not connected" . mysqli_connect_error();
    }
    // else{
    //     echo "Database connected";
    // }
    require '../assets/redis/vendor/autoload.php';
    $redis = new Predis\Client();

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    if(!empty($name) && !empty($email) && !empty($password) && !empty($cpassword))
    {
        if(strlen($name) <= 10 && strlen($name) >= 5)
        {

            if($password === $cpassword)
            {
                    //checking email
                    if(filter_var($email, FILTER_VALIDATE_EMAIL))
                    {
                        //check if email is already registered in dbms
                        // $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");

                        $query = " SELECT email FROM user WHERE email = ? "; // SQL with parameters
                        $stmt = $conn->prepare($query); 
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result(); // get the mysqli result

                        if(mysqli_num_rows($result) > 0)
                        {
                            echo "$email - This email already exist";
                        }
                        else
                        {
                            //lets do password validation
                            
                            $uppercase = preg_match('@[A-Z]@', $password);
                            $lowercase = preg_match('@[a-z]@', $password);
                            $number    = preg_match('@[0-9]@', $password);
                            $specialChars = preg_match('@[^\w]@', $password);

                            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8)
                            {
                                echo "The Password should contain atleast 8 characters, one uppercase, one lowercase, one number and one symbol";
                            }
                            else
                            {
                                // $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status, verification, otp)
                                //                             VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$hashed_password}', '{$new_img_name}', '{$status}', '{$verification}', {$code})");
                                
                                //Prepared statements
                                
                                $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
                                $stmt->bind_param("sss", $name, $email, $password);
                                $stmt->execute();

                                // sql id
                                //local st
                                $redis->set('name', $name);

                                echo "success".$name;
                                
                                
                            }
                        }
                    }
                    else
                    {
                        echo "$email - This is not a valid Email!";
                    }
                }
                else
                {
                    echo "confirm Password not matched";
                }
        }
        else
        {
            echo "Please Give a Short First Name";
        }
    }
    else
    {
        echo "All input field are required!";
    }
    


?>