<?php

    // console.log("hii");
    $conn = mysqli_connect("localhost","root","","guvi_db");        //connecting the database
    if(!$conn)
    {
        // console.log("success");
        echo "Database not connected" . mysqli_connect_error();
    }

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // echo $password;

    require '../assets/redis/vendor/autoload.php';

    $redis = new Predis\Client();




    if(!empty($email) && !empty($password))  {       

        $query = " SELECT * FROM user WHERE email = ? "; // SQL with parameters
        $stmt = $conn->prepare($query); 
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
  

        if(mysqli_num_rows($result) > 0)
        {
                $row = $result->fetch_assoc();

                $user_password = $row['password'];

                $name = $row['name'];

                // $redis->set('name','$name');
                // $redis->set('name',$name);

                if($user_password === $password)
                {
                    $redis->set('name',$name);
                    $temp = $redis->get('name');
                    echo "success" . $temp;
                    // echo "success" . $redis->get('name');
                }
                else
                {
                    echo "Email or Password does not match";
                }
        }
        else
        {
            echo "Email or Password does not match";
        }

    }
    else
    {
        echo "All input fields are required!";
    }
    


?>