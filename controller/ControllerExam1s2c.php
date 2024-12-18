<?php
require_once 'model/User.php';
require_once 'model/Tricount.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once 'model/Participation.php';

class ControllerExam1s2c extends Controller
{

    public function index(): void
    {
        $tricounts="";
        $users=User::get_userse();
        (new View("exam1s2c"))->show(["tricounts"=>$tricounts,"users"=>$users]);
    }

    public function show(): void
    {
        $tricounts="";
        $users=User::get_userse();
        if(isset($_POST["user"] )&& is_numeric($_POST["user"]))
        {
            $this->redirect("Exam1s2c","res",$_POST["user"]);
        }

        (new View("exam1s2c"))->show(["tricounts"=>$tricounts,"users"=>$users]);
    }
    public function res(): void
    {

        $tricounts=false;
        $users=User::get_userse();
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"]))
        {
            $idUser = $_GET["param1"];
            $user = User::get_member_id($idUser);
            if ($user!=false)
            {
                $tricounts = Tricount::get_tricounts_by_mail2($user->mail);
                $users = User::get_userse();
                (new View("exam1s2c"))->show(["tricounts"=>$tricounts,"users"=>$users]);
            }
            else
            {
                (new View("exam1s2c"))->show(["tricounts"=>$tricounts,"users"=>$users]);
            }

        }
        else
        {
            (new View("exam1s2c"))->show(["tricounts"=>$tricounts,"users"=>$users]);
        }
    }

    public function service():void
    {
        $ok = Tricount::expenses_by_tricount($_POST["idTricount"]);
        if ($ok==false)
            echo "false";
        else
            echo "true";
    }
    public  function get_operations_service1(int $id):string
    {
        $operations = Tricount::get_operation_by_tricount1($id);
        $table = [];
        foreach ($operations as $operation) {
            $row = [];
            $row["title"]=$operation->title;
            $row["tricount"]=$operation->tricount;
            $row["amount"]=$operation->amount;
            $row["operation_date"]=$operation->operation_date;
            $row["initiator"]=$operation->initiator;
            $row["created_at"]=$operation->created_at;
            $row["id"]=$operation->id;
            $table[]=$row;
        }
        return json_encode($table);
    }

    public function get_operations_service():void
    {
        $operations = ControllerExam1s2c::get_operations_service1($_GET["param1"]);
       echo $operations;
    }

    public function change_service():void
    {
        $operation = Operation::get_id($_POST["op"]);
        $amount = $operation->amount;
        $operation->amount+=$amount*0.1;
        $operation->persist();
          echo $operation->amount;
    }

}