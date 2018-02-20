<?php 

/*
*
* @package Give me that data 
* Text Domain: GMTD 
*
*/

namespace GMTD;

class Activate
{
	
	
	public function activate()
	{
		flush_rewrite_rules();
	}


}