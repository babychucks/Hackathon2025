<?php


header("Content-Type: application/json");

class API
{

    private $con;

    public static function instance()
    {
        static $instance = null;
        if ($instance === null)
            $instance = new API();

        return $instance;
    }

    private function __construct()
    {
        require_once "config.php";
        $this->con = $connection;
    }

    public function __destruct()
    {
        $this->con = null;
    }

    //validates and dispatches incoming requests
    public function reqHandler($obj, $req)
    {

        $types = [
            "Login",
            "SignUp",
            "GetIncCategory",
            "GetExpCategory",
            "GetPoints",
            "GetTransactions",
            "GetUserPoints",
            "AddCategory",
            "RemoveCategory",
            "AddTransaction",
            "RemoveTransaction",
            "AddUserPoints",
            "RemoveUserPoints"
        ];


        $message = "";
        $err = false;

        if ($req !== "POST") {
            $message = "Invalid Request";
            $err = true;
        }

        if (!$obj && urldecode($obj) == null) {
            $message = "Invalid Object";
            $err = true;
        }

        if (!isset($obj['type'])) {
            $message = "Missing Post Parameter";
            $err = true;
        }


        $typeCheck = array_intersect($types, $obj['type']);
        if (sizeof($typeCheck) < 1) {
            $message = "Invalid Post type";
            $err = true;
        }

        if ($err)
            return $this->response("HTTP/1.1 400 Bad Request", null, "error", $message, null);

        //  ------------------------------------------------------------

        foreach ($obj as $key => $value) {
            if (is_array($value)) {
                foreach ($obj[$key] as $innerkey => $innervalue) {
                    if (is_string($innervalue))
                        $obj[$key][$innerkey] = htmlspecialchars(trim($innervalue));
                }
            } else {
                if (is_string($value))
                    $obj[$key] = htmlspecialchars(trim($value));
            }
        }

        //  ------------------------------------------------------------

        $api_key = $obj['api_key'];

        if (!$this->checkApiKey($api_key))
            return $this->response("HTTP/1.1 400 Bad Request", null, "error", "unrecognised user", null);

        switch ($obj['type']) {
            case "Login":
                $this->login($obj['email'], $obj['password']);
                break;

            case "SignUp":
                $this->sign_up($obj);
                break;

            case "GetIncCategory":
                $this->getIncCategory($api_key);
                break;

            case "GetExpCategory":
                $this->getExpCategory($api_key);
                break;

            case "GetPoints":
                $this->getPoints($api_key);
                break;

            case "GetTransactions":
                $this->getTransactions($api_key, $obj);
                break;

            case "GetUserPoints":
                $this->getUserPoints($api_key);
                break;

            case "AddCategory":
                $this->addCategory($api_key, $obj);
                break;

            case "AddTransaction":
                $this->addTransaction($api_key, $obj);
                break;

            case "AddUserPoints":
                $this->addUserPoints($api_key, $obj);
                break;

            case "RemoveCategory":
                $this->removeCategory($api_key, $obj);
                break;

            case "RemoveTransaction":
                $this->removeTransaction($api_key, $obj['transaction_id']);
                break;

            case "RemoveUserPoints":
                $this->removeUserPoints($api_key, $obj['point_id']);
                break;

            default:
                return;
        }
    }

    private function checkApiKey($api_key)
    {
        if (empty($api_key))
            return false;

        $stmt = $this->con->prepare("SELECT id FROM Users WHERE api_key = :api_Key");
        $stmt->bindparam("api_key", $api_key);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return !(count($result) > 0);
    }

    private function response($header, $type, $result, $message, $data)
    {
    }

    // Getters

    private function login($email, $password)
    {
        if (empty($email) || empty($password))
            return $this->response("HTTP/1.1 400 Bad Request", "Login", "error", "Invalid credentials", null);


        $query = "SELECT api_key, salt, password FROM Users Where email = :email";
        $stm = $this->con->prepare($query);
        $stm->execute([':email' => $email]);

        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $message = "";
        $err = false;
        if (count($result) < 1) {
            $message = "User Not Found";
            $err = true;
        }

        $result = $result[0];
        $salt = $result['salt'];
        $cmp = hash("sha256", $password . $salt);

        if ($result['password'] !== $cmp) {
            $message = "Invalid Credentials";
            $err = true;
        }

        if ($err)
            return $this->response("HTTP/1.1 400 Bad Request", "Login", "error", $message, null);

        return $this->response("HTTP/1.1 200 OK", "Login", "success", "Successfully Logged in", $result['api_key']);
    }


    private function sign_up($data)
    {
        $id = $data['id'];
        $name = $data["name"];
        $surname = $data["surname"];
        $dob = $data['date_of_birth'];
        $email = $data["email"];
        $password = $data["password"];

        $valid = true;
        $message = "Errors:\n";

        $empty = empty($id) || empty($name) || empty($surname) || empty($dob) || empty($email) || empty($password);
        $email_check = preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email);
        $pass_check = preg_match('/^((?=.*\W)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])).{8,}$/', $password);

        if ($empty || ~$email_check || !$pass_check) {
            $message .= "Missing/Invalid Credentials\n";
            $valid = false;
        }

        $statement = $this->con->prepare("SELECT * FROM Users WHERE email= :email");
        $statement->execute([":email" => $email]);
        $query = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($query) > 0) {
            $message .= "Email Already Exists\n";
            $valid = false;
        }

        if (!$valid)
            return $this->response("HTTP/1.1 400 Bad Request", "SignUp", "error", $message, null);

        $api_key = $this->addUser($data);
        return $this->response("HTTP/1.1 200 OK", "SignUp", "success", "User successfully added", $api_key);
    }



    private function getIncCategory($api_key)
    {
        
        $query = "SELECT category_name, category_budget FROM Income_Category";
        $stm = $this->con->prepare($query);
        $stm->execute();

        $result = $stm->fetchAll(); //  ??is this an array

        return $this->response("HTTP/1.1 200 OK", "GetIncCategory", "success", null, $result);
    }

    private function getExpCategory($api_key)
    {
        $query = "SELECT category_name, category_budget FROM Expense_Category";
        $stm = $this->con->prepare($query);
        $stm->execute();

        $result = $stm->fetchAll(); //  ??is this an array

        return $this->response("HTTP/1.1 200 OK", "GetIncCategory", "success", null, $result);
    }

    private function getPoints($api_key)
    {
    }

    private function getTransactions($api_key, $data)
    {
    }

    private function getUserPoints($api_key)
    {
    }


    // Adders


    private function addCategory($api_key, $data)
    {
    }

    private function addTransaction($api_key, $data)
    {
    }

    private function addUserPoints($api_key, $points)
    {
    }

    private function addUser($data)
    {
        $spice = bin2hex(random_bytes(8));
        $season = $data['password'] . $spice;
        $cook = hash('sha256', $season);

        $api_key = bin2hex(random_bytes(32));

        $insert = "INSERT INTO Users (id,name,surname,D.O.B, email,password,salt,api_key) VALUES(?,?,?,?,?,?,?,?)";
        $stm = $this->con->prepare($insert);
        $stm->execute([$data['id'], $data['name'], $data['surname'], $data['D.O.B'], $data['email'], $cook, $spice, $api_key]);

        return $api_key;
    }

    // Removers 

    private function removeCategory($api_key, $data)
    {
    }

    private function removeTransaction($api_key, $transaction_id)
    {
    }

    private function removeUserPoints($api_key, $point_id)
    {
    }


    //Updaters 

    //pending...




}