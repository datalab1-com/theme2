<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class CustomHelper extends Helper {

function cmsFormat($text)
{	
	// change newlines to br's
	$lines = explode("\r\n", $text);
	$cnt = count($lines);
	$ret = '';
	$ulCnt = 0;
	$ulOpen = '<ul>';
	$ulClose = '</ul>';
	$liOpen = '<li>';
	$liClose = '</li>';
	
	//$sw = $this->startsWith('one two three', 'one');
	//die('sw=' . $sw);
	
	for ($i = 0; $i < $cnt; $i++)
	{	
		$line = $lines[$i];
		
		if ($this->startsWith($line, '* '))
		{
			if ($ulCnt++ == 0)
			{
				$ret .= $ulOpen;
			}

			if ($ulCnt > 0)
			{
				$t = substr($line, 2);	// peel off the leading '* '
				
				$ret .= '<li class="starBullet">' . $t . $liClose;
			}
		}
		else
		{
			if ($ulCnt > 0)
			{
				$ulCnt = 0;
				$ret .= $ulClose;
			}

			if ($this->startsWith($line, 'STEP ') || $this->startsWith($line, '<strong>STEP '))
			{
				$ret .= '<div class="stepLine">' . $line . '</div>';
			}
			else
			{
				$ret .= $line;
				
				if ($cnt > 1)
					$ret .= "<br/>";				
			}					
		}
	}
	
	if ($ulCnt > 0)
	{
		$ulCnt = 0;
		$ret .= $ulClose;
	}	
		
	// change "* " to ul's
	
	return $ret;
}

function startsWith($text, $pattern)
{
	$ret = false;
	
	//echo '<p>' . strpos($text, $pattern) . '</p>';
	if (strpos($text, $pattern) === 0)
	{
		$ret = true;
	}
	
	return $ret;
}

function getIntro($text, $maxChars, $maxLines, &$trimmed)
{	
	$trimmed = false;

	//
	// trim by length
	//
	if (strlen($text) > $maxChars)
	{
		$text = substr($text, 0, $maxChars);			
		
		$trimmed = true;
	}

	//
	// trim by number of lines
	//
	$lines = explode("\r\n", $text);

	if (count($lines) > $maxLines)
	{
		$text = '';
		
		for ($i = 0; $i < $maxLines; $i++)
		{
			$text .= $lines[$i];
			$text .= "\r\n";
		}
		
		$trimmed = true;
	}
	
	return $text;
}

function getArrayNumber($array, $key)
{	
	$ret = 0.00;
	
	if (array_key_exists($key, $array))
	{
		$ret = $array[$key];
	}
	
	return $ret;
}

function getDollars($amount)
{	
	$ret = '';
	
	if (intval($amount) != 0) 
	{
		$ret = '$' . (intval($amount) / 100.0);
	}
	else
	{
		$ret = '';
	}
	
	return $ret;
}

public $fakeemail = array(
  'yopmail.com'
, 'mail.com'
);

function getDate($time)
{	
	$ret = '';
		
	if (strlen($time) > 0 && $time != '0000-00-00 00:00:00')
		$ret = substr($time, 0, 10);
	
	return $ret;
}

public function getPublicIp($ip)
{
	$ret = $this->GetPrivateIp($ip);
		
	return $ret;
}

public function GetPrivateIp($ip)
{
	$ret = $ip;
	
	if (strpos($ip, '10.0.21.11') !== false)
		$ret = 'Aff Register';
	else if (strpos($ip, '10.0.17.11') !== false)
		$ret = 'Mobile';
	else if (strpos($ip, '10.') !== false)
		$ret = $ip;
	else if (strpos($ip, '172.') !== false)
		$ret = '';
	else if (strpos($ip, '192.') !== false)
		$ret = '';
	else if (strpos($ip, 'localhost') !== false)
		$ret = '';
	
	return $ret;
}

public function isPrivateIp($ip)
{
	$ret = false;
	
	if (strpos($ip, '10.') !== false)
		$ret = true;
	else if (strpos($ip, '172.') !== false)
		$ret = true;
	else if (strpos($ip, '192.') !== false)
		$ret = true;
	else if (strpos($ip, 'localhost') !== false)
		$ret = true;
	
	return $ret;
}

public function getBoolText($value, $text)
{
	$ret = '';
	
	if ($this->isTrue($value))
		$ret = $text;
	
	return $ret;
}

public function isTrue($value)
{
	$ret = false;
	
	if (isset($value))
	{
		if (intval($value) == 1)
			$ret = 'Yes';
		else if (strtolower($value) == 'true')
			$ret = 'Yes';		
	}
	
	return $ret;
}

public function getYesNo($value)
{
	$ret = 'No';

	if ($this->isTrue($value))
		$ret = 'Yes';
			
	return $ret;
}

}
