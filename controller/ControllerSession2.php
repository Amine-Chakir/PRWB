<?php
require_once 'model/User.php';
require_once 'model/Tricount.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once 'model/Participation.php';

class ControllerSession2 extends Controller
{

    public function index(): void
    {
        $user = $this->get_user_or_redirect();
        $users = User::get_userse();
        $tricounts="";
        $notricount="";
        if($user->role=="admin")
        {
            if (isset($_GET["param1"]) && is_numeric($_GET["param1"]))
            {
                $idUser = $_GET["param1"];
                $user=User::get_member_id($idUser);
                if ($user!=false)
                {
                    $users = User::get_userse();
                    $tricounts = Tricount::get_tricounts_by_mail2($user->mail);
                    $notricount = Tricount::get_NotParticipTricounts_by_mail($user->mail);
                    (new View("Session2"))->show(["users"=>$users,"participatedTricounts"=>$tricounts,"notParticipatedTricount"=>$notricount]);

                }
                else
                    (new View("Session2"))->show(["users"=>$users,"participatedTricounts"=>$tricounts,"notParticipatedTricount"=>$notricount]);
            }
            else
            {
                if(isset($_POST["users"]) && is_numeric($_POST["users"]))
            {
                $idUser = $_POST["users"];
                $this->redirect("Session2","index",$idUser);

            }
            else
            {
                (new View("Session2"))->show(["users"=>$users,"participatedTricounts"=>$tricounts,"notParticipatedTricount"=>$notricount]);
            }
            }


        }
        else
            $this->redirect("main","logout");
    }

    public function res():void
    {
        if (isset($_GET["param1"]) && is_numeric($_GET["param1"]))
        {
            $idUser = $_GET["param1"];
            $user=User::get_member_id($idUser);
            if ($user!=false)
            {
                $users = User::get_userse();
                $tricounts = Tricount::get_tricounts_by_mail2($user->mail);
                $notricount = Tricount::get_NotParticipTricounts_by_mail($user->mail);
                (new View("Session2"))->show(["users"=>$users,"participatedTricounts"=>$tricounts,"notParticipatedTricount"=>$notricount]);

            }
            else
                $this->redirect("Session2","index");
        }
        else
        {
            $this->redirect("Session2","index");

        }
    }


}