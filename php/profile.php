<?php

    $conn = mysqli_connect("localhost","root","","guvi_db");        //connecting the database
    if(!$conn)
    {
        echo "Database not connected" . mysqli_connect_error();
    }

    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $email = mysqli_real_escape_string($conn, $_POST['hiddenvalue']);
    // $dob = "something";
    // $contact = "123";
    // $age = "12";
    // $gender = "female";
    


    require '../assets/mongo/vendor/autoload.php';  
    // Creating Connection  
    $serverApi = new \MongoDB\Driver\ServerApi(\MongoDB\Driver\ServerApi::V1);
    $client = new \MongoDB\Client('mongodb+srv://sanjaykumar:Sanjay123@cluster0.ozfc3vq.mongodb.net/test', [], ['serverApi' => $serverApi]);

    $db = $client->GuviDB;

    // Creating Document  
    $collection = $db->users;
    
    $updated =  $collection->updateOne(['email' => $email],
    ['$set' => ['date-of-bitrh' => $dob,'contact-no'=>$contact,'age'=>$age,'gender'=>$gender]],['upsert'=>true]
    

);   

    // Insering Record  
    // if(!$updated){
    // $collection->insertOne( [ 'date-of-bitrh' => $dob, 'contact-no' => $contact, 'age' => $age, 'gender' => $gender ] );
    // }
    echo "success";
?>