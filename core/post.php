<?php 

class Post{

    //db stuff
    private $conn;
    private $table = 'tbl_name';
    
    //post properties
    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function read(){
        //create query
        $query = 'SELECT * from '.$this->table .'  
                  order by id desc';
    
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();

        return $stmt;
    }

}