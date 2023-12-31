<?php

class Post
{
    //db stuff
    private $conn;
    private $table = 'api_user_login';
    private $tableTarty = 'tbl_party';

    //post properties
    public $id;
    public $username;
    public $password;
    public $getOptionalAmount;
    public $msg;

    //post property for custpmer
    public $customerNo;
    public $name;
    public $email;
    public $creditLimit;
    public $address;

    // post properties for payment voucher

    public $CustomerNo;
    public $paymentDate;
    public $Amount;
    public $partyId;
    public $UserMobileNumber;
    public $payMethod = "Bkash";

    // search quert
    public $TrxId;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function authentication()
    {
        $query = 'SELECT username, password from ' . $this->table . '  
         where username = :username and  password = :password  LIMIT 1';

        $stmt = $this->conn->prepare($query);
        //binding param
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        //execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //return $this->msg = print_r($row['CustomerNo']);
        //if we found the user
        if ($row != '') {
            // return $row;
            return $this->msg = 'Successful';
        } else {
            return  $this->msg = 'not found';
        }
    }

    public function get_customer()
    {
        $query = 'SELECT * from ' . $this->tableTarty . ' 
          where partyPhone = :phone LIMIT 1';
        $stmt = $this->conn->prepare($query);
        //binding param
        $stmt->bindParam(':phone', $this->customerNo);

        //execute query
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->name = $row['partyName'];
            $this->email = $row['partyEmail'];
            $this->address = $row['partyAddress'];
            $this->msg = 'success_getCustomer';
        }

      
    }
    public function payBill()
    {
        //get party Id
        $query = 'SELECT id from ' . $this->tableTarty . ' where partyPhone LIKE  :phone LIMIT 1';
        $stmt = $this->conn->prepare($query);
        //binding param
        $customerNo = '%'.$this->customerNo.'%';
        $stmt->bindParam(':phone',  $customerNo , PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->partyId = $row['id'];

        $sql = "INSERT INTO tbl_paymentvoucher (paymentDate, amount, tbl_partyId, paymentMethod,bkash_trxId) VALUES (:paymentDate,:amount,:partyId,:payMethod,:bkash_trxId)";
        $stmt = $this->conn->prepare($sql);

        $this->paymentDate = htmlspecialchars(strip_tags($this->paymentDate));
        $this->Amount      = htmlspecialchars(strip_tags($this->Amount));
        $this->partyId     = htmlspecialchars(strip_tags($this->partyId));
        $this->TrxId       = htmlspecialchars(strip_tags($this->TrxId));

        $stmt->bindParam(':paymentDate', $this->paymentDate);
        $stmt->bindParam(':amount', $this->Amount);
        $stmt->bindParam(':partyId', $this->partyId);
        $stmt->bindParam(':payMethod', $this->payMethod);
        $stmt->bindParam(':bkash_trxId', $this->TrxId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function searchTransaction()
    {
        //query
        $query = 'SELECT * from tbl_paymentvoucher Where paymentMethod = "Bkash" AND bkash_trxId = :bkash_trxId order by id DESC';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':bkash_trxId', $this->TrxId);

        //execute query
        $stmt->execute();
        //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //if we found the user

        return $stmt;
    }
}
