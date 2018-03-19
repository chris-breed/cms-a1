/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */


 
/**
*  Strip any illegal characters from input
*
*/
function validateIllegalChars(input) {
    if (!input) {
        return '';
    } else {
        if (input.match(/[|&;$%@"<>()+,]/g)) {
            //there is an illegal character in this string
            return input.replace(/[|&;$%@"<>()+,]/g, "");
        }         
    }

    return input;
}