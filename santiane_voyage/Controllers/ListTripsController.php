<?php

function defaultAction() {
	$view = array();

	$view["tripsList"] = Trip::getAllTrips();

	return $view;
}

