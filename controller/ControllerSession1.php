<?php
require_once 'model/User.php';
require_once 'model/Tricount.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once 'model/Participation.php';



class ControllerSession1 extends Controller
{

    public function index(): void
    {
        $user = $this->get_user_or_redirect();
        $users = User::get_userse();
        $ParticipeTricount = "";
        if($user->role == "admin")
        (new view("Session1"))->show(["users"=>$users,"ParticipeTricount"=>$ParticipeTricount]);
        else
            $this->redirect("main","logout");
    }

    public function show():void
    {
        $users = User::get_userse();
        $ParticipeTricount="";
        $NotParticipeTricount="";
        if (isset($_POST["users"]) && is_numeric($_POST["users"]))
        {
            $this->redirect("Session1","result",$_POST["users"]);
        }
        else
            (new view("Session1"))->show(["users"=>$users,"ParticipeTricount"=>$ParticipeTricount,"NotParticipeTricount"=>$NotParticipeTricount]);

    }

    public function result():void
    {
        $users = User::get_userse();
        $ParticipeTricount="";
       if (isset($_GET["param1"])&&is_numeric($_GET["param1"]))
       {
           $idUser =  $_GET["param1"];
           $user = User::get_member_id($idUser);
           if ($user!=false)
           {
               $ParticipeTricount = Tricount::get_tricounts_by_mail($user->mail);
               $NotParticipeTricount = Tricount::get_NotParticipTricounts_by_mail($user->mail);
               (new view("Session1"))->show(["users"=>$users,"ParticipeTricount"=>$ParticipeTricount,"NotParticipeTricount"=>$NotParticipeTricount]);

           }
           else
               (new view("Session1"))->show(["users"=>$users,"ParticipeTricount"=>$ParticipeTricount]);

       }
       else
        (new view("Session1"))->show(["users"=>$users,"ParticipeTricount"=>$ParticipeTricount]);
    }

    public function add_service():void
    {
        $part = new Participation($_POST["idTricount1"],$_POST["idUs"]);
        $part->persist();
        echo "true";
    }
    public function check():void
    {
        $id = $_POST["idTricount2"];
        $tricount = Tricount::get_tricount_by_id($id);
        echo "$tricount->title";
    }
}