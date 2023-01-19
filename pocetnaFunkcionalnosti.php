<?php
    include('konekcija.php');

    if (isset($_POST['key'])) {

        if($_POST['key'] == 'ubaci'){
            
            $mob_id = $_POST['mob_id'];
            $naziv = $_POST['naziv'];
            $model = $_POST['model'];
            $godinaProizvodnje = $_POST['godina_proizvodnje'];
            $cena = $_POST['cena'];
            
            $check = mysqli_query($conn,"SELECT * FROM telefoni WHERE mob_id = '$mob_id'");
    
            if(mysqli_num_rows($check) > 0) {
                echo "Isti model telefona " . $model . ", već postoji!";
            } else {
            
                $sql="INSERT INTO `telefoni` (`mob_id`,`naziv`, `model`, `godina_proizvodnje`,`cena`,`vlasnik_id`) VALUES ('$mob_id','$naziv', '$model', '$godinaProizvodnje', '$cena', 1)";
            
                if ($conn->query($sql) === TRUE) {
                    echo "Ubacen novi model mobilnog telefona!";
                }
                else 
                {
                    echo "Takav model mobilnog telefona vec postoji!";
                }
            }
        }


        if($_POST['key'] == 'ucitaj'){
    
            $start = $conn->real_escape_string($_POST['start']);
            $limit = $conn->real_escape_string($_POST['limit']);
            $sort = $conn->real_escape_string($_POST['sort']);
            $sql = $conn->query("SELECT mob_id, naziv, model, godina_proizvodnje, cena FROM telefoni ORDER BY $sort LIMIT $start, $limit");

            if ($sql->num_rows > 0) {
                $response = "";
                while($data = $sql->fetch_array()) {
    
                    $response .= '
                                <tr>
                                    <td id="telefon_'.$data["mob_id"].'">'.$data["mob_id"].'</td>
                                    <td>'.$data["naziv"].'</td>
                                    <td>'.$data["model"].'</td>
                                    <td>'.$data["godina_proizvodnje"].'</td>
                                    <td>'.$data["cena"].'</td>
                                    <td>
                                        <input type="button" onclick="izmeniPogledaj('.$data["mob_id"].', \'izmeni\')" value="Izmeni" class="btn btn-primary">
                                        <input type="button" onclick="izmeniPogledaj('.$data["mob_id"].', \'pogledaj\')" value="Pogledaj" class="btn btn-warning">
                                        <input type="button" onclick="izbrisi('.$data["mob_id"].')" value="Izbriši" class="btn btn-danger">
                                    </td>
                                </tr>
                            ';
                    }
                    exit($response);
                    } else
                        exit('reachedMax');	
        }


        
        if ($_POST['key'] == 'izbrisi') {
            $mob_id = $conn->real_escape_string($_POST['mob_id']);
            $conn->query("DELETE FROM telefoni WHERE mob_id='$mob_id'");
            exit('Model telefona obrisan!');
        }

        if($_POST['key'] == 'uzmiPodatke'){
            $mob_id = $conn->real_escape_string($_POST['mob_id']);
            $sql = $conn->query("SELECT mob_id , naziv, model, godina_proizvodnje, cena FROM telefoni WHERE mob_id = $mob_id");
            $data = $sql->fetch_array();
            $jsonArray = array(
                'mob_id'=>$data['mob_id'],
                'naziv'=>$data['naziv'],
                'model'=>$data['model'],
                'godina_proizvodnje'=>$data['godina_proizvodnje'],
                'cena'=>$data['cena']
            );
            exit(json_encode($jsonArray));
        }
            

        if ($_POST['key'] == 'izmeni') {

            $trenutni_red = $conn->real_escape_string($_POST['mob_id']);

                $mob_id = $_POST['mob_id'];
                $naziv = $_POST['naziv'];
                $model = $_POST['model'];
                $godina_proizvodnje=$_POST['godina_proizvodnje'];
                $cena=$_POST['cena'];
                
            
                $sql="UPDATE telefoni SET naziv='$naziv', model='$model', godina_proizvodnje='$godina_proizvodnje', cena='$cena' WHERE mob_id='$trenutni_red'";
                if ($conn->query($sql) === TRUE) {
                    echo "Uspešno izmenjen mobilni telefon!";
                }
                else 
                {
                    echo "Mobilni telefon nije izmenjen!";
                }
            
            }
        }
    
        mysqli_close($conn);
    
?>