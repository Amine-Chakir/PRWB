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

    <style>
        .button-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
        }
    </style>
    <script>
        let idTricount,idUser;
        function enbale()
        {
            document.getElementById("btnAdd").disabled=false;
        }
        async function add()
        {
            const idT = idTricount.val();
            const idU = idUser.val();
            const data = await $.post("Session1/add_service/",{idTricount1:idT,idUs:idU});
            if (data=== "true")
            {
                var selectElement = document.getElementById("listeNotParticipeTricount");
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                selectElement.remove(selectedOption.index);
                const title = await $.post("Session1/check/",{idTricount2:idT});
                let newOption = new Option(title,title);
                list.append(newOption,undefined);

            }
        }
        $(function () {
            idTricount = $("#listeNotParticipeTricount");
            idUser = $("#listeUsers");
            list = $("#listeParticipeTricount");
        });
    </script>
</head>

<body>
<nav class="navbar  fixed-top  navbar-expand-lg" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="btn btn-sm btn-outline-danger" type="button" href="user">Back</a>
        <span class="navbar-text"><b>Session 1</b></span>
    </div>
</nav>
<div class="pt-5 pb-3"></div>
<div class="main pb-2">
    <form action="Session1/Show" method="post">
        <div class="row">
            <div class="col-9">
                <select  id="listeUsers" name="users" class="form-select">
                    <option value="default">-- Select a User --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?=$user["id"]?>"<?php if (isset($_GET["param1"])) if ($user["id"] == $_GET["param1"] ) echo "selected"; ?>><?= $user["full_name"]?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-3">
                <button class="btn btn-outline-secondary" type="submit">Show</button>
            </div>
        </div>
        <div class="form-label mt-2">Participates in these tricounts</div>
        <select style="width: 15%"  id="listeParticipeTricount" name="ParticipeTricount" size=5 class="form-select">
            <?php foreach ($ParticipeTricount as $Tricount): ?>
                <option value="<?=$Tricount["id"]?>"><?= $Tricount["title"]?></option>
            <?php endforeach;?>
        </select>
        <div style="height: auto" class="col m-2 p-0 button-container">
            <button onclick="add()" id="btnAdd" style="height: 50px; width: 30px " class="btn btn-outline-secondary" type="button" disabled>
                <i style="height: 50%; width: 50%" class="fa-solid fa-arrow-up"></i>
            </button>
        </div>
        <div class="form-label mt-2">Does not participate in these tricounts</div>
        <select style="width: 15%" onchange="enbale()" id="listeNotParticipeTricount" name="NotParticipeTricount" size=5 class="form-select">
            <?php foreach ($NotParticipeTricount as $Tricount1): ?>
                <option value="<?=$Tricount1->id?>"><?= $Tricount1->title?></option>
            <?php endforeach;?>
        </select>
    </form>
</div>

</body>

</html>
