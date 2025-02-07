<?php

/**
 * main model class
 */

class model extends database
{
    protected $table = "";
    protected $primaryKey = "id";

    public function insert($data){
        if (!empty($this->queryColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->queryColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);

        $query = "insert into " . $this->table;
        $query .= " (".implode(',',$keys).") values (:".implode(',:',$keys).")";

        $this->query($query, $data);
    }
    public function update($id, $data,$idName = "id"){
        if (!empty($this->queryColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->queryColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);
        $query = "update " . $this->table . " set ";
        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ",";
        }
        $query = trim($query, ",");
        $query .= " where $idName = :$idName";
        
        $data[$idName] = $id;
        $this->query($query, $data);
    }
    // public function where($data, $order = "DESC", $order_by = "id") {
    //     $keys = array_keys($data);
    
    //     $query = "SELECT * FROM \"$this->table\" WHERE ";
    //     foreach ($keys as $key) {
    //         $query .= "\"$key\" = :$key AND ";
    //     }
    
    //     // Trim the trailing 'AND'
    //     $query = rtrim($query, " AND ");
        
    //     // Ensure column ordering is safe
    //     $query .= " ORDER BY \"$order_by\" $order";
    
    //     $res = $this->query($query, $data);
    
    //     if (is_array($res)) {
    //         // Call afterSelect function if it exists
    //         if (property_exists($this, 'afterSelect')) {
    //             foreach ($this->afterSelect as $func) {
    //                 $res = $this->$func($res);
    //             }
    //         }
    //         return $res;
    //     }
    
    //     return false;
    // }
    public function where($data, $order = "DESC", $order_by = "id") {
        if (!is_array($data) || empty($data)) {
            throw new Exception("Invalid data: where() expects a non-empty associative array.");
        }
    
        $keys = array_keys($data);
        $query = "SELECT * FROM \"$this->table\" WHERE ";
        
        foreach ($keys as $key) {
            $query .= "\"$key\" = :$key AND ";
        }
    
        // Remove the last "AND"
        $query = rtrim($query, " AND ");
        $query .= " ORDER BY \"$order_by\" $order";
    
        // Debugging: Print the query
        error_log("Executing SQL: " . $query);
    
        try {
            $res = $this->query($query, $data);
    
            if (is_array($res)) {
                // Call afterSelect function if it exists
                if (property_exists($this, 'afterSelect')) {
                    foreach ($this->afterSelect as $func) {
                        $res = $this->$func($res);
                    }
                }
                return $res;
            }
    
            return false;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    

    public function delete($id) {

        $query = "delete from " . $this->table . " where course_id=".$id;

        
        $res = $this->query($query);
        if (is_array($res)) {
            ////// call afterSelect function ////////////
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $res = $this->$func($res);
                }
            }
            return $res;
        }
        return false;
    }
    

    public function findAll($order = "desc", $idName= "id", $pagenation=true , $limit = 6, $offset = 0)
    {
        if ($pagenation) {
            $query = "select * from " . $this->table . " order by $idName ".$order." limit $offset".", $limit";
        } else {
            $query = "select * from " . $this->table . " order by $idName ".$order;
        }
        
        $res = $this->query($query);
        if (is_array($res)) {
            ////// call afterSelect function ////////////
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $res = $this->$func($res);
                }
            }
            return $res;
        }
        return false;
    }
    public function first($data, $order = "desc"){
        $keys = array_keys($data);

        $query = "select * from " . $this->table . " where ";
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }

        $query = trim($query, "&& ");
        $query .= " order by id $order limit 1";
        $res = $this->query($query, $data);
        if (is_array($res)) {
            ////// call afterSelect function ////////////
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $res = $this->$func($res);
                }
            }
            return $res[0];
        }
        return false;
    }
}