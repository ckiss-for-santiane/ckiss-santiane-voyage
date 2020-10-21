<?php
use PHPUnit\Framework\TestCase;
require_once "/volume1/web/santiane_voyage/Models/Trip.class.php";
require_once "/volume1/web/santiane_voyage/Models/TripStop.class.php";
require_once "/volume1/web/santiane_voyage/Include/connect_database.php";

class UnitTest1 extends TestCase
{
    public function testAddAndRemoveTripStop()
    {
	// Je prends un voyage au hasard
	$all_trips = Trip::getAllTrips();
	$my_trip = $all_trips[0];

	// Combien d'etapes ?
	$nb_etapes = count($my_trip->getTripStops());

	// Ajout d'etape
	$new_id = $my_trip->addTripStopBefore(["destination" => 2, "modality" => 3]);

	// Combien d'etapes maintenant ?
	$this->assertSame(count($my_trip->getTripStops()), $nb_etapes + 1);

	$new_trip_stop = new TripStop($new_id);
	// Est-ce la bonne destination ?
	$this->assertSame($new_trip_stop->getDestinationID(), 2);
	// Est-ce la bonne modalite ?
	$this->assertSame($new_trip_stop->getModalityID(), 3);

	// Suppression d'etape
	$my_trip->deleteTripStop($new_id);

	// Combien d'etapes maintenant ?
	$this->assertSame(count($my_trip->getTripStops()), $nb_etapes);
    }
}

