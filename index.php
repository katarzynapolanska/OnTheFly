<?php
$host = "localhost";
$dbname = "vlucht";
$username = "root";
$password = "";
$conn = new PDO("mysql:host=".$host.";dbname=".$dbname.";",$username, $password);
?>
<!DOCTYPE html>
<html>
<head>
    <title>On The Fly</title>
    <link rel="stylesheet" style="text/css" href="style.css">
</head>

<body>
    <div id="content">
        <!--Tovoegen-->
        <div class="add">
            <h1>Vluchten toevoegen</h1>
            <form method="POST">
                <input type="text" name="vliegtuignr" placeholder="Vliegtuignummer"/><br/>
                <input type="text" name="type" placeholder="Typ"/><br/>
                <input type="text" name="maatschappij" placeholder="Vliegmaatschappij"/><br/>
                <input type="text" name="status" placeholder="Status"/><br/>
                <input type="date" name="vertrek" placeholder="Datum vertrek"/><br/>
                <input type="date" name="retour" placeholder="Datum retour"/><br/>
                <input type="text" name="bestemming" placeholder="Bestemming"/><br/>
                <input type="submit" name="btnAdd" value="Toevoegen"/><br/>
            </form>
        </div>
        <?php
            
            if(isset($_POST['btnAdd'])){
                $vliegtuignr = $_POST['vliegtuignr'];
                $type = $_POST['type'];
                $maatschappij = $_POST['maatschappij'];
                $status = $_POST['status'];
                $vertrek = $_POST['vertrek'];
                $retour = $_POST['retour'];
                $bestemming = $_POST['bestemming'];

                $query = ("INSERT INTO vluchten (vliegtuigNr, type, maatschappij, status, vertrek, retour, bestemming)
                            VALUES ($vliegtuignr, '$type', '$maatschappij', '$status', '$vertrek', '$retour', '$bestemming')");
                $stm=$conn->prepare($query);
                if($stm->execute()) {
                    echo "Vlucht toegevoegd!";
                } else
                    echo "Sorry";
            }
        ?>

 <!--Actieve vliegtuigen-->
 <div class="active">
            <form method="POST">
                <input type="submit" name="btnActive" value="Active vligtuigen">
            </form>
        
        <?php
            if(isset($_POST['btnActive'])){
                echo "Active vliegtuigen </br>
                <table><tr class='rijEen'>
                <th>Vlucht nummer</th>
                <th>Vliegtuig nummer</th>
                <th>Type</th>
                <th>Maatschappij</th>
                <th>Datum vertrek</th>
                <th>Datum retour</th>
                <th>Bestemming</th>
                <th>Status</th>
                </tr>";
                $query = ("SELECT * FROM vluchten WHERE status='active'");
                $stm = $conn->prepare($query);
                if($stm->execute()){
                    $result = $stm->FetchAll(PDO::FETCH_OBJ);
                    foreach($result as $active){
                        echo "<tr><td>".$active->vluchtNr."</td>".
                        "<td>".$active->vliegtuigNr."</a></td>".
                        "<td>".$active->type."</td>".
                        "<td>".$active->maatschappij."</td>".
                        "<td>".$active->vertrek."</td>".
                        "<td>".$active->retour."</td>".
                        "<td>".$active->bestemming."</td>".
                        "<td><a href='vUpdate.php?vluchtNr=".$active->vluchtNr."'>$active->status</a></td></tr>";
                    }
                }
            }
        ?>
        </table>
        </div>\ 


        <!--Planning-->
        <div class="planning">
            <!--<form method="post">
                <input type="submit" name="btnPlanning" value="Planning weegeven"/>
            </form>
            <h1>Planning</h1>
        </div>-->
        <?php
            //if(isset($_POST['btnPlanning'])){
                echo "<table><tr class='rijEen'>
                <th>Vlucht nummer</th>
                <th>Vliegtuig nummer</th>
                <th>Type</th>
                <th>Maatschappij</th>
                <th>Datum vertrek</th>
                <th>Datum retour</th>
                <th>Bestemming</th>
                <th>Status</th>
                </tr>";
                $query = ("SELECT * FROM vluchten");
                $stm = $conn->prepare($query);
                if($stm->execute()){
                    $result = $stm->FetchAll(PDO::FETCH_OBJ);
                    foreach($result as $key){
                        echo "<tr><td><a href='vUpdate.php?vluchtNr=".$key->vluchtNr."'>$key->vluchtNr</a></td>".
                        "<td><a href='vUpdate.php?vluchtNr=".$key->vluchtNr."'>$key->vliegtuigNr</a></td>".
                        "<td>".$key->type."</td>".
                        "<td>".$key->maatschappij."</td>".
                        "<td>".$key->vertrek."</td>".
                        "<td>".$key->retour."</td>".
                        "<td>".$key->bestemming."</td>".
                        "<td>".$key->status."</td></tr>";
                    }
                }
            //}
        ?>
       
        <!--Selecteren per dag-->
        <div class="perDag">
            <h2>Overzicht per dag</h2>
            <P>Kies datum vertrek of retour</p>
            <form method="post">
                <input type="date" name="date"/></br>
                <input type="submit" name="btnDate" value="Select"/>
            </form>
        </div>
        <?php
            if(isset($_POST['btnDate'])){
                $date=$_POST['date'];
                echo "Vluchten op ".$date.
                "<table><tr class='rijEen'>
                <th>Vlucht nummer</th>
                <th>Vliegtuig nummer</th>
                <th>Type</th>
                <th>Maatschappij</th>
                <th>Datum vertrek</th>
                <th>Datum retour</th>
                <th>Bestemming</th>
                <th>Status</th>
                </tr>";

                $query=("SELECT * FROM vluchten WHERE vertrek='$date' OR retour='$date'");
                $stm=$conn->prepare($query);
                if($stm->execute()){
                    $result=$stm->FetchAll(PDO::FETCH_OBJ);
                    foreach($result as $dag){
                        echo "<tr><td>".$dag->vluchtNr."</td>".
                        "<td>".$dag->vliegtuigNr."</a></td>".
                        "<td>".$dag->type."</td>".
                        "<td>".$dag->maatschappij."</td>".
                        "<td>".$dag->vertrek."</td>".
                        "<td>".$dag->retour."</td>".
                        "<td>".$dag->bestemming."</td>".
                        "<td><td>".$dag->status."</td></tr>";
                    }
                }
            }
        ?>
        
    </div>
<body>
</html>