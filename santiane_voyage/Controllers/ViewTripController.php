<?php

function defaultAction() {
	$view = array();

	if (!empty($_REQUEST["id"])) {
		$view["trip"] = new Trip($_REQUEST["id"]);
		$view["trip_stops"] = $view["trip"]->getTripStops();
	}

	return $view;
}

function addStopAction() {
	$view = array();

	$trip_stop = array(
		"destination"    => $_REQUEST["destination"],
		"modality"       => $_REQUEST["modality"]
	);

	$view["trip"] = new Trip($_REQUEST["id"]);
	$view["trip"]->addTripStopBefore($trip_stop, $_REQUEST["add_stop_before"]);

	redirectTo("view_trip.php?id=" . $view["trip"]->getID());
}

function deleteStopAction() {
	$view = array();
	$view["trip"] = new Trip($_REQUEST["id"]);
	$view["trip"]->deleteTripStop($_REQUEST["stop_id"]);

	redirectTo("view_trip.php?id=" . $view["trip"]->getID());
}

function addTripAction() {
	if (!empty($_REQUEST["title"])) {
		$new_trip = new Trip();
		$new_trip->setTitle($_REQUEST["title"]);
		$new_trip->saveToDB();

		redirectTo("view_trip.php?id=" . $new_trip->getID());
	}
}

