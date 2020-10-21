<?php

class Trip {
	
	private $_rowid = 0;
	private $title = "";
	private $trip_stops = array();
	
	public function __construct($id = 0) {
		$this->title = "(Sans nom)";
		if ($id) {
			$this->loadTrip($id);
		}
	}
	
	public function loadTrip($id) {
		$query = "SELECT * FROM trips WHERE _rowid=" . ($id + 0) . " LIMIT 1;";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			$row = mysqli_fetch_object($result);
			$this->_rowid = intval($id);
			$this->title = $row->title;
		}
		$this->loadTripStops();
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = trim($title);
	}

	public function getID() {
		return $this->_rowid;
	}

	public function getTripStops() {
		return $this->trip_stops;
	}

	private function loadTripStops() {
		// RAZ
		$this->trip_stops = array();

		// Chargement
		$query = "SELECT _rowid FROM trips_stops WHERE trip_id=" . $this->_rowid . " ORDER BY position ASC;";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_object($result)) {
				array_push($this->trip_stops, new TripStop($row->_rowid));
			}
		}
	}

	public function addTripStopBefore($stop_data, $insert_before = 0) {
		// Creation de l'etape
		$new_stop = new TripStop();
		$new_stop->setTripID($this->_rowid);
		$new_stop->setDestination($stop_data["destination"]);
		$new_stop->setModality($stop_data["modality"]);

		if (!empty($insert_before)) {
			// Trouver la position de l'etape a l'index insert_before
			$stop_before = new TripStop($insert_before);

			// Decalage des positions des etapes suivantes
			$query = "UPDATE trips_stops SET position=(position + 1) WHERE trip_id=" . $this->_rowid . " AND position>=" . $stop_before->getPosition() . ";";
			$result = mysqli_query($GLOBALS["mysql_link"], $query);
			echo mysqli_error($GLOBALS["mysql_link"]);

			// Positionnement de l'etape inseree
			$new_stop->setPosition($stop_before->getPosition());
		} else {
			$new_stop->setPosition(count($this->trip_stops));
		}

		// Insertion de l'etape
		$result = $new_stop->saveToDB();
		// Mise a jour
		$this->loadTripStops();

		return $result;
	}

	public function deleteTripStop($stop_id) {
		$stop = new TripStop($stop_id);
		$deleted_position = $stop->getPosition();
		$stop->delete();

		// Decalage des positions des etapes suivantes
		$query = "UPDATE trips_stops SET position=(position - 1) WHERE trip_id=" . $this->_rowid . " AND position>=" . $deleted_position . ";";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);

		// Remise a jour de la liste
		$this->loadTripStops();
	}

	public function saveToDB() {
		if ($this->_rowid) {
			$query = "UPDATE trips SET title=\"" . preg_replace("/;/", "-", preg_replace("/\"/", "''", $this->title)) . "\" WHERE _rowid=" . $this->_rowid . ";";
			mysqli_query($GLOBALS["mysql_link"], $query);
			echo mysqli_error($GLOBALS["mysql_link"]);
		} else {
			$query = "INSERT INTO trips SET title=\"" . preg_replace("/;/", "-", preg_replace("/\"/", "''", $this->title)) . "\";";
			mysqli_query($GLOBALS["mysql_link"], $query);
			echo mysqli_error($GLOBALS["mysql_link"]);
			// On positionne le row id
			$this->_rowid = mysqli_insert_id($GLOBALS["mysql_link"]);
		}
	}

	public static function getAllTrips() {
		$list = array();

		$query = "SELECT * FROM trips ORDER BY _rowid DESC";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_object($result)) {
				array_push($list, new Trip($row->_rowid));
			}
		}

		return $list;
	}

	/**
	 * Renvoie la liste des etapes qui ne figurent pas encore dans le voyage
	 * @return  Array
	 */
	public function getAvailableOtherStops() {
		$list = array();

		$query = "SELECT * FROM destinations WHERE _rowid NOT IN (SELECT destination_id FROM trips_stops WHERE trip_id=1);";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_object($result)) {
				$list[$row->_rowid] = $row->title;
			}
		}

		return $list;
	}

	public function returnTrue() {
		// Test PHPUnit
		return true;
	}

}

