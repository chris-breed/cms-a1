<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting submissions
 */
class LpsModelSubmissions extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function storeSubmission($lpId,$formId) {

        //Load calendar table class
        $table =& JTable::getInstance('Submissions','LpsTable');        

        $data = array();
        $data['lp_id'] = $lpId;
        $data['form_id'] = $formId;
        $data['created'] = date('Y-m-d H:i:s');
        $data['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $data['user_id'] = JFactory::getUser()->id;

        // Bind the data to the table
        if (!$table->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Make sure the record is valid
        if (!$table->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
     
        // Store the web link table to the database
        if (!$table->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        $db = $table->getDBO();
        return $db->insertid();
    }

    public function storeSubmissionValue($submissionId,$fieldId,$value) {

        $input = JFactory::getApplication()->input;
        $data = array();

        //Load calendar table class
        $table =& JTable::getInstance('SubmissionValues','LpsTable');        

        $data['submission_id'] = $submissionId;
        $data['field_id'] = $fieldId;
        $data['value'] = $value;

        // Bind the data to the table
        if (!$table->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Make sure the record is valid
        if (!$table->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
     
        // Store the web link table to the database
        if (!$table->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
    }


    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

    		if(empty($ordering)) {
    			$ordering = 'a.ordering';
    		}

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /*

            $email = new stdClass;
            $email->to = $form->admin_email_from;
            $email->subject = $form->admin_email_subject
            $email->body = $form->admin_email_text
            $email->from = $form->admin_email_from;
            $email->from_name = $form->admin_email_from_name;
            $email->cc = $form->admin_email_cc;
            $email->bcc = $form->admin_email_bcc;
            $email->replyto = $form->admin_email_reply_to;

    */
    function sendEmail($email) {

        $mail = JFactory::getMailer();
        $mail->isHTML(true);

        //use the user entered sender name and email, if not entered use info from configuration file
        if ( ($email->from !="") && ($email->from_name !="") ) {
            $sender = array( 
                $email->from,
                $email->from_name 
            );
        } else {
            $mainConfig = JFactory::getConfig();
            $sender = array( 
                $mainConfig->get( 'config.mailfrom' ),
                $mainConfig->get( 'config.fromname' ) 
            );
        }

        $mail->setSender($sender);
        $mail->addRecipient($email->to);
        $mail->setSubject($email->subject);
        $mail->setBody($email->body);

        if ($email->replyto !="") {
            $mail->addReplyTo($email->replyto);
        }

        if ($email->cc !="") {
            $mail->addCC($email->cc);
        }

        if ($email->bcc !="") {
            $mail->addBCC($email->bcc);
        }

        if (!$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }

}
