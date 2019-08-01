<?php

class ModelToolBooking extends Model {

    /**
     * This function is used for getting all the data related to the bookings of DuxBack.
     * @return mixed All rows of the table
     */
    public function getBookings(){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "booking ORDER BY date DESC, time ASC");
        return $this->formatBookings($query->rows);
    }

    /**
     * This function is used to add a booking to the database.
     * @param array $data Post request array containing all the required data.
     * @return mixed Rows added to the database.
     */
    public function addBooking(array $data){
        /*
         * Format query string with this data:
         *      1) Table name
         *      2) Supplier id
         *      3) User id
         *      4) Date
         *      5) Time
         */
        $format = "INSERT INTO %s VALUES(0, %d, %d, '%s', '%s')";
        $query_string = sprintf($format,
            DB_PREFIX . "booking",
            $data["id_supplier"],
            $data["user_id"],
            $this->db->escape($data["date"]),
            $this->db->escape($data["time"]));

        $query = $this->db->query($query_string);
        return $query->rows;
    }

    /**
     * @param $data array The POST request data.
     * @return bool True if there isn't a record, else false.
     */
    public function isUnique(array $data): bool{
        $format = "SELECT *
                   FROM %s
                   WHERE date = '%s' 
                   AND time = '%s' 
                   AND id_supplier=%d";

        $query_string = sprintf($format,
            DB_PREFIX . "booking",
            $this->db->escape($data["date"]),
            $this->db->escape($data["time"]),
            $data["id_supplier"]
        );

        $query = $this->db->query($query_string);
        return count($query->rows) == 0;
    }

    private function formatBookings($data){

        // Load id's
        //$formatted = array_unique(array_column($data, 'id_supplier'));

        foreach($data as $row){
            // Load all data in the "formatted" arrays
            $formatted[$row["id_supplier"]][] = array("date" => $row["date"], "time" => $row["time"]);
        }

        return $formatted;
    }
}
