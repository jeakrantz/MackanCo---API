<?php

/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/


class User
{
    private $id;
    private $username;
    private $password;
    private $db;

    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Login user
    public function loginUser(string $username, string $password): bool
    {
        if (!$this->setUsername($username)) return false;
        if (!$this->setPassword($password)) return false;

        $this->username = $this->db->real_escape_string($this->username);
        $this->password = $this->db->real_escape_string($this->password);

        $sql = "SELECT * FROM user WHERE username='$this->username';";

        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $stored_password = $row['password'];

            if (password_verify($password, $stored_password)) {
                $_SESSION['id'] = $id;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //Register user
    public function registerUser(string $username, string $password): bool
    {
        if (!$this->setUsername($username)) return false;
        if (!$this->setPassword($password)) return false;

        $this->username = $this->db->real_escape_string($this->username);
        $this->password = $this->db->real_escape_string($this->password);


        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user(username, password)VALUES('$username', '$hashed_password');";
        $result = $this->db->query($sql);

        return $result;
    }

    //get user 
    public function getUser(): array
    {
        $sql = "SELECT * FROM user";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // get specific user by id
    public function getUserById(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM user WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    //Set methods
    public function setUsername(string $username): bool
    {
        if ($username != "") {
            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $this->username = $username;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setPassword(string $password): bool
    {
        if ($password != "") {
            if (strlen($password) > 6) {
                $this->password = $password;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Destructor
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
