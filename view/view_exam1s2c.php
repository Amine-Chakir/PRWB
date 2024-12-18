<!DOCTYPE html>
<html lang="en">

<head>
    <title>Session1</title>
    <base href="<?= $web_root ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="lib/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<script>

    let div,div1,idTricount, operations,operation;

    async function show()
    {
        const data = await $.post("exam1s2c/service/",{idTricount:idTricount.val()});
        if (data==="false")
        div.html("no expenses");
        else
        {
             operations =await $.getJSON("Exam1s2c/get_operations_service/"+ idTricount.val());
         div.html("");
         let html ="<h5>Expenses initiated by this user : </h5>"
            html+="<br>"
            html+= "<ul>"
            for (let m of operations) {
                html+="<li>";
                html+="<input type='checkbox' value='"+m.id+"'>";
                html+=m.title;
                html+=" - ";
                html+=m.amount;
                html+="</li>";
            }
            html+="</ul>";
            html+="<br>";
            html+="<button type='button' onclick='inflation()'>Inflation</button></div>";
            div.html(html);
        }

    }
    async function inflation()
    {
        const checkboxes =$("input[type='checkbox']:checked");
        for (let c of checkboxes)
        {
            operation= $(c).val();
            change();
        }
        show();
    }

    async function change()
    {
        const res =await $.post("Exam1s2c/change_service/",{op:operation});
    }


    $(function () {
       div = $("#opérations");
       idTricount=$("#listeTricount");
    });

</script>
</head>
<body>
<div class="main">
    <div>
        <h5>Select a user : </h5>
        <form action="Exam1s2c/show" method="POST">
            <select name="user">
                <option value="default">--Select user--</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?=$user["id"]?>"<?php if (isset($_GET["param1"])) if ($user["id"] == $_GET["param1"] ) echo "selected"; ?>><?= $user["full_name"]?></option>
                <?php endforeach;?>
            </select>
            <input type="submit" value="Search tricounts">
        </form>
    </div>
    <?php if (isset($_GET["param1"])):?>
    <div>
        <?php if ($tricounts!=false):?>
        <h5>Select a tricount : </h5>
        <select onchange="show()" id="listeTricount" name="tricount">
            <option value="default">--Select tricount--</option>
            <?php foreach ($tricounts as $tricount): ?>
                <option value="<?=$tricount->id?>"><?= $tricount->title?></option>
            <?php endforeach;?>
        </select>
        <?php else:?>
        <p>ya pas de tricount pour ce user</p>
        <?php endif;?>
    </div>
    <?php endif;?>
    <div id="opérations">
</div>

</body>