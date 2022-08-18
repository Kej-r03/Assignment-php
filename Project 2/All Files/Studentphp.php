<?php
session_start();

if(isset($_POST['NSuser']) && isset($_POST['NSpass']) && isset($_POST['NSbranch']) && isset($_POST['NSyr']))
Student::create_student();
else if(isset($_POST['Suser']) && isset($_POST['Spass']))
Student::student_login();
else
header("Location:Student.php");



class Student{

    public $id;public $name;public $password;public $branch;public $yr;

    function __construct($arr)
    {
        $this->id=$arr[0];
        $this->name=$arr[1];
        $this->password=$arr[2];
        $this->branch=$arr[3];
        $this->yr=$arr[4];
    }

    public static function create_student()//Id autoincrement BUG remains
    {
        require_once('connect.php');
        
        $Nuser=$_POST['NSuser'];
        $Npass=$_POST['NSpass'];
        $Nbranch=$_POST['NSbranch'];
        $Nyr=$_POST['NSyr'];
        unset($_POST['NSuser']);
        unset($_POST['NSpass']);
        unset($_POST['NSbranch']);
        unset($_POST['NSyr']);
        $stt=$conn->prepare("INSERT INTO StudentData (NAME,PASSWORD,BRANCH,YEAR) VALUES (?,?,?,?)");
        $stt->bind_param('sssi',$Nuser,$Npass,$Nbranch,$Nyr);
        $stt->execute();//fills info into Student table

        
        $n=($conn->query('SELECT * FROM StudentData'))->num_rows;
        $i_stat=$n."_stat";
        $stt=$conn->query("ALTER TABLE Assignment ADD $i_stat varchar(255)");//adds a new column heading corresponding to the new user
        
        $res=$conn->query('SELECT * FROM Assignment');
        $i=0;       
        while($arr=$res->fetch_array(MYSQLI_NUM))//fills assignment status data into Assignment table
        {
            $assignment_stat=$_POST[$i];
            unset($_POST[$i++]);

            $stt=$conn->prepare("UPDATE Assignment SET $i_stat=? WHERE NAME=?");
            $stt->bind_param('ss',$assignment_stat,$arr[0]);
            $stt->execute();
        }


        $_SESSION['SReg']=1;
        header("Location:Student.php");
    }
    
    public static function student_login()
    {
        require_once('connect.php');
        $username=$_POST['Suser'];
        $password=$_POST['Spass'];
        unset($_POST['Suser']);
        unset($_POST['pass']);
        
        $result=$conn->query('SELECT * FROM StudentData');
        
        $obj=Student::retrieve_obj($username,$password,$result);

        if(!is_null($obj))
        {
           $_SESSION['Sarr']=array($obj->id,$obj->name,$obj->password,$obj->branch,$obj->yr);;

           setcookie('user_id',$_COOKIE['PHPSESSID'],time()+(86400*30),"/");
        
           $identity=$obj->id."_".$obj->yr;
           $st=$conn->prepare('INSERT INTO Per_Sessions VALUES (?,?)');
           $st->bind_param('ss',$identity,$_COOKIE['PHPSESSID']);
           $st->execute();

           header("Location: SPage.php");
        }
        else
        {
            $_SESSION['errSCred']=1;
            header("Location:Student.php");
        }
    }

    public function assignment_update()
    {

    }

    public static function retrieve_obj($username,$password,$result)
    {
        $flag=0;
        
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
            $obj=new Student($array);
            return $obj;
        }
        else
        return null;

    }
}