<?php

class TripStop {
	
	private $_rowid = 0;
	private $trip_id = 0;
	private $destination_id = 0;
	private $destination_title = "?";
	private $position = 0;
	private $modality_id = 0;
	private $modality_title = "?";
	private $modality_icon = "";
			
	public function __construct($id = 0) {
		$this->destination_title = "(Sans nom)";
		if ($id) {
			$this->loadTripStop($id);
		}
	}
	
	public function loadTripStop($id) {
		$query = "SELECT *, destinations.title AS destination_title, destinations._rowid AS destination_id, modalities.title AS modality_title, modalities.icon AS modality_icon, modalities._rowid AS modality_id FROM trips_stops INNER JOIN destinations ON destination_id=destinations._rowid INNER JOIN modalities ON modality_id=modalities._rowid WHERE trips_stops._rowid=" . ($id + 0) . " LIMIT 1;";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			$row = mysqli_fetch_object($result);
			$this->_rowid               = intval($id);
			$this->trip_id              = intval($row->trip_id);
			$this->destination_id       = intval($row->destination_id);
			if ($this->destination_title) {
				$this->destination_title = $row->destination_title;
			}
			$this->position             = $row->position;
			$this->modality_id          = intval($row->modality_id);
			if ($this->modality_title) {
				$this->modality_title = $row->modality_title;
			}
			$this->modality_icon        = $row->modality_icon;
		} else {
			echo "<p>empty rowset for $id!</p>";
		}
	}

	public function getTitle() {
		return $this->title;
	}

	public function getID() {
		return $this->_rowid;
	}

	public function getPosition() {
		return $this->position;
	}

	public function getDestinationTitle() {
		return $this->destination_title;
	}

	public function getDestinationID() {
		return $this->destination_id;
	}

	public function getModalityTitle() {
		return $this->modality_title;
	}

	public function getModalityID() {
		return $this->modality_id;
	}

	public function getModalityIcon() {
		return $this->modality_icon;
	}

	public function setTripID($trip_id) {
		$this->trip_id = $trip_id;
	}

	public function setDestination($destination) {
		$query = "SELECT * FROM destinations WHERE _rowid=" . ($destination + 0) . ";";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			$row = mysqli_fetch_object($result);
			$this->destination_id = $row->_rowid;
			$this->destination_title = $row->title;
		}
	}

	public function setModality($modality) {
		$query = "SELECT * FROM modalities WHERE _rowid=" . ($modality + 0) . ";";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			$row = mysqli_fetch_object($result);
			$this->modality_id = $row->_rowid;
			$this->modality_title = $row->title;
		}
	}

	public function setPosition($position) {
		$this->position = $position;
	}

	public function saveToDB() {
		if ($this->_rowid) {
			$query = "UPDATE trips_stops SET destination_id=" . $this->destination_id . ", modality_id=" . $this->modality_id . ", position=" . $this->position . " WHERE _rowid=" . $this->_rowid . ";";
			mysqli_query($GLOBALS["mysql_link"], $query);
			echo mysqli_error($GLOBALS["mysql_link"]);
		} else {
			$query = "INSERT INTO trips_stops SET trip_id=" . $this->trip_id . ", destination_id=" . $this->destination_id . ", modality_id=" . $this->modality_id . ", position=" . $this->position . ";";
			mysqli_query($GLOBALS["mysql_link"], $query);
			echo mysqli_error($GLOBALS["mysql_link"]);
			// On positionne le row id
			$this->_rowid = mysqli_insert_id($GLOBALS["mysql_link"]);
		}
		return $this->_rowid;
	}

	public function delete() {
		$query = "DELETE FROM trips_stops WHERE _rowid=" . $this->_rowid . ";";
		mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
	}

	public static function getAllModalities() {
		$modalities = array();

		$query = "SELECT * FROM modalities;";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_object($result)) {
				$modalities[$row->_rowid] = $row->title;
			}
		}

		return $modalities;
	}

	public static function getAllDestinations() {
		$destinations = array();

		$query = "SELECT * FROM destinations ORDER BY title ASC;";
		$result = mysqli_query($GLOBALS["mysql_link"], $query);
		echo mysqli_error($GLOBALS["mysql_link"]);
		if ($result && mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_object($result)) {
				$destinations[$row->_rowid] = $row->title;
			}
		}

		return $destinations;
	}

}

