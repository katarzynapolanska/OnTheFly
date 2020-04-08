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
    <div id="content" class="container">
        <a href="index.php" class="back">Back</a>
        <div class="add">
            <?php
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

            $vlucht=$_GET['vluchtNr'];

            $query = "SELECT * FROM vluchten WHERE vluchtNr=$vlucht";
            $stm=$conn->prepare($query);
            if($stm->execute()){
                $result=$stm->fetchAll(PDO::FETCH_OBJ);
                foreach($result as $key){
                    echo "<tr><td>".$key->vluchtNr."</td>".
                    "<td>".$key->vliegtuigNr."</td>".
                    "<td>".$key->type."</td>".
                    "<td>".$key->maatschappij."</td>".
                    "<td>".$key->vertrek."</td>".
                    "<td>".$key->retour."</td>".
                    "<td>".$key->bestemming."</td>".
                    "<td>".$key->status."</td></tr>";
                }
            }
            ?>
        </div>
        <div class="form">
            <form method="POST">
                <label for="vluchtNr">Vlucht nummer</label></br>
                <input type="text" name="vluchtNr" placeholder="<?php echo $key->vluchtNr;?>" readonly/></br>
                <label for="vliegtuignr">Vliegtuig nummer</label></br>
                <textarea type="text" name="vliegtuignr"><?php echo $key->vliegtuigNr;?></textarea><br/>
                <label for="type">Type</label></br>
                <textarea type="text" name="type"><?php echo $key->type;?></textarea><br/>
                <label for="maatschappij">Maatschappij</label></br>
                <textarea type="text" name="maatschappij"><?php echo $key->maatschappij;?></textarea><br/>
                <label for="status">Status</label></br>
                <textarea type="text" name="status"><?php echo $key->status;?></textarea><br/>
                <label for="vertrek">Datum vertrek</label></br>
                <textarea type="text" name="vertrek"><?php echo $key->vertrek;?></textarea><br/>
                <label for="retour">Datum retour</label></br>
                <textarea type="text" name="retour"><?php echo $key->retour;?></textarea><br/>
                <label for="bestemming">Bestemming</label></br>
                <textarea type="text" name="bestemming"><?php echo $key->bestemming;?></textarea><br/>
                <input type="submit" name="btnUpdate" value="Update"/>
                <input type="submit" name="btnDelete" value="Delete"/></br>
            </form>
        </div>
        <?php
        //Update
            $vlucht=$_GET['vluchtNr'];
            if(isset($_POST['btnUpdate'])){
                $vliegtuignr = $_POST['vliegtuignr'];
                $type = $_POST['type'];
                $maatschappij = $_POST['maatschappij'];
                $status = $_POST['status'];
                $vertrek = $_POST['vertrek'];
                $retour = $_POST['retour'];
                $bestemming = $_POST['bestemming'];

                $query = ("UPDATE vluchten SET vliegtuigNr=$vliegtuignr, type='$type', maatschappij='$maatschappij', status='$status', vertrek='$vertrek', retour='$retour', bestemming='$bestemming' WHERE vluchtNr = $vlucht");
		        $stm = $conn->prepare($query);
		        if($stm->execute())
		        {
                    echo "Update gelukt!!";
		        }else echo "Sorry..";
            }
        //Delete
            if(isset($_POST['btnDelete'])){
                $query=("DELETE FROM vluchten WHERE vluchtNr=$vlucht");
                $stm=$conn->prepare($query);
                if($stm->execute()){
                    echo "Vlucht verwijderd";
                }
            }
        ?>

        
    </div>
<body>
</html>