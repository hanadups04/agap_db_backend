<?php

require __DIR__ . '/../inc/dbcon.php';

/*--error422--*/
function error422($message){

    $data = [
        'status' => 422,
        'message' => $message, 
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}
/*--error422--*/


/*--ADMIN_ACC_TBL--*/
/*--READ admin_acc List Starts Here--*/
function getAdminList(){

    global $conn;

    $query = "SELECT * FROM admin_acc_tbl";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Admin List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Admin Found',
            ];
            header("HTTP/1.0 404 No Admin Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ admin_acc List Ends Here--*/
/*--SINGLE READ admin_acc Starts Here--*/
function getAdmin($adminParams){

    global $conn;

    if($adminParams['admin_id'] == null){

        return error422('Enter Admin id');

    } 

    $admin_id = mysqli_real_escape_string($conn, $adminParams['admin_id']);

    $query = "SELECT * FROM admin_acc_tbl WHERE admin_id='$admin_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Admin Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Admin Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ admin_acc Ends Here--*/
/*--INSERT admin_acc Starts Here--*/
function insertAdminAcc($adminAccInput){

    global $conn;

    $admin_id = 'ADMIN' . date('Y') . ' - ' . uniqid();
    $last_name = mysqli_real_escape_string($conn, $adminAccInput['last_name']);
    $first_name = mysqli_real_escape_string($conn, $adminAccInput['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $adminAccInput['middle_name']);
    $email = mysqli_real_escape_string($conn, $adminAccInput['email']);
    $password = mysqli_real_escape_string($conn, $adminAccInput['password']);
    $contact_info = mysqli_real_escape_string($conn, $adminAccInput['contact_info']);

    if(empty(trim($last_name))){

        return error422('Enter your last name');

    } elseif (empty(trim($first_name))) {

        return error422('Enter your first name');
    
    } elseif (empty(trim($middle_name))) {

        return error422('Enter your middle name');
    
    } elseif (empty(trim($email))) {

        return error422('Enter your email');

    } elseif (empty(trim($password))) {

        return error422('Enter your password');

    } elseif (empty(trim($contact_info))) {

        return error422('Enter your contact info');

    } else {
        
        $query = "INSERT INTO admin_acc_tbl (admin_id, last_name, first_name, middle_name, email, password,  contact_info) 
        VALUES ('$admin_id','$last_name','$first_name','$middle_name','$email','$password','$contact_info')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Admin Account Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--INSERT admin_acc Ends Here--*/
/*--UPDATE admin_acc Starts Here--*/
function updateAdminAcc($adminAccInput, $adminParams){

    global $conn;

    if(!isset($adminParams['admin_id'])){

        return error422('Admin id not found in URL');

    } elseif($adminParams['admin_id'] == null){

        return error422('Enter the Admin id');

    }

    $admin_id = mysqli_real_escape_string($conn, $adminParams['admin_id']);
    $last_name = mysqli_real_escape_string($conn, $adminAccInput['last_name']);
    $first_name = mysqli_real_escape_string($conn, $adminAccInput['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $adminAccInput['middle_name']);
    $email = mysqli_real_escape_string($conn, $adminAccInput['email']);
    $password = mysqli_real_escape_string($conn, $adminAccInput['password']);
    $contact_info = mysqli_real_escape_string($conn, $adminAccInput['contact_info']);

    if(empty(trim($last_name))){

        return error422('Enter your last name');

    } elseif (empty(trim($first_name))) {

        return error422('Enter your first name');

    } elseif (empty(trim($middle_name))) {

        return error422('Enter your middle name');
    
    } elseif (empty(trim($email))) {

        return error422('Enter your email');

    } elseif (empty(trim($password))) {

        return error422('Enter your password');

    } elseif (empty(trim($contact_info))) {

        return error422('Enter your contact info');

    } else {

        $query = "UPDATE admin_acc_tbl SET last_name='$last_name', first_name='$first_name',  
        middle_name='$middle_name', email='$email', password='$password', contact_info='$contact_info' 
        WHERE admin_id ='$admin_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Admin Account Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--UPDATE admin_acc Ends Here--*/
/*--DELETE admin_acc Starts Here--*/



function deleteAdminAcc($adminParams){

    global $conn;

    if(!isset($adminParams['admin_id'])){

        return error422('Admin id not found in URL');

    } elseif($adminParams['admin_id'] == null){

        return error422('Enter the Admin id');

    }

    $admin_id = mysqli_real_escape_string($conn, $adminParams['admin_id']);

    $query = "DELETE FROM admin_acc_tbl WHERE admin_id='$admin_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Admin Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    } else {

        $data = [
            'status' => 404,
            'message' => 'Admin Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
    
}
/*--DELETE admin_acc Ends Here--*/
/*--ADMIN_ACC_TBL--*/


/*--DEPT_CATEGORY_TBL--*/
/*--INSERT dept_category Starts Here--*/
function insertDeptCategory($deptCategoryInput){

    global $conn;

    $category_name = mysqli_real_escape_string($conn, $deptCategoryInput['category_name']);

    if(empty(trim($category_name))){

        return error422('Enter Department Category Name');

    } else {
        
        $query = "INSERT INTO dept_category_tbl (category_name) VALUES ('$category_name')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Department Category Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--INSERT dept_category Ends Here--*/
/*--DEPT_CATEGORY_TBL--*/


/*--DONATION_TBL--*/
/*--READ Donation List Starts Here--*/
function getDonationList(){

    global $conn;

    $query = "SELECT 
        donation_tbl.donation_id,
        donation_status_tbl.status_name,
        recipient_category_tbl.recipient_type,
        event_tbl.event_name,
        donation_tbl.received_by
    FROM
    donation_tbl
    INNER JOIN donation_status_tbl ON donation_tbl.status_id = donation_status_tbl.status_id
    INNER JOIN recipient_category_tbl ON donation_tbl.recipient_id = recipient_category_tbl.recipient_category_id
    INNER JOIN event_tbl ON donation_tbl.event_id = event_tbl.evenet_id;";

    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Donation List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Donation Found',
            ];
            header("HTTP/1.0 404 No Donation Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ Donation List Ends Here--*/
/*--SINGLE READ Donation Starts Here--*/
function getDonation($donationParams){

    global $conn;

    if($donationParams['donation_id'] == null){

        return error422('Enter Donation id');

    } 

    $donation_id = mysqli_real_escape_string($conn, $donationParams['donation_id']);

    $query = "SELECT 
        donation_tbl.donation_id,
        donation_status_tbl.status_name,
        recipient_category_tbl.recipient_type,
        event_tbl.event_name,
        donation_tbl.received_by
    FROM
    donation_tbl
    INNER JOIN donation_status_tbl ON donation_tbl.status_id = donation_status_tbl.status_id
    INNER JOIN recipient_category_tbl ON donation_tbl.recipient_id = recipient_category_tbl.recipient_category_id
    INNER JOIN event_tbl ON donation_tbl.event_id = event_tbl.evenet_id
    WHERE donation_tbl.donation_id='$donation_id' LIMIT 1;";

    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Donation Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Donation Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ Donation Ends Here--*/
/*--DONATION_TBL--*/


/*--DONATION_ITEMS_TBL--*/
/*--READ Donation Items List Starts Here--*/
function getDonationItemsList(){

    global $conn;

    $query = "SELECT 
        donation_items_tbl.item,
        item_category_tbl.category_name,
        donation_items_tbl.qty,
        donation_items_tbl.cost,
        donation_items_tbl.donor_signature
    FROM
    donation_items_tbl
    INNER JOIN item_category_tbl ON item_category_tbl.item_category_id = donation_items_tbl.item_category_id;";

    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Donation Items List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Donation Item Found',
            ];
            header("HTTP/1.0 404 No Donation Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ Donation Items List Ends Here--*/
/*--SINGLE READ Donation Items Starts Here--*/
function getDonationItem($donationItemsParams){

    global $conn;

    if($donationItemsParams['donation_items_id'] == null){

        return error422('Enter Donation id');

    } 

    $donation_items_id = mysqli_real_escape_string($conn, $donationItemsParams['donation_items_id']);

    $query = "SELECT 
        donation_items_tbl.item,
        item_category_tbl.category_name,
        donation_items_tbl.qty,
        donation_items_tbl.cost,
        donation_items_tbl.donor_signature
    FROM
    donation_items_tbl
    INNER JOIN item_category_tbl ON item_category_tbl.item_category_id = donation_items_tbl.item_category_id
    WHERE donation_items_tbl.donation_items_id='$donation_items_id' LIMIT 1;";

    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Donation Item Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Donation Item Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ Donation Items Ends Here--*/
/*--DONATION_ITEMS_TBL--*/


/*--DONORS_ACC_TBL--*/
/*--READ Donor List Starts Here--*/
function getDonorList(){

    global $conn;

    $query = "SELECT 
        donors_acc_tbl.donor_id, 
        donors_acc_tbl.last_name,
        donors_acc_tbl.first_name,
        donors_acc_tbl.middle_name,
        dept_category_tbl.category_name,
        donors_acc_tbl.email,
        donors_acc_tbl.password,
        donors_acc_tbl.contact_info
    FROM
    donors_acc_tbl
    INNER JOIN dept_category_tbl ON donors_acc_tbl.dept_category_id = dept_category_tbl.dept_category_id;";
    
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Donor List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Donor Found',
            ];
            header("HTTP/1.0 404 No Donor Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ Donor List Ends Here--*/
/*--SINGLE READ Donor Starts Here--*/
function getDonor($donorAccParams){

    global $conn;

    if($donorAccParams['donor_id'] == null){

        return error422('Enter Donor id');

    } 

    $donor_id = mysqli_real_escape_string($conn, $donorAccParams['donor_id']);

    $query = "SELECT 
        donors_acc_tbl.donor_id, 
        donors_acc_tbl.last_name,
        donors_acc_tbl.first_name,
        donors_acc_tbl.middle_name,
        dept_category_tbl.category_name,
        donors_acc_tbl.email,
        donors_acc_tbl.password,
        donors_acc_tbl.contact_info
    FROM
    donors_acc_tbl
    INNER JOIN dept_category_tbl ON donors_acc_tbl.dept_category_id = dept_category_tbl.dept_category_id WHERE donors_acc_tbl.donor_id='$donor_id' LIMIT 1;";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Donor Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Donor Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ Donor Ends Here--*/
/*--UPDATE donor_acc Starts Here--*/
function updateDonorAcc($donorAccInput, $donorAccParams){

    global $conn;

    if(!isset($donorAccParams['donor_id'])){

        return error422('Donor id not found in URL');

    } elseif($donorAccParams['donor_id'] == null){

        return error422('Enter the Donor id');

    }

    $donor_id = mysqli_real_escape_string($conn, $donorAccParams['donor_id']);
    $last_name = mysqli_real_escape_string($conn, $donorAccInput['last_name']);
    $first_name = mysqli_real_escape_string($conn, $donorAccInput['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $donorAccInput['middle_name']);
    $dept_category_id = mysqli_real_escape_string($conn, $donorAccInput['dept_category_id']);
    $email = mysqli_real_escape_string($conn, $donorAccInput['email']);
    $password = mysqli_real_escape_string($conn, $donorAccInput['password']);
    $contact_info = mysqli_real_escape_string($conn, $donorAccInput['contact_info']);
    $acc_status_id = mysqli_real_escape_string($conn, $donorAccInput['acc_status_id']);

    if(empty(trim($last_name))){

        return error422('Enter your last name');

    } elseif (empty(trim($first_name))) {

        return error422('Enter your first name');

    } elseif (empty(trim($middle_name))) {

        return error422('Enter your middle name');

    } elseif (empty(trim($dept_category_id))) {

        return error422('Enter department category id');
    
    } elseif (empty(trim($email))) {

        return error422('Enter your email');

    } elseif (empty(trim($password))) {

        return error422('Enter your password');

    } elseif (empty(trim($contact_info))) {

        return error422('Enter your contact info');

    } elseif (empty(trim($acc_status_id))) {

        return error422('Enter account status id');

    } else {

        $query = "UPDATE donors_acc_tbl SET last_name='$last_name', first_name='$first_name',  middle_name='$middle_name', 
        dept_category_id='$dept_category_id', email='$email', password='$password', contact_info='$contact_info', acc_status_id='$acc_status_id' 
        WHERE donor_id ='$donor_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Donor Account Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--UPDATE donor_acc Ends Here--*/
/*--DONORS_ACC_TBL--*/



/*--EVENT_TBL--*/
/*--READ Event List Starts Here--*/
function getEventList(){

    global $conn;

    $query = "SELECT * FROM event_tbl";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Event List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Event Found',
            ];
            header("HTTP/1.0 404 No Event Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ Event List Ends Here--*/
/*--SINGLE READ Event Starts Here--*/
function getEvent($eventParams){

    global $conn;

    if($eventParams['evenet_id'] == null){

        return error422('Enter Event id');

    } 

    $evenet_id = mysqli_real_escape_string($conn, $eventParams['evenet_id']);

    $query = "SELECT * FROM event_tbl WHERE evenet_id='$evenet_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Event Fetched Successfully', 
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Event Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ Event Ends Here--*/
/*--INSERT event Starts Here--*/
function insertEvent($eventInput){

    global $conn;

    $event_id = 'EVENT' . date('Y') . ' - ' . uniqid();
    $name = mysqli_real_escape_string($conn, $eventInput['event_name']);
    $event_link = mysqli_real_escape_string($conn, $eventInput['event_link']);
    $description = mysqli_real_escape_string($conn, $eventInput['description']);
    $start_date = mysqli_real_escape_string($conn, $eventInput['start_date']);
    $end_date = mysqli_real_escape_string($conn, $eventInput['end_date']);
    $contribution_amount = mysqli_real_escape_string($conn, $eventInput['contrib_amount']);


    if (empty(trim($name))) {

        return error422('Enter valid name');

    } elseif (empty(trim($event_link))) {

        return error422('Enter valid event link');

    } elseif (empty(trim($description))) {

        return error422('Enter valid description');

    } elseif (empty(trim($start_date))) {

        return error422('Enter valid start date');

    } elseif (empty(trim($end_date))) {

        return error422('Enter valid end date');

    } elseif (empty(trim($contribution_amount))) {

        return error422('Enter valid contribution amount');

    } else {
        $query = "INSERT INTO 
            event_tbl(
                evenet_id, 
                event_name, 
                event_link, 
                description, 
                start_date, 
                end_date, 
                contrib_amount) 
            VALUES(
                '$event_id', 
                '$name', 
                '$event_link', 
                '$description', 
                '$start_date', 
                '$end_date', 
                '$contribution_amount')";
        $result = mysqli_query($conn, $query);

        if ($result) {

            $data = [
                'status' => 201,
                'message' => 'Event Inserted',
            ];
            header("HTTP/1.0 201 Inserted");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--INSERT Event Ends Here--*/
/*--UPDATE Event Starts Here--*/
function updateEvent($eventInput, $eventParams){

    global $conn;

    if(!isset($eventParams['evenet_id'])){

        return error422('Event id not found in URL');

    } elseif($eventParams['evenet_id'] == null){

        return error422('Enter the Event id');

    }

    $event_id = mysqli_real_escape_string($conn, $eventParams['evenet_id']);
    $event_name = mysqli_real_escape_string($conn, $eventInput['event_name']);
    $event_link = mysqli_real_escape_string($conn, $eventInput['event_link']);
    $description = mysqli_real_escape_string($conn, $eventInput['description']);
    $start_date = mysqli_real_escape_string($conn, $eventInput['start_date']);
    $end_date = mysqli_real_escape_string($conn, $eventInput['end_date']);
    $contribution_amount = mysqli_real_escape_string($conn, $eventInput['contrib_amount']);

    if(empty(trim($event_name))){

        return error422('Enter valid event name');

    } elseif (empty(trim($event_link))) {

        return error422('Enter valid event link');

    } elseif (empty(trim($description))) {

        return error422('Enter valid description');

    } elseif (empty(trim($start_date))) {

        return error422('Enter valid start date');

    } elseif (empty(trim($end_date))) {

        return error422('Enter valid end date');

    } elseif (empty(trim($contribution_amount))) {

        return error422('Enter valid contribution amount');

    } else {

        $query = "UPDATE event_tbl SET event_name='$event_name', event_link='$event_link',  
        description='$description', start_date='$start_date', end_date='$end_date', contrib_amount='$contribution_amount' 
        WHERE evenet_id ='$event_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Event Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--UPDATE Event Ends Here--*/
/*--EVENT_TBL--*/


/*--ITEMS_CATEGORY_TBL--*/
/*--INSERT category Starts Here--*/
function insertItemCategory($itemCategoryInput){

    global $conn;

    $category_name = mysqli_real_escape_string($conn, $itemCategoryInput['category_name']);

    if(empty(trim($category_name))){

        return error422('Enter Partner Name');

    } else {
        
        $query = "INSERT INTO item_category_tbl (category_name) VALUES ('$category_name')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Item Category Name Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--INSERT category Ends Here--*/
/*--ITEMS_CATEGORY_TBL--*/


/*--PARTNERS_TBL--*/
/*--READ Partner List Starts Here--*/
function getPartnerList(){

    global $conn;

    $query = "SELECT * FROM partners_tbl";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Partner List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Partner Found',
            ];
            header("HTTP/1.0 404 No Partner Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ Partner List Ends Here--*/
/*--SINGLE READ Partner Starts Here--*/
function getPartner($partnerParams){

    global $conn;

    if($partnerParams['partner_id'] == null){

        return error422('Enter Partner id');

    } 

    $partner_id = mysqli_real_escape_string($conn, $partnerParams['partner_id']);

    $query = "SELECT * FROM partners_tbl WHERE partner_id='$partner_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Partner Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Partner Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ Partner Ends Here--*/
/*--INSERT partners Starts Here--*/
function insertPartner($partnerInput){

    global $conn;

    $partner_id = 'PARTNER' . date('Y') . ' - ' . uniqid();
    $partner_name = mysqli_real_escape_string($conn, $partnerInput['partner_name']);

    if(empty(trim($partner_name))){

        return error422('Enter Partner Name');

    } else {
        
        $query = "INSERT INTO partners_tbl (partner_id, partner_name) VALUES ('$partner_id','$partner_name')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'Partner Name Inserted Successfully',
            ];
            header("HTTP/1.0 201 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--INSERT Partner Ends Here--*/
/*--UPDATE Partner Starts Here--*/
function updatePartner($partnerInput, $partnerParams){

    global $conn;

    if(!isset($partnerParams['partner_id'])){

        return error422('Partner id not found in URL');

    } elseif($partnerParams['partner_id'] == null){

        return error422('Enter the Partner id');

    }

    $partner_id = mysqli_real_escape_string($conn, $partnerParams['partner_id']);
    $partner_name = mysqli_real_escape_string($conn, $partnerInput['partner_name']);
    
    if(empty(trim($partner_name))){

        return error422('Enter partner name');

    } else {

        $query = "UPDATE partners_tbl SET partner_name='$partner_name' WHERE partner_id ='$partner_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Partners Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--UPDATE Partner Ends Here--*/
/*--DELETE Partner Starts Here--*/
function deletePartner($partnerParams){

    global $conn;

    if(!isset($partnerParams['partner_id'])){

        return error422('Partner id not found in URL');

    } elseif($partnerParams['partner_id'] == null){

        return error422('Enter the Partner id');

    }

    $partner_id = mysqli_real_escape_string($conn, $partnerParams['partner_id']);

    $query = "DELETE FROM partners_tbl WHERE partner_id='$partner_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'Partner Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    } else {

        $data = [
            'status' => 404,
            'message' => 'Partner Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
    
}
/*--DELETE Partner Ends Here--*/
/*--PARTNERS_TBL--*/


/*--PHASE2_TBL--*/
/*--READ Phase2 List Starts Here--*/
function getPhase2List(){

    global $conn;

    $query = "SELECT 
        phase2_tbl.log_id, 
        event_tbl.event_name,
        volunteer_acc_tbl.last_name,
        volunteer_acc_tbl.first_name,
        phase2_tbl.activity,
        phase2_tbl.time_in,
        phase2_tbl.time_out,
        phase2_tbl.signature,
        phase2_tbl.date
    FROM
    phase2_tbl
    INNER JOIN event_tbl ON phase2_tbl.event_id = event_tbl.evenet_id
    INNER JOIN volunteer_acc_tbl ON phase2_tbl.volunteer_id = volunteer_acc_tbl.volunteer_id;";
    
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Phase 2 List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Log Found',
            ];
            header("HTTP/1.0 404 No Log Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ Phase2 List Ends Here--*/
/*--SINGLE READ Phase2 Starts Here--*/
function getPhase2($phase2Params){

    global $conn;

    if($phase2Params['log_id'] == null){

        return error422('Enter log id');

    } 

    $log_id = mysqli_real_escape_string($conn, $phase2Params['log_id']);

    $query = "SELECT 
        phase2_tbl.log_id, 
        event_tbl.event_name,
        volunteer_acc_tbl.last_name,
        volunteer_acc_tbl.first_name,
        phase2_tbl.activity,
        phase2_tbl.time_in,
        phase2_tbl.time_out,
        phase2_tbl.signature,
        phase2_tbl.date
    FROM
    phase2_tbl
    INNER JOIN event_tbl ON phase2_tbl.event_id = event_tbl.evenet_id
    INNER JOIN volunteer_acc_tbl ON phase2_tbl.volunteer_id = volunteer_acc_tbl.volunteer_id
    WHERE phase2_tbl.log_id='$log_id' LIMIT 1;";

    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Phase 2 log Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Phase2 log Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ Phase2 Ends Here--*/
/*--UPDATE Phase2 Starts Here--*/
function updatePhase2($phase2Input, $phase2Params){

    global $conn;

    if(!isset($phase2Params['log_id'])){

        return error422('Log id not found in URL');

    } elseif($phase2Params['log_id'] == null){

        return error422('Enter the Phase 2 Log id');

    }

    $log_id = mysqli_real_escape_string($conn, $phase2Params['log_id']);
    $activity = mysqli_real_escape_string($conn, $phase2Input['activity']);
    $time_in = mysqli_real_escape_string($conn, $phase2Input['time_in']);
    $time_out = mysqli_real_escape_string($conn, $phase2Input['time_out']);
    $signature = mysqli_real_escape_string($conn, $phase2Input['signature']);
    $date = mysqli_real_escape_string($conn, $phase2Input['date']);

    if(empty(trim($activity))){

        return error422('Enter activity');

    } elseif (empty(trim($time_in))) {

        return error422('Enter time in');

    } elseif (empty(trim($time_out))) {

        return error422('Enter time_out');
    
    } elseif (empty(trim($signature))) {

        return error422('Enter signature');

    } elseif (empty(trim($date))) {

        return error422('Enter date');

    } else {

        $query = "UPDATE phase2_tbl SET activity='$activity', time_in='$time_in',  
        time_out='$time_out', signature='$signature', date='$date'
        WHERE log_id ='$log_id' LIMIT 1";

        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Log Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--UPDATE admin_acc Ends Here--*/
/*--PHASE2_TBL--*/


/*--PHASE3_TBL--*/
/*--READ Phase3 List Starts Here--*/
function getPhase3List(){

    global $conn;

    $query = "SELECT 
        phase3_tbl.log_id, 
        event_tbl.event_name,
        volunteer_acc_tbl.last_name,
        volunteer_acc_tbl.first_name,
        phase3_tbl.time_in,
        phase3_tbl.time_out,
        phase3_tbl.signature,
        phase3_tbl.date
    FROM
    phase3_tbl
    INNER JOIN event_tbl ON phase3_tbl.event_id = event_tbl.evenet_id
    INNER JOIN volunteer_acc_tbl ON phase3_tbl.volunteer_id = volunteer_acc_tbl.volunteer_id;";
    
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Phase 3 List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Log Found',
            ];
            header("HTTP/1.0 404 No Log Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ Phase2 List Ends Here--*/
/*--SINGLE READ Phase2 Starts Here--*/
function getPhase3($phase3Params){

    global $conn;

    if($phase3Params['log_id'] == null){

        return error422('Enter log id');

    } 

    $log_id = mysqli_real_escape_string($conn, $phase3Params['log_id']);

    $query = "SELECT 
        phase3_tbl.log_id, 
        event_tbl.event_name,
        volunteer_acc_tbl.last_name,
        volunteer_acc_tbl.first_name,
        phase3_tbl.time_in,
        phase3_tbl.time_out,
        phase3_tbl.signature,
        phase3_tbl.date
    FROM
    phase3_tbl
    INNER JOIN event_tbl ON phase3_tbl.event_id = event_tbl.evenet_id
    INNER JOIN volunteer_acc_tbl ON phase3_tbl.volunteer_id = volunteer_acc_tbl.volunteer_id
    WHERE phase3_tbl.log_id='$log_id' LIMIT 1;";

    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Phase 3 log Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Phase3 log Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ Phase2 Ends Here--*/
/*--UPDATE Phase2 Starts Here--*/
function updatePhase3($phase3Input, $phase3Params){

    global $conn;

    if(!isset($phase3Params['log_id'])){

        return error422('Log id not found in URL');

    } elseif($phase3Params['log_id'] == null){

        return error422('Enter the Phase 3 Log id');

    }

    $log_id = mysqli_real_escape_string($conn, $phase3Params['log_id']);
    $time_in = mysqli_real_escape_string($conn, $phase3Input['time_in']);
    $time_out = mysqli_real_escape_string($conn, $phase3Input['time_out']);
    $signature = mysqli_real_escape_string($conn, $phase3Input['signature']);
    $date = mysqli_real_escape_string($conn, $phase3Input['date']);

    if(empty(trim($time_in))){

        return error422('Enter time in');

    } elseif (empty(trim($time_out))) {

        return error422('Enter time_out');
    
    } elseif (empty(trim($signature))) {

        return error422('Enter signature');

    } elseif (empty(trim($date))) {

        return error422('Enter date');

    } else {

        $query = "UPDATE phase3_tbl SET time_in='$time_in',  
        time_out='$time_out', signature='$signature', date='$date'
        WHERE log_id ='$log_id' LIMIT 1";

        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Log Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--UPDATE admin_acc Ends Here--*/
/*--PHASE3_TBL--*/


/*--VOLUNTEER_ACC_TBL--*/
/*--READ Volunteer List Starts Here--*/
function getVolunteerList(){

    global $conn;

    $query = "SELECT 
        volunteer_acc_tbl.volunteer_id, 
        volunteer_acc_tbl.last_name,
        volunteer_acc_tbl.first_name,
        volunteer_acc_tbl.middle_name,
        volunteer_acc_tbl.email,
        volunteer_acc_tbl.password,
        volunteer_acc_tbl.contact_info,
        volunteer_acc_tbl.total_hours,
        dept_category_tbl.category_name,
        volunteer_acc_tbl.section,
        designation_category_tbl.designation_name
    FROM
    volunteer_acc_tbl
    INNER JOIN dept_category_tbl ON volunteer_acc_tbl.dept_category_id = dept_category_tbl.dept_category_id
    INNER JOIN designation_category_tbl ON volunteer_acc_tbl.designation_id = designation_category_tbl.designation_id;";
    
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Volunteer List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Volunteer Found',
            ];
            header("HTTP/1.0 404 No Volunteer Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
/*--READ Volunteer List Ends Here--*/
/*--SINGLE READ Volunteer Starts Here--*/
function getVolunteer($volunteerAccParams){

    global $conn;

    if($volunteerAccParams['volunteer_id'] == null){

        return error422('Enter Volunteer id');

    } 

    $volunteer_id = mysqli_real_escape_string($conn, $volunteerAccParams['volunteer_id']);

    $query = "SELECT 
        volunteer_acc_tbl.volunteer_id, 
        volunteer_acc_tbl.last_name,
        volunteer_acc_tbl.first_name,
        volunteer_acc_tbl.middle_name,
        volunteer_acc_tbl.email,
        volunteer_acc_tbl.password,
        volunteer_acc_tbl.contact_info,
        volunteer_acc_tbl.total_hours,
        dept_category_tbl.category_name,
        volunteer_acc_tbl.section,
        designation_category_tbl.designation_name
    FROM
    volunteer_acc_tbl
    INNER JOIN dept_category_tbl ON volunteer_acc_tbl.dept_category_id = dept_category_tbl.dept_category_id
    INNER JOIN designation_category_tbl ON volunteer_acc_tbl.designation_id = designation_category_tbl.designation_id 
    WHERE volunteer_acc_tbl.volunteer_id='$volunteer_id' LIMIT 1;";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Volunteer Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Volunteer Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}
/*--SINGLE READ Volunteer Ends Here--*/
/*--UPDATE volunteer_acc Starts Here--*/
function updateVolunteerAcc($volunteerAccInput, $volunteerAccParams){

    global $conn;

    if(!isset($volunteerAccParams['volunteer_id'])){

        return error422('Volunteer id not found in URL');

    } elseif($volunteerAccParams['volunteer_id'] == null){

        return error422('Enter the Volunteer id');

    }

    $volunteer_id = mysqli_real_escape_string($conn, $volunteerAccParams['volunteer_id']);
    $last_name = mysqli_real_escape_string($conn, $volunteerAccInput['last_name']);
    $first_name = mysqli_real_escape_string($conn, $volunteerAccInput['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $volunteerAccInput['middle_name']);
    $email = mysqli_real_escape_string($conn, $volunteerAccInput['email']);
    $password = mysqli_real_escape_string($conn, $volunteerAccInput['password']);
    $contact_info = mysqli_real_escape_string($conn, $volunteerAccInput['contact_info']);
    $total_hours = mysqli_real_escape_string($conn, $volunteerAccInput['total_hours']);
    $dept_category_id = mysqli_real_escape_string($conn, $volunteerAccInput['dept_category_id']);
    $section = mysqli_real_escape_string($conn, $volunteerAccInput['section']);
    $designation_id = mysqli_real_escape_string($conn, $volunteerAccInput['designation_id']);
    $acc_status_id = mysqli_real_escape_string($conn, $volunteerAccInput['acc_status_id']);

    if(empty(trim($last_name))){

        return error422('Enter your last name');

    } elseif (empty(trim($first_name))) {

        return error422('Enter your first name');

    } elseif (empty(trim($middle_name))) {

        return error422('Enter your middle name');
    
    } elseif (empty(trim($email))) {

        return error422('Enter your email');

    } elseif (empty(trim($password))) {

        return error422('Enter your password');

    } elseif (empty(trim($contact_info))) {

        return error422('Enter your contact info');

    } elseif (empty(trim($total_hours))) {

        return error422('Enter total hours');
    
    } elseif (empty(trim($dept_category_id))) {

        return error422('Enter department category id');

    } elseif (empty(trim($section))) {

        return error422('Enter section');

    } elseif (empty(trim($designation_id))) {

        return error422('Enter designation id');

    } elseif (empty(trim($acc_status_id))) {

        return error422('Enter account status id');

    } else {

        $query = "UPDATE volunteer_acc_tbl SET last_name='$last_name', first_name='$first_name',  middle_name='$middle_name', 
        email='$email', password='$password', contact_info='$contact_info', total_hours='$total_hours', 
        dept_category_id='$dept_category_id', section='$section', designation_id='$designation_id', acc_status_id='$acc_status_id' 
        WHERE volunteer_id ='$volunteer_id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'Volunteer Account Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);

        } else {

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
/*--UPDATE volunteer_acc Ends Here--*/
/*--VOLUNTEER_ACC_TBL--*/

?>