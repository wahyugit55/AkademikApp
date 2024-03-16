<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbarsideleft = array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => '<i class="fa fa-dashboard "></i>'
		),
		
		array(
			'path' => 'siswa', 
			'label' => 'Siswa', 
			'icon' => '<i class="fa fa-user "></i>'
		),
		
		array(
			'path' => 'kota', 
			'label' => 'Kota', 
			'icon' => '<i class="fa fa-building "></i>'
		)
	);
		
	
	
			public static $jenkel = array(
		array(
			"value" => "1", 
			"label" => "Laki - Laki", 
		),
		array(
			"value" => "2", 
			"label" => "Perempuan", 
		),);
		
}