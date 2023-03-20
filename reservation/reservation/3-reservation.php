<!DOCTYPE html>
<html>
  <head>
    <title>CMI Aldea Horia - Pagina de booking</title>
    <meta charset="utf-8">
    <link href="3-theme.css" rel="stylesheet">
    </script>
  </head>
<center> 
 <body>
 <h2>CMI Aldea Horia - Pagina de rezervare </h2>
    <?php
    // (A) PROCESS RESERVATION
    if (isset($_POST["date"])) {
      require "2-reserve.php";
      if ($_RSV->save(
        $_POST["date"], $_POST["slot"], $_POST["name"],
        $_POST["email"], $_POST["tel"], $_POST["notes"])) {
        echo "<div class='note'>Am primit rezervarea dumneavoastra.</div>";
      } else { echo "<div class='note'>".$_RSV->error."</div>"; }
    }
    ?>

    <!-- (B) RESERVATION FORM -->
    <form id="resForm" method="post" target="_self">
      <label>Nume & Prenume</label>
      <input type="text" required name="name" value="">

      <label>E-Mail</label>
      <input type="email" required name="email" value="">

      <label>Nr de telefon</label>
      <input type="text" required name="tel" value="">

      <label>Informatii aditionale</label>
      <input type="text" name="notes" value="">

      <?php
      // @TODO - MINIMUM DATE (TODAY)
      // $mindate = date("Y-m-d", strtotime("+2 days"));
      $mindate = date("Y-m-d");
      ?>
      <label>Data Rezervarii</label>
      <input type="date" required name="date" min="<?=$mindate?>">

      <label>Preferinte rezervare</label>
      <select name="slot">
        <option value="AM">Dimineata</option>
        <option value="PM">Dupa-amiaza</option>
		<option value="PM">Oricand</option>
      </select>

      <input type="submit" value="Trimite">
	  
	  </form>
	  
	  <a href="4-report.php" class="button">
	  <button class="button">Genereaza Raport</button></a>
	 
	  
	  

  </body>
</html>