<?php

class Post
{

    //db stuff
    private $conn;
    public $db;
    private $table = 'api_user_login';

    //post properties
    public $id;
    public $name;

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
        where id = ? LIMIT 1';
        $stmt = $this->conn->prepare($query);
        //binding param
        $stmt->bindParam(1, $this->id);
        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['username'];
        
    }
    public function insert_bill()
    {
        $sql = "INSERT INTO tbl_paymentvoucher (paymentDate, amount, tbl_partyId) VALUES (?,?,?)";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute([$paymentDate, $amount, $party]);
        
    }
}
