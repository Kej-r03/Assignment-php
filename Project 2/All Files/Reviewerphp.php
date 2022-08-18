<?php
session_start();

if(isset($_POST['NRuser']) && isset($_POST['NRpass']) && isset($_POST['NRbranch']) && isset($_POST['NRyr']))
Reviewer::create_reviewer();
else if(isset($_POST['Ruser']) && isset($_POST['Rpass']))
Reviewer::reviewer_login();
else
header("Location:Reviewer.php");



class Reviewer{

    public $id;public $name;public $password;public $branch;public $yr;

    function __construct($arr)//constructor to fill object values
    {
        $this->id=$arr[0];
        $this->name=$arr[1];
        $this->password=$arr[2];
        $this->branch=$arr[3];
        $this->yr=$arr[4];
    }

    public static function create_reviewer()//Id autoincrement BUG remains
    {
        require_once('connect.php');
        $Nuser=$_POST['NRuser'];
        $Npass=$_POST['NRpass'];
        $Nbranch=$_POST['NRbranch'];
        $Nyr=$_POST['NRyr'];
        unset($_POST['NRuser']);
        unset($_POST['NRpass']);
        unset($_POST['NRbranch']);
        unset($_POST['NRyr']);
        
        $stt=$conn->prepare("INSERT INTO Reviewer (NAME,PASSWORD,BRANCH,YEAR) VALUES (?,?,?,?)");
        $stt->bind_param('sssi',$Nuser,$Npass,$Nbranch,$Nyr);
        $stt->execute();
        
        $_SESSION['RReg']=1;
        header("Location:Reviewer.php");        
    }
    
    public static function reviewer_login()
    {
        require_once('connect.php');
        $username=$_POST['Ruser'];
        $password=$_POST['Rpass'];
        unset($_POST['Ruser']);
        unset($_POST['Rpass']);
        $result=$conn->query('SELECT * FROM Reviewer');     
        
        $obj=Reviewer::retrieve_obj($username,$password,$result);
        
        if(!is_null($obj))//if user found, store cookie in browser, database and redirect to display page
        {
           $_SESSION['Rarr']=array($obj->id,$obj->name,$obj->password,$obj->branch,$obj->yr);;

           setcookie('user_id',$_COOKIE['PHPSESSID'],time()+(86400*30),"/");
        
           $identity=$obj->id."_".$obj->yr;
           $st=$conn->prepare('INSERT INTO Per_Sessions VALUES (?,?)');
           $st->bind_param('ss',$identity,$_COOKIE['PHPSESSID']);
           $st->execute();

           header("Location: RPage.php");
        }
        else
        {
            $_SESSION['errRCred']=1;
            header("Location:Reviewer.php");
        }
    }

    public static function retrieve_obj($username,$password,$result)
    {
        $flag=0;
        // require_once('connect.php');
        // $result=$conn->query("SELECT * FROM Reviewer");?????Why not working??
        
        while($array=$result->fetch_array(MYSQLI_NUM))
        {
            if($username==$array[1] && $password==$array[2])
            {
                $flag=1;
                break;
            }
        }

        if($flag==1)
        {
            $obj=new Reviewer($array);
            return $obj;
        }
        else
        return null;

    }
}