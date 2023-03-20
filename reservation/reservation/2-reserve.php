<?php
class Reservation {
  // (A) CONSTRUCTOR - CONNECT TO DATABASE
  private $pdo; // pdo object
  private $stmt; // sql statement
  public $error; // error message
  function __construct() {
    $this->pdo = new PDO(
      "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
      DB_USER, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED
    ]);
  }

  // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct() {
    $this->pdo = null;
    $this->stmt = null;
  }

  // (C) HELPER - EXECUTE SQL QUERY
  function query ($sql, $data=null) {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($data);
  }

  // (D) SAVE RESERVATION
  function save ($date, $slot, $name, $email, $tel, $notes="") {
    // (D1) CHECKS & RESTRICTIONS
    // @TODO - ADD YOUR OWN RULES & REGULATIONS HERE
    // MAX # OF RESERVATIONS ALLOWED?
    // USER CAN ONLY BOOK X DAYS IN ADVANCE?
    // USER CAN ONLY BOOK A MAX OF X SLOTS WITHIN Y DAYS?

    // (D2) DATABASE ENTRY
    $this->query(
      "INSERT INTO `reservations` (`res_date`, `res_slot`, `res_name`, `res_email`, `res_tel`, `res_notes`) VALUES (?,?,?,?,?,?)",
      [$date, $slot, $name, $email, $tel, $notes]
    );

    // (D3) EMAIL
    // @TODO - REMOVE IF YOU WANT TO MANUALLY CALL TO CONFIRM OR SOMETHING
    // OR EMAIL THIS TO A MANAGER OR SOMETHING
    $subject = "Reservation Received";
    $message = "Thank you, we have received your request and will process it shortly.";
    @mail($email, $subject, $message);
    return true;
  }

  // (E) GET RESERVATIONS FOR THE DAY
  function getDay ($day="") {
    // (E2) GET ENTRIES
    $this->query("SELECT * FROM `reservations`", []);
    return $this->stmt->fetchAll();
  }
}

// (F) DATABASE SETTINGS - CHANGE THESE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "reservation");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "reservation");
define("DB_PASSWORD", "iiQt&1848");

// (G) NEW RESERVATION OBJECT
$_RSV = new Reservation();