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
 * LPs - Templates Table class
 */
class LpsTableTemplates extends JTable {

    var $id                         = null;
    var $name                       = null;
    var $description                = null;
    var $created                    = null;
    var $modified                   = null;
    var $modifiedby                 = null;
    var $published                  = null;
    var $layout                     = null;
    var $content                    = null;
    var $show_form_title            = null;
    var $form_container             = null;
    var $field_width                = null;
    var $field_size                 = null;
    var $field_labeling             = null;

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) 
    {
            parent::__construct('#__lps_templates', 'id', $db);
    }

}
