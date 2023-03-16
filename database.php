<?php
session_start();
//this is THE function class 
//and this is a github edit
class functions
{
//all of theese public variables are needed for the constructor
   public $host;
   public $db;
   public $user;
   public $pass;
   public $charset;
   public $pdo;
//and here it is
public function __construct()
{
    //usually when using something from a class you use the given name like $func but if it's in the same file you need to call it $this
    //so you use the arrow -> to pull a variable from '$this' file get it? $this->variable. 
    //oh and no need for the $ on the variable name it is already on the $this
    $this->host="127.0.0.1";
    $this->db="skeleton_five";
    $this->user="root";
    $this->pass="";
    $this->charset="utf8mb4";

    try {
        //but you do need to use $this-> everytime you need to use a constructed variable
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES   => false,];
        $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}






//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+

    public function login(string $cred_one, string $cred_two)
    {
        //like over  here where you pull the pdo from the $this
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email_adress = :email_adress_form");
        $statement->bindParam(":email_adress_form", $cred_one);
        // $statement->bindParam(":password_form", $pass);
        $statement->execute();
        $result = $statement->fetch();

        if ($result == TRUE) {
            if(password_verify($cred_two, $result['password'])){

                echo "you passed the login stage but the header failled to fire";
                print_r($result);

                //creating a sitewide session that contains all nececeary info
                $_SESSION["id"] = $result['user_id'];
                $_SESSION["name"] = $result['first_name'];
                $_SESSION["mailelectric"] = $result['email_adress'];
                $_SESSION["wordofpassige"] = $cred_two;
                $_SESSION["aftername"] = $result['last_name'];
                $_SESSION["birthday"] = $result['date_of_birth'];
                header('location: index2.php');
            } else {
                echo "HAHAHA you did the password wrong!";
            }
        } else {
            echo "something went wrong";
        }
    }

//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+

    public function dbActivate(string $query, array $placeholders)
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($placeholders);
    }

//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+

    public function hash(string $string)
    {
        $hashed = password_hash($string, PASSWORD_DEFAULT) ;
        return $hashed;
    }

//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+

    public function detectReplica(string $email)
    {
        $statement = $this->pdo->query("SELECT email_adress FROM users WHERE email_adress='$email'");
        $vauge = $statement->rowCount();

        if ($vauge > 0) {
        return 1;
        } else {
        return 0;
        }
    }

//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+

    public function identifyFake(string $E_mail_adress)
    {
        $pattern = "/.+\@.+\..+/i";
        
        if (preg_match($pattern, $E_mail_adress)) {
        return 1;
        } else {
        return 0;
        }
                                                 
    }

//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+

//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+

//+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+



//DOWN HERE IS SCRAP THAT HAS BEEN REPLACED WITH BETTER SMALLER AND SAFER CODE
//SO KNOW THAT WHEN YOU USE THE STUFF DOWN HERE THAT THERE IS A BETTER ALTERNATIVE UP THERE ^


//SCRAP SAMPLE 01
//THIS USED TO BE THE PRIMARY INSERT METHOD UNTILL IT WAS CLASSED OUT
//DOWN HERE YOU CAN SEE THE LINE THAT WAS USED TO CALL UPHON THIS METHOD BEFORE IT SHUT DOWN
// $func->insert($_POST['first_name'], $_POST['last_name'], $_POST['email_adress'], $_POST['password'], $_POST['date_of_birth']);
public function insert($cred_1, $cred_2, $cred_3, $cred_4, $cred_5)
{
    $PASS = password_hash($cred_4, PASSWORD_DEFAULT) ;
    $statement = $this->pdo->prepare("INSERT INTO users
    (first_name, last_name, email_adress, password, date_of_birth)
    VALUES (:first_name_form, :last_name_form, :email_adress_form, :password_form, :date_of_birth_form)"
    );
    $statement->bindParam(":first_name_form", $cred_1);
    $statement->bindParam(":last_name_form", $cred_2);
    $statement->bindParam(":email_adress_form", $cred_3);
    $statement->bindParam(":password_form", $PASS);
    $statement->bindParam(":date_of_birth_form", $cred_5);
    $statement->execute();
}
//SCRAP SAMPLE 02
//THIS WAS HOW INFORMATION USED TO BE CHAINGED NUT NOW IT SITS HERE COLLECTING DUST
//THIS WAS HOW THE METHOD USED TO BE ACTIVATED
//  $func->alter($_POST['first_name'], $_POST['last_name'], $_POST['email_adress'], $_POST['password'], $_POST['date_of_birth'], $_SESSION["id"]);
public function alter($cred_1, $cred_2, $cred_3, $cred_4, $cred_5, $cred_6)
    {

    $pass = password_hash($cred_4, PASSWORD_DEFAULT) ;
    $statement = $this->pdo->prepare(
    "UPDATE users SET 
    first_name=:first_name_form, 
    last_name=:last_name_form, 
    email_adress=:email_adress_form, 
    password=:password_form, 
    date_of_birth=:date_of_birth_form 
    WHERE user_id=:id"
    );
    $statement->bindParam(":first_name_form", $cred_1);
    $statement->bindParam(":last_name_form", $cred_2);
    $statement->bindParam(":email_adress_form", $cred_3);
    $statement->bindParam(":password_form", $pass);
    $statement->bindParam(":date_of_birth_form", $cred_5);
    $statement->bindParam(":id", $cred_6);
    $statement->execute();

    session_destroy();
    header('location: index.php');

    }

}

//SCRAP SAMPLE 03
//THIS IS A WAY TO ADD A SEARCH BAR INTO ANY PAGE AJASONED TO THE 'SITE'

// </br>
// <bold>and here is a search bar</bold>

// <form action = '$NAME_OF_PAGE' method="POST">
// <input type="text" placeholder="search...." name = 'search'></input>
// <input type = 'submit' value = "SEARCH">
// </form>
// </br>

//AND YOU NEED SOME PHP OF COURSE

// elseif (isset($_POST['search'])){
//     $_SESSION["search"] = $_POST['search'];
//     header('location: index4.php');
// }


?>
