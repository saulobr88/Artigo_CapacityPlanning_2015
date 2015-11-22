<html>
 <body>
<?php
if (isset ($_GET["action"]) && isset ($_GET["id"]) && $_GET["action"] == "get_person") {
    $person_info = file_get_contents('http://localhost/RestAPI/api2db.php?action=get_person&id=' . $_GET["id"]);
    $person_info2 = json_decode($person_info, true);
    ?>
    <table border="1">
      <tr>
        <td>ID: </td><td> <?php echo $person_info2["actor_id"]; ?></td>
      </tr>
      <tr>
        <td>Nome: </td><td> <?php echo $person_info2["first_name"]." ".$person_info2["last_name"]; ?></td>
      </tr>
      <tr>
        <td>Last Update: </td><td> <?php echo $person_info2["last_update"]; ?></td>
      </tr>
    </table>
    <br />
    <a href="http://<?php echo($_SERVER['SERVER_ADDR'])?>/RestAPI/RestDBClient.php?action=get_person_list" alt="person list">Retornar para a lista de pessoas</a>

          <?php
      }
      else // else take the app list
          {
          $person_list = file_get_contents('http://localhost/RestAPI/api2db.php?action=get_person_list');
          $person_list = json_decode($person_list, true);
          ?>
    <H2>Lista de pessoas</H2>
    <ul>
    <?php foreach ($person_list as $person) : ?>
    <li>
    	<a href="<?php echo 'http://'.$_SERVER['SERVER_ADDR'].'/RestAPI/RestDBClient.php?action=get_person&id=' . $person['actor_id'] ?>" alt="<?php echo 'person_' . $person['actor_id'] ?>">
		<?php echo $person["first_name"]." ".$person["last_name"] ?>
	</a>
    </li>
    <?php endforeach;?>
    </ul>
          <?php
      }
      ?>
 </body>
</html>
