<?php
session_start();
if(isset($_POST['upd'])&& isset($_POST['id']))
Assignment::assignment_update();
else if(isset($_POST['a_name']))
Assignment::create_assignment();
else
header("Location:Reviewer.php");


class Assignment{

    public static function create_assignment()
    {
        require_once('connect.php');
        $a_name=$_POST['a_name'];
        unset($_POST['a_name']);
        
        $stt=$conn->prepare('INSERT INTO Assignment (NAME) VALUES (?)');//enters the name of the assignment in database
        $stt->bind_param('s',$a_name);
        $stt->execute();
        
        $n=($conn->query('SELECT * FROM StudentData'))->num_rows;

        for($i=1;$i<=$n;$i++)
        {
            $col=$i."_stat";
            $v="Pending";
            $st=$conn->prepare("UPDATE Assignment SET $col=? WHERE NAME=?");//enters the status of each column corresponding to each student
            $st->bind_param('ss',$v,$a_name);
            $st->execute();
        }
        
        $_SESSION['ACreate']=1;
        header("Location:RPage.php");
    }

    public function assignment_update()
    {
        require_once('connect.php');
        $v1=$_POST['id'];
        $v2=$_POST['upd'];
        unset($_POST['id']);
        unset($_POST['upd']);

        $row_num=substr($v1,0,strpos($v1,'_'));
        $col_num=substr($v1,strpos($v1,'_')+1);

        $res=$conn->query('SELECT * FROM Assignment');

        $i=0;
        while($arr=$res->fetch_array(MYSQLI_NUM))
        {
            if($i==$row_num)
            break;
            $i++;
        }

        $col_name=$col_num."_stat";
        $stt=$conn->prepare("UPDATE Assignment SET $col_name=? WHERE NAME=?");
        $stt->bind_param('ss',$v2,$arr[0]);
        $stt->execute();//changes made in the database
    }
}