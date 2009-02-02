<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Kasper Sk�rh�j
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 *
 * @coauthor	Kasper Skaarhoj <kasper@typo3.com>
 */


require_once(PATH_t3lib.'class.t3lib_befunc.php');


/**
 *
 * @author	Kasper Skaarhoj <kasper@typo3.com>
 * @package realurl
 * @subpackage tx_realurl
 */
class tx_tagpack_realurl {	
	function main($params, $ref)	{
		$TSconfig = t3lib_BEfunc::getPagesTSConfig($GLOBALS['TSFE']->id);
		$getTagsFromPid = $TSconfig['tx_tagpack_tags.']['getTagsFromPid'];
		$getTagsFromPid = $getTagsFromPid ? $getTagsFromPid : 0;
		if ($params['decodeAlias'])	{
		    return $this->alias2id($params['value']);			
		} else {
		    return $this->id2alias($params['value'],$getTagsFromPid);
		}
	}
	function id2alias($value,$getTagsFromPid)	{
		$valueArray = t3lib_div::trimExplode(',',$value);
		if(count($valueArray) && $value) {
		    $valueList = '';
		    foreach($valueArray as $uid) {
			if($uid && $uid!=t3lib_div::_GP('tx_tagpack_pi3_removeItems')) {
			    $name = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('name','tx_tagpack_tags','uid='.$uid.' AND pid='.$getTagsFromPid);
			    if(!$valueArray[$name[0]['name']]) {
				$valueArray[$name[0]['name']]=1;
				$valueList .= $valueList ? '_'.$name[0]['name'] : $name[0]['name'];
			    }
			}
		    }
		}
		if($valueList) {
		    return strtolower(str_replace(' ','-',$valueList)).'_'.$getTagsFromPid;
		} else {
		    return '';
		}
	}
	function alias2id($value)	{
		$valueArray = t3lib_div::trimExplode('_',$value);
		$getTagsFromPid = array_pop($valueArray);
		if(count($valueArray)) {
		    foreach($valueArray as $name) {
			if($name) {
			    $name = str_replace('-',' ',$name);
			    $uid = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid','tx_tagpack_tags','name LIKE \''.$name.'\' AND pid='.$getTagsFromPid);
			    $valueList .= $valueList ? ','.$uid[0]['uid'] : $uid[0]['uid'];
			}
		    }
		}
		return $valueList;
	}
}

?>