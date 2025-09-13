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

        if(!$this->checkApiKey($api_key))
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
    }

    private function sign_up($data)
    {
    }

    private function getIncCategory($api_key)
    {
    }

    private function getExpCategory($api_key)
    {
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