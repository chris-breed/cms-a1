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
 * LPs - Submissions Table class
 */
class LpsTableSubmissions extends JTable {

    var $id                        = null;
    var $form_id                   = null;
    var $created                   = null;
    var $user_ip                   = null;
    var $published                 = null;
    var $status                    = null;

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) 
    {
            parent::__construct('#__lps_submissions', 'id', $db);
    }

}
