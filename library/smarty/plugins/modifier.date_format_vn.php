<?php
/**
 * Smarty plugin
 * 
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty date_format_vn modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     date_format_vn<br>
 * Purpose:  format datestamps vietnamese<br>
 * Input:<br>
 *          - string: input date string
 *          - format: strftime format for output
 * 
 * @author Thinh Phan
 * @param string $string       input date string
 * @return string |void
 */
function smarty_modifier_date_format_vn($string)
{
	if(empty($string)) return '';
    $cur_time=time();
	$time_ago= $string;
	$time_elapsed = $cur_time - $time_ago;
	$seconds = $time_elapsed ;
	$days = round($time_elapsed / 86400 );
	
	//Days
	if($days==1)
	{
		return "Hôm qua ".date("h:i A",$time_ago);
	}
	elseif($days<1)
	{
		return "Hôm nay ".date("h:i A",$time_ago);
	}else{
		return date("d-m-Y, h:i A",$time_ago);
	}
} 

?>