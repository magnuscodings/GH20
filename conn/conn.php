<?php
session_start();

class DatabaseHandler {

    private $pdo;

    public function __construct() {
        // Set your database connection parameters here
        $dbHost = 'localhost';
        $dbPort = '3306';
        $dbName = 'gh20';
        $dbUser = 'root';
        $dbPassword = '';

        try {
            $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName";
            $this->pdo = new PDO($dsn, $dbUser, $dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle connection errors
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getAllRowsFromTable($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE status = 0");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }


    
    public function getAllRowsFromTableWhere($tableName, array $additionalConditions = []) {
        try {
            // Construct the WHERE clause with status = 0 and additional conditions
            $whereClause = "status = 0";
    
            if (!empty($additionalConditions)) {
                $whereClause .= " AND " . implode(' AND ', $additionalConditions);
            }
    
            // Prepare the SQL statement with the dynamic WHERE clause
            $sql = "SELECT * FROM $tableName WHERE $whereClause";
            $stmt = $this->pdo->prepare($sql);
    
            // Execute the query
            $stmt->execute();
    
            // Fetch the results as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    public function getAllRowsFromTableWhereGroup($tableName, array $additionalConditions = [], $groupBy = null) {
        try {
            // Construct the WHERE clause with status = 0 and additional conditions
            $whereClause = "status = 0";
    
            if (!empty($additionalConditions)) {
                $whereClause .= " AND " . implode(' AND ', $additionalConditions);
            }
    
            // Construct the GROUP BY clause if $groupBy is provided
            $groupByClause = "";
            if (!empty($groupBy)) {
                $groupByClause = " GROUP BY " . $groupBy;
            }
    
            // Prepare the SQL statement with the dynamic WHERE and GROUP BY clauses
            $sql = "SELECT * FROM $tableName WHERE $whereClause $groupByClause";
            $stmt = $this->pdo->prepare($sql);
    
            // Execute the query
            $stmt->execute();
    
            // Fetch the results as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    
    
    public function loginUser($username, $password) {
        try {
            $username = htmlentities($username);
            $password = htmlentities($password);
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email AND status = 0");
            $stmt->bindParam(':email', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Here, you should compare the password using a secure method like password_verify
                if ($user['password'] === $password) {
                    $_SESSION['user'] = $user['position'];
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    return true; // Login successful
                }
            }

            return false; // Login failed

        } catch (PDOException $e) {
            // Handle query errors
            echo "Login query failed: " . $e->getMessage();
            return false;
        }
    }
    

    
    public function insertData($tableName, $data) {
        try {
            foreach ($data as $key => $value) {
                $data[$key] = trim(htmlentities($value));
            }

            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;

            // echo "Error inserting data: " . $e->getMessage();
        }
    }
    public function updateData($tableName, $data, $whereConditions) {
        try {
            $setClause = '';
            foreach ($data as $key => $value) {
                $setClause .= "$key = :$key, ";
            }
            // Remove the trailing comma and space from the setClause
            $setClause = rtrim($setClause, ', ');
    
            $whereClause = '';
            foreach ($whereConditions as $whereKey => $whereValue) {
                $whereClause .= "$whereKey = :where_$whereKey AND ";
            }
            // Remove the trailing "AND" from the whereClause
            $whereClause = rtrim($whereClause, ' AND ');
    
            $sql = "UPDATE $tableName SET $setClause WHERE $whereClause";
            $stmt = $this->pdo->prepare($sql);
    
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
    
            foreach ($whereConditions as $whereKey => $whereValue) {
                $stmt->bindValue(':where_' . $whereKey, $whereValue);
            }
    
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
            // You can log or handle the error here.
        }
    }
    
    
    public function getIdByColumnValue($tableName, $columnName, $columnValue, $idColumnName) {
        try {
            $stmt = $this->pdo->prepare("SELECT $idColumnName FROM $tableName WHERE $columnName = :column_value");
            $stmt->bindParam(':column_value', $columnValue);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result[$idColumnName];
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // echo "Error retrieving ID: " . $e->getMessage();
            return null;
        }
    }
    public function getCountByConditions($tableName, $conditions) {
        try {
            $sql = "SELECT COUNT(*) as count FROM $tableName";
    
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $whereConditions = [];
    
                foreach ($conditions as $column => $value) {
                    $whereConditions[] = "$column = :$column";
                }
    
                $sql .= implode(" AND ", $whereConditions);
            }
    
            $stmt = $this->pdo->prepare($sql);
    
            foreach ($conditions as $column => $value) {
                $stmt->bindParam(":$column", $value);
            }
    
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            return $count;
        } catch (PDOException $e) {
            // Handle the exception as needed
            return null;
        }
    }
    
    public function getAllColumnsByColumnValue($tableName, $columnName, $columnValue) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE $columnName = :column_value");
            $stmt->bindParam(':column_value', $columnValue);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result;
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // Handle the exception here
            return null;
        }
    }
    public function getAllColumns($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE status = 0");
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result;
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // Handle the exception here
            return null;
        }
    }



    

   
   
    
    
    
    
}
?>
