<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('rvl_show_error'))
{
	/**
	 * Error Handler
	 *
	 * This function lets us invoke the exception class and
	 * display errors using the standard error template located
	 * in application/views/errors/error_general.php
	 * This function will send the error page directly to the
	 * browser and exit.
	 *
	 * @param	string
	 * @param   array
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function rvl_show_error($message, $datas=array(), $status_code = 500, $heading = 'An Error Was Encountered')
	{
		$datas['gotime'] = isset($datas['gotime']) ? $datas['gotime'] : '10';
		$datas['gourl'] = isset($datas['gourl']) ? $datas['gourl'] : site_url();
		
		$status_code = abs($status_code);
		if ($status_code < 100)
		{
			$exit_status = $status_code + 9; // 9 is EXIT__AUTO_MIN
			if ($exit_status > 125) // 125 is EXIT__AUTO_MAX
			{
				$exit_status = 1; // EXIT_ERROR
			}
			$status_code = 500;
		}
		else
		{
			$exit_status = 1; // EXIT_ERROR
		}

		$_error =& load_class('Exceptions', 'core');
		$_error_template = ( isset($datas['template']) && gettype($datas['template']) == 'string') ? $datas['template'] : 'rvl_error_general';		
		echo $_error->my_show_error($heading, $datas, $message, $_error_template, $status_code);
		exit($exit_status);
	}
}