<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pavlíkův skriptík - načtení položek pro editaci</title>
</head>
<body>
    <h1>14. Načtení dat do formuláře pomocí PHP</h1>
    <p><i>Popište způsob identifikace záznamu, načtení konkrétního záznamu a zobrazení hodnot ve formuláři (hodnoty textového pole, zaškrtnutí zaškrtávacího pole, označení správného přepínače či hodnoty výběrového pole).</i></p>
    <?php    
    if(!isset($_GET["id"])){
        echo "URL adresa musí obsahovat parametr ID. (Např: http://localhost/maturita2017/14_editace.php?id=1)";
        exit;
    }
    
    
    
    #includuju - připojím k souboru index.php soubor connect.php, ve kterém je připojení k databázi
    include 'connect.php';
    
    
    if(isset($_POST['nazev_hry'])){
		  if($_POST['cena_hry']!=""){
              
              $nazev_hry = $_POST['nazev_hry'];
			  $cena_hry = $_POST['cena_hry'];
			  $studio_id = $_POST['studio'];
			  $pristupnost = $_POST['pristupnost'];
              
              if(isset($_POST['skladem'])){
                  $je_na_sklade = '1';
              } else {
                  #neni na sklade
                  $je_na_sklade = '0';
              }
              
              $dotaz =  "UPDATE hry SET nazev = '$nazev_hry', cena = '$cena_hry', studio = '$studio_id', pristupnost='$pristupnost', skladem='$je_na_sklade' WHERE hry.id = {$_GET["id"]};";
              $vypis = mysqli_query($pripojeni_k_databazi, $dotaz);
              
					if($vypis){
                        echo "Odmaturuješ!";
                    } else {
				        echo "Ne! Všechno špatně!";
                    }
			  } else {
              echo "Špatně vyplněná data!";
          }
        }

    
    
    
    
    # napíšu si dotaz SELECT;
    # RADA - vždycky si první SELECT vložte do PHPMyAdminu, abyste si ověřili, že to 100% funguje
    $dotaz_na_databazi = "SELECT id, nazev, studio, zanr, cena, pristupnost, popis, skladem FROM hry WHERE hry.id={$_GET["id"]}";
    # dotaz provedu
    $data = mysqli_query($pripojeni_k_databazi, $dotaz_na_databazi);
    $nacteny_zaznam = mysqli_fetch_array($data);
    
    $vek = $nacteny_zaznam["pristupnost"];
    $skladem = $nacteny_zaznam["skladem"];
    
    ?>
    
    <form method="post">
        <label>Název hry</label>
        <!-- klasicky si udělám input; do value (hodnota) napíšu echo, kde vypíšu název hry -->
        
        <!-- první možnost -->
        <input type="text" name="nazev_hry" value="<?php echo $nacteny_zaznam["nazev"]; ?>"></input><br>
    
        <!-- druhá možnost -->
        <?php echo "Název hry <input type='text' name='nazev_hry' value='{$nacteny_zaznam['nazev']}'></input>"; ?><br>
    
        <!-- načtu cenu z databáze -->
        <label>Cena hry</label>
        <input type="text" name="cena_hry" value="<?php echo $nacteny_zaznam["cena"]; ?>"></input><br>
    
        
        <label>Studio</label>
        <!-- v tabulce hry mám uložené ID studia (třeba 3,5,9) a v tabulce studia mám uložené k nim i názvy; uživateli chci samozřejmě zobrazit názvy, takže vytvořím SELECT -->
    
        <!-- html select = rámeček s možnostmi + pojmenuju (toto pojmenování budeme potřebovat až budeme ukládat editaci záznamu) -->
        <select name="studio">
        <?php
            # jednoduchy select, kde vypisu studia a seřadím je
            $nacteni_studii = "SELECT * FROM studia ORDER BY studio ASC";
            # provedu dotaz
            $jednotlive_studio = mysqli_query($pripojeni_k_databazi, $nacteni_studii);
            # pomocí cyklu while vypisuju studia
            while($zaznam_studio = mysqli_fetch_array($jednotlive_studio)){
    
                # abych mohl uživateli označit, které studio je vybrano, vytvořím podmínku; v ní se ptám, zda právě vypisované ID studia se rovná ID studia, které nyní edituji
                # nalezne se přesně jedna shoda a u ní si vytvořím nějakou promněnnou (v tomto případě $parametr), do které napíši selected
                # takže při vypisování studií je přesně jedna položka označena
                if($zaznam_studio["id"]==$nacteny_zaznam["studio"]){
                    $parametr = "selected";
                } else {
                # když vypisuji studio, které se nerovná studiu zadanému u editovaného produktu
                    $parametr = "";
                }
                echo "<option value='{$zaznam_studio["id"]}' $parametr>{$zaznam_studio["studio"]}</option>";
            }
        ?>
        </select><br>
    
    
        <?php
        if($skladem=='1'){
            $na_sklade = "checked";
        } else {
            $na_sklade = "";
        }
    
        ?>
        <input type="checkbox" name="skladem" <?php echo $na_sklade; ?>>skladem<br>
    
    
        <input type="radio" name="pristupnost" value="3" <?php if($vek=='3') echo "checked"; ?>>3 roky
        <input type="radio" name="pristupnost" value="7" <?php if($vek=='7') echo "checked"; ?>>7 let
        <input type="radio" name="pristupnost" value="12" <?php if($vek=='12') echo "checked"; ?>>12 let
        <input type="radio" name="pristupnost" value="15" <?php if($vek=='15') echo "checked"; ?>>15 let
        <input type="radio" name="pristupnost" value="18" <?php if($vek=='18') echo "checked"; ?>>18 let
    
        <br><br>
        <!-- tímto jsme tedy načetli data pro editaci, k samotné editaci jsme se ve škole nedostali;
             pokud budete chtít a pomůže vám to, můžu vám editaci ještě udělat -->
        <input type="submit" value="Odešli Pavlíkovu skvělou editaci">
    </form>
</body>
</html>