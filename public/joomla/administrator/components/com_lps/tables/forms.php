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
 * LPs - Forms Table class
 */
class LpsTableForms extends JTable {

    var $id                                 = null;
    var $name                               = null;
    var $description                        = null;
    var $published                          = null;
    var $return_url                         = null;
    var $show_thank_you                     = null;
    var $thank_you_message                  = null;
    var $user_email_text                    = null;
    var $user_email_to                      = null;
    var $user_email_cc                      = null;
    var $user_email_bcc                     = null;
    var $user_email_from                    = null;
    var $user_email_reply_to                = null;
    var $user_email_from_name               = null;
    var $user_email_subject                 = null;
    var $user_email_mode                    = null;
    var $user_email_attach                  = null;
    var $user_email_attach_file             = null;
    var $admin_email_text                   = null;
    var $admin_email_to                     = null;
    var $admin_email_cc                     = null;
    var $admin_email_bcc                    = null;
    var $admin_email_from                   = null;
    var $admin_email_reply_to               = null;
    var $admin_email_from_name              = null;
    var $admin_email_subject                = null;
    var $admin_email_mode                   = null;
    var $meta_title                         = null;
    var $meta_desc                          = null;
    var $meta_keywords                      = null;


    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) 
    {
            parent::__construct('#__lps_forms', 'id', $db);
    }

}
