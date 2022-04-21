<?php

class User
{
    public $name;
    public $password;
    public $stat;
    public $role;
    public $c_date;
    public $mod_by;

    private $connection;
    private $tbl;

    public function __construct($db_conn)
    {
        $this->connection = $db_conn;
        $this->tbl = "User_Table";
    }
    public function create_user()
    {
        $user_query = "INSERT INTO " . $this->tbl . " (`u_name`, `pass_word`, `status`, `role`, `modified_by`, `c_date`)
    Values ('" . $this->name . "',  '" . $this->password . "'," . $this->stat . ",'" . $this->role . "',modified_by ='" . $this->mod_by . "',NULL)";

        if ($this->connection->query($user_query)) {
            return true;
        } else {
            return false;
        }
    }
    public function Check_login()
    {
        $login_query = "SELECT * FROM " . $this->tbl . " WHERE u_name = '" . $this->name . "' ";
        //  $usr_obj = $this->conn->prepare($login_query);
        $usr_obj = mysqli_fetch_assoc(mysqli_query($this->connection, $login_query));
        if (!$usr_obj == null) {
            return $usr_obj;
        }
        return array();
    }
    public function SelectAll()
    {
        $all_query = "SELECT * FROM " . $this->tbl;
        $usr_obj = mysqli_fetch_assoc(mysqli_query($this->connection, $all_query));
        if (!$usr_obj == null) {
            return $usr_obj;
        }
        return array();
    }
}
