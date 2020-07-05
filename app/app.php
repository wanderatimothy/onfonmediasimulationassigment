<?php

require_once "DB.php";

class Lover
{
    public $code = 5001;

    private $keywords = array("start", "details", 'myself', 'next', 'yes', 'no', 'activate');

    private $tool;

    public $phone_number;

    public function __construct()
    {

        // connect to database
        $this->tool = new DB;
    }
    // return any custom message
    public function prompt(string $msg)
    {
        return $msg;
    }
    // check for the sms length
    public function validate($sms)
    {
        if (strlen($sms) <= 160) {
            return true;
        } else {
            // $message  = "The sms should not exceed 160 characters!";
            return false;
        }
    }
    //  extract infomation out of encoded sms
    public function explode(string $msg)
    {
        $row = array();
        $data = explode("#", $msg);
        for ($i = 0; $i < count($data); $i++) {
            $row[] = trim($data[$i], " ");
        }
        return $row;
    }

    public function extractKeyword(string $msg)
    {
        $chunk = ltrim($msg, " ");
        $words = explode(' ', $chunk);
        return strtolower($words[0]);
    }

    // innitialise sms Lover
    public function Initialise(string $msg)
    {
        $message = trim($msg, ' ');
        if (strtolower($message) == 'lover') {
            $reply = "
            Welcome to our dating service with more then 6000 potential dating partners!\n
            To Register SMS => start#name#province#town to 5001 e.g \n 
            start#mike#26#Male#Kampala#Kansanga 
            ";
            return $reply;
        } else {
            return false;
        }
    }

    // decode the start , details and match sms and set up the table


    public function decodeSms(string $sms)
    {
        if ($this->validate($sms)) {
            $row = $this->explode($sms);


            switch (strtolower($row[0])) {
                case 'start':
                    return $this->start($row);
                    break;
                case  'details':
                    return $this->details($row);
                    break;
                case 'match':
                    return $this->match($sms);
                    break;
                default:
                    return false;
            }
        } else {
            return $this->prompt("Try Again!");
        }
    }

    // next ,describe and prompts  will be handled

    public function processRequest(string $msg)
    {
        $key_word = $this->extractKeyword($msg);
        $chunk = ltrim($msg, $key_word);

        // All actions to be handled

        if ($this->validate($key_word)) {
            switch ($key_word) {
                case 'lover':
                    return $this->Initialise($msg);
                    break;
                case 'describe':
                    return  $this->describe(array('user_id' => trim($chunk, ' ')));
                    break;
                case 'next':
                    return $this->next();
                    break;
                case 'myself':
                    return   $this->description(array('desc' => $chunk, 'user_id' => $this->phone_number));
                    break;
                case 'yes':
                    return 0;
                case 'timeout':
                    return $this->timeout();
                    break;
                case 'no':
                    return 0;
                    break;
                case 'activate':
                    return $this->activate();;
                    break;
                default:
                    return $this->decodeSms($msg);
            }
        }
    }

    // database manipulation functions

    private function start($data)
    {
        $bindvalues = array(
            'phone' => $this->phone_number,
            'name' => $data[1],
            "age" => $data[2],
            "gender" => $data[3],
            "province" => $data[4],
            "town" => $data[5]

        );



        $this->__construct();

        $sql = "insert into system_users
        (user_id,user_name,user_gender,age,pronvince,town,last_active,account_status)
        values(:phone,:name,:gender,:age,:province,:town,NOW(),1);
        ";

        $exec = $this->tool->runQuery($sql, $bindvalues);
        if ($exec) {
            $message =
                '
        Thank You.\n
        SMS details#level of education#profession#marital status#religion#tribe to 5001.\n
        eg details#diploma#accountant#single#christian#Muganda
        ';
        } else {
            $message = "Your Phone number is already registered with  Lover";
        }

        return htmlspecialchars($message);
    }
    private function details($data)
    {
        $this->__construct();
        // Updating activity
        $this->updateLastActive(array("user_id" => $this->phone_number));

        $bindvalues = array(
            "edu" => $data[1],
            "profesion" => $data[2],
            "religion" => $data[3],
            "tribe" => $data[4],
            "user_id" => $this->phone_number
        );


        $sql = "
            insert into details(edu_level,profesion,religion,tribe,user_id)
            values(:edu,:profesion,:religion,:tribe,:user_id)
        ";
        $exec = $this->tool->runQuery($sql, $bindvalues);
        if ($exec) {
            $message = '
        This is the last stage of registration sms a brief description of yourself to 5001. \n
        starting with the word MYSELF. eg MYSELF chocolate, lovely , sexy etc
        ';
        } else {
            $message = $this->tool->Errors;
        }

        return $message;
    }

    // Add description to your profile

    private function description($data)
    {
        $this->__construct();
        // Updating activity
        $this->updateLastActive(array("user_id" => $this->phone_number));
        $sql = "update system_users set description = :desc where user_id = :user_id";
        $exec = $this->tool->runQuery($sql, $data);

        if ($exec) {
            $message  = '
               You are now registered Enjoy yourself . To search for a Lover , \n
              SMS Match#age#town to 5001 e.g Match#23-25#Kampala ';
        } else {
            $message = $this->tool->Errors;
        }
        return $message;
    }

    private function match($msg)
    {
        $this->__construct();
        // Updating activity
        $this->updateLastActive(array("user_id" => $this->phone_number));
        $data = $this->explode($msg);
        $ageRange = $data[1];
        $town = $data[2];
        $limits = explode('-', $ageRange);
        $gender = ($this->gender() == 'male') ? 'female' : 'male';


        // Db search and manipulation

        /**
         * 1 do search for  the two matching wild cards  if there exits ,
         * 2 do search for individual wild cards
         * create a  list of description on the search hieracy
         * */

        $sql = "select su.user_id,user_name,user_gender,age,pronvince,town,description,edu_level,profesion,religion,tribe from system_users su inner join details dt on su.user_id = dt.user_id where (su.pronvince = :town) and( su.age between :age1 and :age2 ) and (su.user_gender = :gender )   ";

        $bindvalues = array(
            'town' => $town,
            'age1' => $limits[0],
            'age2' => $limits[1],
            'gender' => $gender
        );


        $exec = $this->tool->runQuery($sql, $bindvalues);
        if ($exec) {
            $results = $this->tool->results->fetchAll(PDO::FETCH_ASSOC);

            $this->recordUserMessage($msg);




            if (!empty($results)) {
                $num = count($results);
                $msg = "";
                $count = 1;
                foreach ($results as $result) {
                    if ($count == $num) {
                        break;
                    }
                    $count++;

                    $msg .= ucfirst($result['user_name']) . ",aged " . $result['age'] . "," . $result['user_id'] . ".";
                }
                if ($num > 3) {
                    if ($gender == 'female') {
                        $last = 'ladies';
                    } else {
                        $last = 'gental men';
                    }
                    $msg .= "Send NEXT to 5001 to recive the remaining " . ($num - 3) . " " . $last . ".";
                }
                $message = $msg;
            } else {
                $message = '
                No one currently available matching you !
                SMS Match#age#town eg Match#23-25#kampala';
            }
        } else {
            $message = $this->tool->Errors;
        }
        return $message;
    }
    private function next()
    {
        $this->__construct();

        $sql = "select message from user_messages where user_id = :user_id  having max(created_at)";
        $exec = $this->tool->runQuery($sql, array('user_id' => $this->phone_number));
        if ($exec) {
            $results = $this->tool->results->fetchAll(PDO::FETCH_ASSOC);
            $msg = $results[0]['message'];
            // match get all
            return  $this->getMatches($msg);
        } else {
            $message = $this->tool->Errors;
        }
        return $message;
    }

    private function activate()
    {
        $this->__construct();
        $sql = "update system_users set account_status = 1 where user_id = :user_id ";
        $exec = $this->tool->runQuery($sql, array('user_id' => $this->phone_number));
        $message = "
          You are now registered Enjoy yourself . To search for a Lover , \n
              SMS Match#age#town to 5001 e.g Match#23-25#Kampala 
        ";
        if ($exec) {
            return $message;
        } else {
            return  $this->tool->Errors;
        }
    }
    private function confirm(bool $action)
    {
    }

    private function describe($data)
    {
        $this->__construct();
        // Updating activity
        $this->updateLastActive(array("user_id" => $this->phone_number));
        $sql = "select description from system_users where user_id =:user_id ";
        $exec = $this->tool->runQuery($sql, $data);


        if ($exec) {
            $results =  $this->tool->results->fetchAll(PDO::FETCH_ASSOC);
            $this->hit($data);
            return (!empty($results[0]['description'])) ? trim($results[0]['description'], 'MYSELF') : 'The phone number is not registered with us please try again with a different number';
        } else {
            return "Please enter a correct phone number";
        }
    }

    public function timeout()
    {
        $this->__construct();
        $sql = "select count(user_name) as num from system_users where user_id  = :user_id";
        $exec = $this->tool->runQuery($sql, array('user_id' => $this->phone_number));
        if ($exec) {
            $results = $this->tool->results->fetchAll(PDO::FETCH_ASSOC);
            if ($results[0]['num'] == 1) {
                /***
                 * Run de-activation check
                 */
                // $last_active = new DateTime($this->lastActive());
                // $curr_date = new DateTime('now');

                // $diff =  $curr_date->diff($last_active);
                // if ($diff > 30) {

                // } else {
                // }


                /*

                 * Run run last match
                 * 
                 * Run interested clients
                 * */

                $sql = "select searched_by from hits where interest = :interest  ";
                $exec = $this->tool->runQuery($sql, array("interest" => $this->phone_number));
                if ($exec) {
                    $results = $this->tool->results->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($results)) {
                        // get the name; 
                        $message = 'Hi ' . ucfirst($this->getName(array("user_id" => $this->phone_number)));
                        for ($i = 0; $i < count($results); $i++) {
                            if ($i == 3) {
                                break;
                            }
                            $message .= ' ' . ucfirst($this->getName(array("user_id" => $results[$i]['searched_by']))) . ',' . $results[0]['searched_by'] . '.';
                        }
                        $message .= 'are interested in you SMS Describe 0777777888 to get more details.';
                    }
                } else {
                    $message = $this->tool->Errors;
                }
            } else {
                $message = "
        You were registered for dating with your initial details . <br/> Enjoy yourself. 
        To search for a lover , SMS Match#age#town to 5001 E.G Match#23-25#Kampala
        ";
            }
        } else {

            $message = "
        You were registered for dating with your initial details . <br/> Enjoy yourself. 
        To search for a lover , SMS Match#age#town to 5001 E.G Match#23-25#Kampala
        ";
        }
        return $message;
    }

    public function updateLastActive($data)
    {
        $this->__construct();
        $sql = "update system_users set last_active = NOW() where user_id = :user_id";
        return  $exec = $this->tool->runQuery($sql, $data);
    }


    public function verifyPhone()
    {
        $this->__construct();
        $sql = "select count(user_name) as num from system_users where user_id  = :user_id";
        $exec = $this->tool->runQuery($sql, array('user_id' => $this->phone_number));
        if ($exec) {
            $results =  $this->tool->results->fetchAll(PDO::FETCH_ASSOC);
            if ($results[0]['num'] == 1) {
                // return $results[0]['num'];
                return  true;
            } else {
                $message = "
                Welcome to our dating service with more then 6000 potential dating partners!\n
                To Register SMS => start#name#province#town to 5001 e.g \n 
                start#mike#26#Male#Kampala#Kansanga 
                ";
                return $this->prompt($message);
            }
        } else {
            return false;
        }
    }

    // get the user gender
    function gender()
    {
        $this->__construct();
        $sql = "select user_gender from system_users where user_id = :user_id";
        $exec = $this->tool->runQuery($sql, array('user_id' => $this->phone_number));
        if ($exec) {
            $results =  $this->tool->results->fetchAll(PDO::FETCH_ASSOC);
            return $results[0]['user_gender'];
        } else {
            return  $this->tool->Errors;
        }
    }

    private function recordUserMessage($msg)
    {
        $this->__construct();
        $bindvalues = array(
            'user_id' => $this->phone_number,
            'msg' => $msg
        );
        $sql = "insert into user_messages(user_id,message,created_at,last_updated)values(:user_id,:msg,NOW(),NOW())";
        $exec = $this->tool->runQuery($sql, $bindvalues);
        if ($exec) {
            return true;
        } else {
            return false;
        }
    }
    private function getMatches($msg)
    {
        $data = $this->explode($msg);
        $ageRange = $data[1];
        $town = $data[2];
        $limits = explode('-', $ageRange);
        $gender = ($this->gender() == 'male') ? 'female' : 'male';
        $sql = "select su.user_id,user_name,user_gender,age,pronvince,town,description,edu_level,profesion,religion,tribe from system_users su inner join details dt on su.user_id = dt.user_id where (su.pronvince = :town) and( su.age between :age1 and :age2 ) and (su.user_gender = :gender )   ";

        $bindvalues = array(
            'town' => $town,
            'age1' => $limits[0],
            'age2' => $limits[1],
            'gender' => $gender
        );


        $exec = $this->tool->runQuery($sql, $bindvalues);
        if ($exec) {
            return  $this->tool->results->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $this->tool->$msg;
        }
    }

    function lastActive()
    {
        $this->__construct();
        $sql = "select last_active from system_users where user_id = :user_id";

        $exec = $this->tool->runQuery($sql, array("user_id" => $this->phone_number));
        if ($exec) {
            $results =  $this->tool->results->fetchAll(PDO::FETCH_ASSOC);
            return $results[0]['last_active'];
        } else {
            return $this->tool->Errors;
        }
    }

    function hit($msg)
    {
        $this->__construct();
        $sql = "insert into hits(searched_by,interest,created_at) values (:user_id,:described,NOW())";
        $bindvalues = array("user_id" => $this->phone_number, "described" => $msg['user_id']);
        $exec = $this->tool->runQuery($sql, $bindvalues);
        if ($exec) {

            return true;
        } else {
            return   $this->tool->Errors;
        }
    }
    function getName($data)
    {
        $this->__construct();
        $sql = "select user_name from system_users where user_id = :user_id";
        $exec = $this->tool->runQuery($sql, $data);
        if ($exec) {
            $results =  $this->tool->results->fetchAll(PDO::FETCH_ASSOC);

            return $results[0]['user_name'];
        } else {
            return   $this->tool->Errors;
        }
    }
}
