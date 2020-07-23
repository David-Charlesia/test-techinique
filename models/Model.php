<?php
  /**
   *
   */
  class Model
  {
    private bd;

    function __construct(argument)
    {
      try {
          include('utils/credentials.php');
          $this->bd = new PDO($dns, $login, $mdp);
          $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->bd->query("SET nameS 'utf8'");
      } catch (PDOException $e) {
          die('Echec connexion, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }
    }
  }

 ?>
