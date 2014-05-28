<?php
/**
 * Smarty Extend
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier Extend
 *
 * Type:     modifier<br>
 * Name:     lower<br>
 * Purpose:  convert string to lowercase
 * @link http://Smarty.php.net/manual/en/Language.modifier.lower.php
 *          lower (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_lower($string)
{
    return strtolower($string);
}

?>
