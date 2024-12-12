<?php
    class Playlist {

        private $con;
        private $id;
        private $name;
        private $owner;


        public function __construct($con, $data) {

            if(!is_array($data)) {
                $query = $con->query("SELECT * FROM playlists WHERE id='$data'");
                $data = $query->fetch_array();
            }

            $this->con = $con;
            $this->id = $data['id'];
            $this->name = $data['name'];
            $this->owner = $data['owner'];
        }
        public function getId() {
            return $this->id;
        }
        public function getName() {
            return $this->name;
        }
        public function getOwner() {
            return $this->owner;
        }
        public function getNumberOfSongs() {
            return $this->con->query("SELECT songId FROM playlistSongs WHERE playlistId='$this->id'")->num_rows;
        }
        public function getSongIds() {
            // Izpilda SQL vaicājumu, lai iegūtu dziesmu ID pēc albumu kārtības
            $query = mysqli_query($this->con, "SELECT songId FROM playlistSongs WHERE playlistId='$this->id' ORDER BY playlistOrder ASC");
            $array = array(); // Inicializē tukšu masīvu

            // Pievieno katru dziesmas ID masīvam
            while($row = mysqli_fetch_array($query)) {
                array_push($array, $row['songId']);
            }

            // Atgriež dziesmu ID masīvu
            return $array;
        }
        
    }
?>