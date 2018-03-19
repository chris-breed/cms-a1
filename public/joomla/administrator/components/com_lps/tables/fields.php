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
 * LPs - Fields Table class
 */
class LpsTableFields extends JTable {

    var $id                     = null;
    var $form_id                = null;
    var $type_id                = null;
    var $order                  = null;
    var $published              = null;


    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) 
    {
            parent::__construct('#__lps_fields', 'id', $db);
    }

}
