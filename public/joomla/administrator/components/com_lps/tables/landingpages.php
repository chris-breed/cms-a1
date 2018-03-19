<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined('_JEXEC') or die; 

/**
 * LPs - Landing Pages Table class
 */
class LpsTableLandingPages extends JTable {

    var $id                         = null;
    var $name                       = null;
    var $description                = null;
    var $created                    = null;
    var $modified                   = null;
    var $modifiedby                 = null;
    var $published                  = null;
    var $template_id                = null;

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) 
    {
            parent::__construct('#__lps_landing_pages', 'id', $db);
    }

}
