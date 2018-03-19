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
 * LPs - Submission Values Table class
 */
class LpsTableSubmissionValues extends JTable {

    var $id                            = null;
    var $submission_id                 = null;
    var $field_id                      = null;
    var $value                         = null;

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) 
    {
            parent::__construct('#__lps_submission_values', 'id', $db);
    }

}
