/**
 * @version     2.7
 * @package     com_lps
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

function initPagination(limitstart) {
    document.getElementById('lps-limitstart').value = limitstart;
    document.forms['LpsPaginationForm'].submit();
}