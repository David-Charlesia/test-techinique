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

 ?>
