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
          $this->bd = new PDO($host, $username, $password);
          $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->bd->query("SET nameS 'utf8'");
      } catch (PDOException $e) {
          die('Echec connexion, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }
    }

    function getModel()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Model();
        }
        return self::$instance;
    }

    function getAllStudent(){
      try{
        $requete = $this->bd->prepare('SELECT * FROM STUDENT');
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
      }catch(PDOException $e){
        die('Echec getAllStudent, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }
    }

    function getStudentFirstName($numEtud){
      try{
        $requete = $this->bd->prepare('SELECT first_name FROM STUDENT WHERE num_etud=:num_etud');
        $requete->bindValue(':num_etud', $numEtud);
        return $requete->execute();
      }catch(PDOException $e){
        die('Echec getStudentFirstName, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }

    }

    function getStudentLastName($numEtud){
      try{
        $requete = $this->bd->prepare('SELECT last_name FROM STUDENT WHERE num_etud=:num_etud');
        $requete->bindValue(':num_etud', $numEtud);
        return $requete->execute();
      }catch(PDOException $e){
        die('Echec getStudentLastName, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }

    }

    function setStudentFirstName($numEtud,$firstName){
      try{
        $requete=$this->bd->prepare('UPDATE STUDENT SET first_name = :firstname WHERE num_etud = :numEtud');
        $requete->bindValue(':firstname',$firstName);
        $requete->bindValue(':numEtud',$numEtud);
        $requete->execute();
      }catch(PDOException $e){
        die('Echec setStudentFirstName, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }

    }

    function setStudentLastName($numEtud,$lastName){
      try{
        $requete=$this->bd->prepare('UPDATE STUDENT SET last_name = :lastname WHERE num_etud = :numEtud');
        $requete->bindValue(':lastname',$lastName);
        $requete->bindValue(':numEtud',$numEtud);
        $requete->execute();
      }catch(PDOException $e){
        die('Echec setStudentLastName, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }

    }

    function addStudent($numEtud,$firstName,$lastName){
      try{
        $requete=$this->bd->prepare('INSERT INTO STUDENT(num_etud,_first_name,last_name) VALUES(:numEtud,:firstName,:lastName)');
        $requete->bindValue(':numEtud',$numEtud);
        $requete->bindValue(':firstName',$firstName);
        $requete->bindValue(':lastName',$lastName);
        $requete->execute();
      }catch(PDOException $e){
        die('Echec addStudent, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }
    }

    function deleteStudent($numEtud){
      try{
        $requete=$this->bd->prepare('DELETE FORM STUDENT WHERE num_etud=:numEtud');
        $requete->bindValue(':numEtud',$numEtud);
        $requete->execute();
      }catch(PDOException $e){
        die('Echec deleteStudent, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }
    }


  }

  /*  Exemple de traitement de formulaire tirer d'un projet universitaire fait par moi


   * Retourne les prix nobels correspondant aux critères de recherche donnés par $filters
   * @param  [array]  $filters contient :
   *                           - une clé name si le nom doit contenir $filters['name']
   *                           - une clé year et une clé Sign si l'on doit retourner les prix nobels
   *                             dont l'année est $filters['Sign'] (<=, >=, =) à $filters['year']
   *                           - une clé categories si la catégorie doit être dans l'ensemble de catégories données par $filters['categories']
   * @param  integer $offset  Position de départ
   * @param  integer $limit   Nombre de résultats retournés
   * @return [array]          Tableaux de résultats

  public function findNobelPrizes($filters, $offset = 0, $limit = 25)
  {

      try {
          $sql = 'SELECT * FROM nobels WHERE 1=1';
          $bv = [];

          if (isset($filters['name'])) {
              $sql .= ' AND name LIKE :name';
              $bv[] = [
                  'marqueur' => ':name',
                  'valeur'   => '%' . $filters['name'] . '%',
                  'type'     => PDO::PARAM_STR
              ];
          }

          if (isset($filters['year'])) {
              $sql .= ' AND year ' . $filters['Sign'] . ' :year';
              $bv[] = [
                  'marqueur' => ':year',
                  'valeur'   => intval($filters['year']),
                  'type'     => PDO::PARAM_INT
              ];
          }

          if (isset($filters['categories'])) {
              $nbc = count($filters['categories']);
              $sql .= ' AND category IN (:c0';
              for ($i = 1; $i < $nbc; $i++) {
                  $sql .= ',:c' . $i;
              }
              $sql .= ')';
              foreach ($filters['categories'] as $key => $value) {
                  $bv[] = [
                      'marqueur' => ':c' . $key,
                      'valeur'   => $value,
                      'type'     => PDO::PARAM_STR
                  ];
              }
          }

          $sql .= ' ORDER BY year DESC LIMIT :limit OFFSET :offset';
          $bv[] = [
              'marqueur' => ':limit',
              'valeur'   => intval($limit),
              'type'     => PDO::PARAM_INT
          ];

          $bv[] = [
              'marqueur' => ':offset',
              'valeur'   => intval($offset),
              'type'     => PDO::PARAM_INT
          ];


          //Exécution et renvoi des résultats
          $requete = $this->bd->prepare($sql);
          foreach ($bv as $value) {
              $requete->bindValue($value['marqueur'], $value['valeur'], $value['type']);
          }
          $requete->execute();
          return $requete->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          die('Echec findNobelPrizes, erreur n°' . $e->getCode() . ':' . $e->getMessage());
      }
  }

  */

 ?>
