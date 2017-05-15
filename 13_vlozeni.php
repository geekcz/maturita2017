<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pavlíkův skriptík - vložení hry</title>
</head>
<body>
    <h1>13. Vložení dat do databáze</h1>
    <p><i>Popište vytvoření spojení s databází, nastavení znakové sady, princip kontroly dat a uložení zadaných dat jako nového záznamu do databáze. Vysvětlete souvislosti mezi metodou odeslání dat formuláře, pojmenováním polí formuláře a php proměnnými. Vysvětlete SQL dotaz pro vložení záznamu.</i></p>
    <?php    
    #includuju - připojím k souboru index.php soubor connect.php, ve kterém je připojení k databázi
    include 'connect.php';
    
	if(isset($_POST["nazev_hry"])){
		if($_POST["nazev_hry"]==""){echo "Není zadán název hry.";}
		if($_POST["cena"]==""){echo "Není zadána cena hry.";}
		else{
			$nadpis = $_POST["nazev_hry"];
			$cena = $_POST["cena"];
			$studio = $_POST["studio"];
			$zanr = $_POST["zanr"];
			$popis = $_POST["popis"];
			$pristupnost = $_POST["pristupnost"];
			if(isset($_POST["skladem"])){
			    $sklad = '1';
			} else {
			    $sklad = '0';
			}
            
            
				$sql = "INSERT INTO `hry` (`nazev`, `cena`, `studio`, `zanr`, `popis`, `pristupnost`, `skladem`) VALUES ('$nadpis', '$cena', '$studio', '$zanr', '$popis', '$pristupnost', '$sklad');"; 
				$dotaz = mysqli_query($pripojeni_k_databazi, $sql);
				if($dotaz){
					echo "ok";
                } else {
                    echo "no";
                }
			}
		}
    
    
    ?>
    
    <form method="post">
        <label>Název hry</label>
        
        <input type="text" name="nazev_hry"></input>
    
        <label>Cena hry</label>
        <input type="text" name="cena"></input>
    
        
        <label>Studio</label>
        <select name="studio">
        <?php
            $nacteni_studii = "SELECT * FROM studia ORDER BY studio ASC";
            $jednotlive_studio = mysqli_query($pripojeni_k_databazi, $nacteni_studii);
            while($zaznam_studio = mysqli_fetch_array($jednotlive_studio)){
                echo "<option value='{$zaznam_studio["id"]}'>{$zaznam_studio["studio"]}</option>";
            }
        ?>
        </select>    
        
        <label>Žánr</label>
        <select name="zanr">
        <?php
            $nacteni_zanru = "SELECT * FROM zanry";
            $jednotlive_zanry = mysqli_query($pripojeni_k_databazi, $nacteni_zanru);
            while($zaznam_zanr = mysqli_fetch_array($jednotlive_zanry)){
                echo "<option value='{$zaznam_zanr["id"]}'>{$zaznam_zanr["zanr"]}</option>";
            }
        ?>
        </select>
    
        <label>Popis</label>
        <input type="text" name="popis"></input>
        <br><br>

        <input type="radio" name="pristupnost" value="3" checked>3
        <input type="radio" name="pristupnost" value="7">7
        <input type="radio" name="pristupnost" value="12">12
        <input type="radio" name="pristupnost" value="15">15
        <input type="radio" name="pristupnost" value="18">18
        
        <br>

        <input type="checkbox" name="skladem">skladem<br>

        <input type="submit" value="Vložit">
    </form>
</body>
</html>