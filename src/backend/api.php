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
        // require_once "config.php";
        // global $conn;
        // $this->con = $conn;
         $this->con = require __DIR__ . "/config.php";
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

       if (empty($obj) || !is_array($obj)) {
        $message = "Invalid Object";
        $err = true;
    }

        if (!isset($obj['type'])) {
            $message = "Missing Post Parameter";
            $err = true;
        }

        if (!is_array($obj) || !isset($obj['type'])) {
            $message = "Missing Post Parameter";
            $err = true;
        }

        $typeCheck = array_intersect($types, (array)($obj['type'] ?? []));
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

       $api_key = $obj['api_key'] ?? null;

//        if (!$api_key) {
//             return $this->response("HTTP/1.1 400 Bad Request", null, "error", "Missing API Key", null);
// }



        if (isset($obj['api_key']) && !$this->checkApiKey($api_key))
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
                $this->getPoints();
                break;

            case "GetTransactions":
                $this->getTransactions($api_key, $obj);
                break;

            case "GetUserPoints":
                $this->getUserPoints($api_key);
                break;

            case "AddCategory":
                $this->addCategory($obj);
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
        header($header);
        header("Content-Type: application/json");

        $returnField = "";
        $return = '';

        switch ($type) {
            case "Login":
            case "SignUp":
            case "GetIncCategory":
            case "GetExpCategory":
            case "GetPoints":
            case "GetTransactions":
            case "GetUserPoints":
                $returnField = "data";
                $return = $data;
                break;

            case "AddCategory":
            case "AddTransaction":
            case "AddUserPoints":
            case "RemoveCategory":
            case "RemoveTransactions":
            case "RemoveUserPoints":
                $returnField = "message";
                $return = $message;
                break;
        }

        if ($result == "success") {
            return json_encode([
                "status" => $result,
                "timestamp" => time(),
                $returnField => $return
            ]);
        } else {
            return json_encode([
                "status" => $result,
                "timestamp" => time(),
                "message" => $message
            ]);
        }
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

        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([":api_key" => $api_key]);

        $result = $stm->fetchAll();
        $id = $result['id'];

        $query = "SELECT * FROM Income_Category WHERE user_id=:id";
        $stm = $this->con->prepare($query);
        $stm->execute([":id" => $id]);

        $result = $stm->fetchAll(); //  ??is this an array

        return $this->response("HTTP/1.1 200 OK", "GetIncCategory", "success", null, $result);
    }

    private function getExpCategory($api_key)
    {
        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([":api_key" => $api_key]);

        $result = $stm->fetchAll();
        $id = $result['id'];

        $query = "SELECT * FROM Expense_Category WHERE user_id=:id";
        $stm = $this->con->prepare($query);
        $stm->execute([":id" => $id]);

        $result = $stm->fetchAll(); //  ??is this an array

        return $this->response("HTTP/1.1 200 OK", "GetIncCategory", "success", null, $result);
    }

    private function getPoints()
    {
        $query = "SELECT point_num, tier FROM POINTS";
        $stm = $this->con->prepare($query);
        $stm->execute();

        $result = $stm->fetchAll();
        return $this->response("HTTP/1.1 200 OK", "GetPoints", "success", null, $result);
    }

    private function getTransactions($api_key, $data)
    {
        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([":api_key" => $api_key]);

        $result = $stm->fetchAll();

        $where = "";
        $order = [];
        $sortStr = "";

        $parameters = [];
        $parameters[':id'] = $result['id'];

        if (isset($data['filter'])) {
            $filter = $data['filter'];
            if (isset($filter['category'])) {
                $where .= " AND category = :category";
                $parameters[':category'] = $filter['category'];
            }

            if (isset($filter['date'])) {
                // is the date a range

                if ($filter['date']['from'] === $filter['date']['to']) {
                    $where .= " AND date = :date";
                    $parameters[':date'] = $filter['date']['from'];
                } else {
                    $where .= " AND date BETWEEN :from AND :to";
                    $parameters[':from'] = $filter['date']['from'];
                    $parameters[':to'] = $filter['date']['to'];
                }
            }

            if (isset($filter['type'])) {
                $where .= " AND transaction_type = :type";
                $parameters[':type'] = $filter['type'];
            }
        }

        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if (isset($sort['category']))
                $order[] = "category";

            if (isset($sort['date']))
                $order[] = "date";

            if (isset($sort['type']))
                $order[] = "transaction_type";

            $sortStr = " Order By " . implode(',', $order);
        }

        $query = "SELECT * FROM Transactions WHERE id=:id" . $where . $sortStr;
        $stm = $this->con->prepare($query);
        $stm->execute($parameters);

        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->response("HTTP/1.1 200 OK", "getTransactions", "success", null, $result);
    }

    private function getUserPoints($api_key)
    {
        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([':api_key' => $api_key]);

        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->response("HTTP/1.1 200 OK", "getUserPoints", "success", null, $result);
    }


    // Adders


    private function addCategory($data)
    {
        $type = "";
        if ($data['category_type'] == 'income') {
            $type = "Income_Category";
        } else if ($data['category_type'] == "expense") {
            $type = "Expense_Category";
        } else
            return $this->response("HTTP/1.1 400 Bad Request", "addCategory", "error", "Unknown Category Type", null);


        $insert = "INSERT INTO " . $type . " (category_name, category_budget) VALUES(?,?)";
        $stm = $this->con->prepare($insert);
        $stm->execute($data['category_name'], $data['budget']);

        return $this->response("HTTP/1.1 200 OK", "addCategory", "success", "Category successfully added", null);
    }

    private function addTransaction($api_key, $data)
    {
        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([":api_key" => $api_key]);

        $result = $stm->fetchAll();
        $id = $result['id'];

        $type = "";
        if ($data['category_type'] == 'income') {
            $type = "Income_Category";
        } else if ($data['category_type'] == "expense") {
            $type = "Expense_Category";
        } else
            return $this->response("HTTP/1.1 400 Bad Request", "addCategory", "error", "Unknown Category Type", null);


        //calculate current budget
        $query = "SELECT current_budget FROM Transactions  WHERE date = SELECT MAX(date) FROM Transactions";
        $stm = $this->con->prepare($query);
        $stm->execute();

        $currentBudget = $stm->fetchAll();

        $currentBudget = $currentBudget - $data['amount'];

        $query = "INSERT INTO Transactions (id,transaction_type,category,transaction_amount,current_budget,date,description) 
                Values(?,?,?,?,?,?,?)";

        $stm = $this->con->prepare($query);
        $stm->execute([$id, $type, $data['category'], $data['amount'], $currentBudget, $data['date'], $data['description']]);

        return $this->response("HTTP/1.1 200 OK", "addTransaction", "success", "Transaction successfully added", null);


        // $check = "SELECT category_name FROM ".$type;
        // $stm = $this->con->prepare($check);
        // $stm->execute();

        // $result = $stm->fetchAll();

        // if(count($result) < 1)
        //     return $this->response("HTTP/1.1 200 OK")
    }

    private function addUserPoints($api_key, $points)
    {
        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([":api_key" => $api_key]);

        $result = $stm->fetchAll();
        $id = $result['id'];

        $query = "SELECT point_num FROM Points WHERE point_id = :pid";
        $stm = $this->con->prepare($query);
        $stm->execute([':pid' => $points]);

        $result = $stm->fetchAll();
        $point_num = $result['point_num'];

        $query = "SELECT total_points FROM User_Points WHERE user_id = :id";
        $stm = $this->con->prepare($query);
        $stm->execute([":id" => $id]);

        $result = $stm->fetchAll();
        $total = $result['total_points'];

        $query = "UPDATE User_Points SET total_points = :total WHERE user_id = :id";
        $stm = $this->con->prepare($query);
        $stm->execute([':total' => ($total + $point_num), ':id' => $id]);

        return $this->response("HTTP/1.1 200 OK", "addUserPoints", "success", "Point successfully added", null);
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
        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([":api_key" => $api_key]);

        $result = $stm->fetchAll();
        $id = $result['id'];

        $type = "";
        if ($data['category_type'] == 'income') {
            $type = "Income_Category";
        } else if ($data['category_type'] == "expense") {
            $type = "Expense_Category";
        } else
            return $this->response("HTTP/1.1 400 Bad Request", "addCategory", "error", "Unknown Category Type", null);



        $query = "DELETE FROM " . $type . " WHERE id=:category_id AND user_id =:id";
        $stm = $this->con->prepare($query);
        $stm->execute([":category_id" => $data['category_id'], ":id" => $id]);

        return $this->response("HTTP/1.1 200 OK", "removeCategory", "success", "Category Removed Successfully", null);

    }

    private function removeTransaction($api_key, $transaction_id)
    {
        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([":api_key" => $api_key]);

        $result = $stm->fetchAll();
        $id = $result['id'];

        $query = "DELETE FROM Transactions WHERE id=:id AND transaction_id=:tid";
        $stm = $this->con->prepare($query);
        $stm->execute([":id" => $id, ":tid" => $transaction_id]);

        return $this->response("HTTP/1.1 200 OK", "removeTransaction", "success", "Transaction Removed Successfully", null);

    }

    private function removeUserPoints($api_key, $point_id)
    {
        $query = "SELECT id FROM User WHERE api_key = :api_key";
        $stm = $this->con->prepare($query);
        $stm->execute([":api_key" => $api_key]);

        $result = $stm->fetchAll();
        $id = $result['id'];

        $query = "SELECT point_num FROM Points WHERE point_id = :pid";
        $stm = $this->con->prepare($query);
        $stm->execute([':pid' => $point_id]);

        $result = $stm->fetchAll();
        $point_num = $result['point_num'];

        $query = "SELECT total_points FROM User_Points WHERE user_id = :id";
        $stm = $this->con->prepare($query);
        $stm->execute([":id" => $id]);

        $result = $stm->fetchAll();
        $total = $result['total_points'];

        $query = "UPDATE User_Points SET total_points = :total WHERE user_id = :id";
        $stm = $this->con->prepare($query);
        $stm->execute([':total' => ($total - $point_num), ':id' => $id]);

        return $this->response("HTTP/1.1 200 OK", "removeUserPoints", "success", "Point successfully removed", null);
    }


    //Updaters 

    //pending...


}


$api = API::instance();

$request = $_SERVER["REQUEST_METHOD"];
$json = file_get_contents("php://input");
$obj = json_decode($json, true);

$check = $api->reqHandler($obj, $request);
echo $check;
