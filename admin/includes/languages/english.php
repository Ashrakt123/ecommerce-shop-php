<?php

	function lang($phrase) {

		static $lang = array(

			// Navbar Links

		'one'    => 'HOME',
        'two'    => 'CATEGORIES',
        'three'  => 'ITEM',
        'four'   => 'MEMBER',
		'five'   => 'STATISCS',
        'six'    => 'LOGS'


		);

		return $lang[$phrase];

	}