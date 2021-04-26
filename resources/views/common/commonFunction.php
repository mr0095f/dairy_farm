<?php
	function years()
	{
		$years = array();
		for ($i=(int)date('Y'); $i >= 2005; $i--) 
		{ 
			array_push($years, $i);
		}
		return $years;
	}

	function months(){
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		return $months;
	}

	function days(){
		$days = array('Sun' => 'Sunday', 'Mon' => 'Monday', 'Tue' => 'Tuesday', 'Wed' => 'Wednesday', 'Thu' => 'Thursday', 'Fri' => 'Friday', 'Sat' => 'Saturday');
		return $days;
	}
?>