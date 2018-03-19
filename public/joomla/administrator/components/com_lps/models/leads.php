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

jimport('joomla.application.component.modeladmin');

/**
 * Leads main model.
 */
class LpsModelLeads extends JModelAdmin
{
    /**
     * @var     string  The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_LPS';


    /**
     * Returns a reference to the Table object, always creating it.
     *
     * @param   type    The table type to instantiate
     * @param   string  A prefix for the table class name. Optional.
     * @param   array   Configuration array for model. Optional.
     * @return  JTable  A database object
     * @since   1.6
     */
    public function getTable($type = 'Leads', $prefix = 'LpsTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array   $data       An optional array of data for the form to interogate.
     * @param   boolean $loadData   True if the form is to load its own data (default case), false if not.
     * @return  JForm   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Initialise variables.
        $app    = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_lps.edit', 'edit', array('control' => 'jform', 'load_data' => $loadData));
        
        
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed   The data for the form.
     * @since   1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_lps.edit.edit.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            
        }

        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param   integer The id of the primary key.
     *
     * @return  mixed   Object on success, false on failure.
     * @since   1.6
     */
    public function getItem($pk = null)
    {
        if ($item = parent::getItem($pk)) {

            //Do any procesing on fielDIRECTORY_SEPARATOR here if needed

        }

        return $item;
    }

    /*public function getListItems() {
        $db = JFactory::getDBO();

        $sql = "SELECT * FROM `#__lps_submissions`";

        //filter by name
        //echo $this->getState('lps_landing_pages_search');
        if ($this->getState('lps_landing_pages_search')){
            $sql .= " WHERE `name` LIKE '%".$this->getState('lps_landing_pages_search')."%'";
        }

        $db->setQuery($sql);
        return $db->loadObjectList();
    } */



    /**
    * get all of a users form submissions from all forms
    * 
    * @return array of stdClass object
    */
    function getListItems() {

        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_leads`";

        $where = array();
        //if we're filtering based on submission status
        if ($this->getState('lps-leads-status-filter') !=''){
            $where[] = "`status`='".$this->getState('lps-leads-status-filter')."'";
            //$sql .= " AND s.status='".$this->getState('submission_status_filter')."'";
        }

        if (count($where) > 0) {
            $sql .= " WHERE ".implode(" AND ",$where);
        } 

        $sql .= " ORDER BY created DESC";

        $limitState = $this->getState('limit');
        $limitstartState = $this->getState('limitstart');
        if ($limitState) {
            $sql .= " LIMIT ".$limitstartState.", ".$limitState;
        }

        $db->setQuery($sql);
        return $db->loadObjectList();

    }

    /**
    * get all of a users form submissions from all forms
    * 
    * @return array of stdClass object
    */
    function getListItemPaginationCount() {

        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_leads`";

        $where = array();
        //if we're filtering based on submission status
        if ($this->getState('lps-leads-status-filter') !=''){
            $where[] = "`status`='".$this->getState('lps-leads-status-filter')."'";
            //$sql .= " AND s.status='".$this->getState('submission_status_filter')."'";
        }
        
        if (count($where) > 0) {
            $sql .= " WHERE ".implode(" AND ",$where);
        } 

        $db->setQuery($sql);
        return count($db->loadObjectList());

    }

    public function store($email,$submissionId) {

        $data = array();

        //get all applicable data vars
        $data['submission_id'] = $submissionId;
        $data['created'] = date('Y-m-d H:i:s');
        $data['email'] = $email;
        $data['published'] = 1;

        //Load leads table class
        $table =& JTable::getInstance('Leads','LpsTable');     

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

        return true;
    }

    /**
     * Populate user state requests
     */
    function populateState(){

        $app = JFactory::getApplication();

        //filter states
        //$formFilter = $app->getUserStateFromRequest('lps-submissions-form-filter','lps-submissions-form-filter','');
        $statusFilter = $app->getUserStateFromRequest('lps-leads-status-filter','lps-leads-status-filter','');

        //limits states
        $limit = $app->getUserStateFromRequest('lps-limit','lps-limit',10);
        $limitstart = $app->getUserStateFromRequest('lps-limitstart','lps-limitstart',0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0) ? (floor($limitstart / $limit) * $limit) : 0;
                
        //set states
        //$this->setState('lps-submissions-form-filter',$formFilter);
        $this->setState('lps-leads-status-filter',$statusFilter);
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
        
    }


    function changeLeadStatus($id,$status) {
        $db = JFactory::getDBO();
        $sql = "UPDATE `#__lps_leads` SET `status`='".$status."' WHERE `id`=".$id;
        $db->setQuery($sql);
        $db->execute();
    }

    function removeLeadItem($id) {
        $db = JFactory::getDBO();

        //remove leads
        $sql = "DELETE FROM `#__lps_leads` WHERE `id`=".$id;
        $db->setQuery($sql);
        $db->execute();    
    
        return true;
    }

}