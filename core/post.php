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
    public $msg;

    //post property for custpmer
    public $CustomerNo;
    public $name;
    public $email;
    public $creditLimit; 
    public $address;

    // post properties for payment voucher

    public $paymentDate;
    public $Amount;
    public $partyId;
    public $UserMobileNumber;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        //create query
        $query = 'SELECT * from ' . $this->table . 'order by id DESC';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT username, password from ' . $this->table . '  
        where username = :username and  password = :password LIMIT 1';
        $stmt = $this->conn->prepare($query);
        //binding param
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //if we found the user
        if ($row != '') {
            return $this->msg = 'success';
        } else {
            return  $this->msg = 'not found';
        }
    }

    public function get_customer(){
        $query = 'SELECT * '.$this->tableTarty.'
        where partyPhone = :phone LIMIT 1';
        $stmt = $this->conn->prepare($query);
        //binding param
        $stmt->bindParam(':phone', $this->CustomerNo);
    
        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['partyName'];
        $this->email = $row['partyEmail'];
        $this->address = $row['partyAddress'];
    }
    public function insert_bill()
    {
        $sql = "INSERT INTO tbl_paymentvoucher (paymentDate, amount, tbl_partyId) VALUES (:paymentDate,:amount,:tbl_partyId)";
        $stmt = $this->conn->prepare($sql);

        $this->paymentDate = htmlspecialchars(strip_tags($this->paymentDate));
        $this->Amount = htmlspecialchars(strip_tags($this->Amount));
        $this->partyId = htmlspecialchars(strip_tags($this->partyId));


        $stmt->bindParam(':paymentDate', $this->CustomerNo);
        $stmt->bindParam(':amount', $this->Amount);
        $stmt->bindParam(':partyId', $this->partyId);

        if($stmt->execute()){
            return true;
        }

    }
}
