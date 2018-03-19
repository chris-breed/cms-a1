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
 * Submissions main model.
 */
class LpsModelSubmissions extends JModelAdmin
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
    public function getTable($type = 'Submissions', $prefix = 'LpsTable', $config = array())
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
        $sql = "SELECT s.*, 
                        u.name as submitter_name,
                        f.name as form_name 
                FROM `#__lps_submissions` as s
                LEFT JOIN `#__lps_forms` as f on f.id=s.form_id
                LEFT JOIN `#__users` as u on u.id=s.user_id";


        $where = array();

        //if we're filtering based on submission form
        if ($this->getState('lps-submissions-form-filter') !=''){
            $where[] = "s.form_id='".$this->getState('lps-submissions-form-filter')."'";
            //$sql .= " AND s.FormId='".$this->getState('submission_form_filter')."'";
        }        

        if (count($where) > 0) {
            $sql .= " WHERE ".implode(" AND ",$where);
        }

        $sql .= " GROUP BY s.id";

        $sql .= " ORDER BY s.created DESC";            
    
        $limitState = $this->getState('limit');
        $limitstartState = $this->getState('limitstart');
        if ($limitState) {
            $sql .= " LIMIT ".$limitstartState.", ".$limitState;
        }

        $db->setQuery($sql);
        $subs = $db->loadObjectList();
        $submissions = array();
        if (count($subs) > 0) {
            foreach($subs as $sub) {
                $values = $this->getFormSubmissionsValues($sub->id,$sub->form_id);
                $sub->submission_values = $values;
                $submissions[] = $sub;
            }
        } 

        return $submissions;
    }

    /**
    * get submission count from all forms
    * 
    * @return array of stdClass object
    */
    function getListItemPaginationCount() {

        $db = JFactory::getDBO();
        $sql = "SELECT s.*, 
                        u.name as submitter_name,
                        f.name as form_name 
                FROM `#__lps_submissions` as s
                LEFT JOIN `#__lps_forms` as f on f.id=s.form_id
                LEFT JOIN `#__users` as u on u.id=s.user_id";


        $where = array();

        //if we're filtering based on submission form
        if ($this->getState('lps-submissions-form-filter') !=''){
            $where[] = "s.form_id='".$this->getState('lps-submissions-form-filter')."'";
            //$sql .= " AND s.FormId='".$this->getState('submission_form_filter')."'";
        }        

        if (count($where) > 0) {
            $sql .= " WHERE ".implode(" AND ",$where);
        }

        $sql .= " GROUP BY s.id";

        $sql .= " ORDER BY s.created DESC";            

        $db->setQuery($sql);
        return count($db->loadObjectList());
    }

    function getSubmissionSortStatus() {
        $sql = '';
        if ( $this->getState('submission_list_ordering') && $this->getState('submission_list_direction') ) {
            $sql .= " ORDER BY ".$this->getState('submission_list_ordering')." ".$this->getState('submission_list_direction');
        }

        if ($sql !='') {
            return $sql;
        } else {    
            return false;
        }
    }

    /**
    * get the values of the submission data that was submitted into form
    *
    *
    */
    function getFormSubmissionsValues($submissionId,$formId) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_submission_values` WHERE `submission_id`=".$submissionId;
        $db->setQuery($sql);
        $values = $db->loadObjectList();
        $submissionValues = array();

        $ordering = LpsHelper::getFieldOrdering($formId);
        if ( (count($ordering) > 0) && (count($values) > 0) ) {
            foreach ($ordering as $key => $order) {
                $value = $this->getSubmissionValueFromObj($key,$values);
                if ($value) {
                    $value->field_name = LpsHelper::getFieldName($value->field_id);
                    $submissionValues[] = $value;
                }

            }
        }
    
        return $submissionValues;
    }

    function getSubmissionValueFromObj($fieldId,$values) {
        foreach ($values as $value) {
            if ($value->field_id == $fieldId) {
                return $value;
            }
        }
        return false;
    }

    public function store() {

        $input = JFactory::getApplication()->input;
        $datas = array();

        //Load calendar table class
        $table =& JTable::getInstance('LandingPages','LpsTable');        

        //get all applicable data vars
        if ($input->getString('lps-landing-pages-name') !="") {
            $data['name'] = $input->getString('lps-landing-pages-name');
        }  
        //get all applicable data vars
        if ($input->getString('lps-landing-pages-description') !="") {
            $data['description'] = $input->getString('lps-landing-pages-description');
        }        
        if (LpsHelper::isValueNumeric( $input->getInt('lps-landing-pages-published') )) {
            $data['published'] = $input->getInt('lps-landing-pages-published');
        }

        $user = JFactory::getUser();
        $data['modifiedby'] = $user->id;
        $data['modified'] = date('Y-m-d H:i:s');
        $data['created'] = date('Y-m-d H:i:s');

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
        $formFilter = $app->getUserStateFromRequest('lps-submissions-form-filter','lps-submissions-form-filter','');
        //$statusFilter = $app->getUserStateFromRequest('lps-submissions-status-filter','lps-submissions-status-filter','');

        //limits states
        $limit = $app->getUserStateFromRequest('lps-limit','lps-limit',10);
        $limitstart = $app->getUserStateFromRequest('lps-limitstart','lps-limitstart',0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0) ? (floor($limitstart / $limit) * $limit) : 0;
                
        //set states
        $this->setState('lps-submissions-form-filter',$formFilter);
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
        
    }

    function changeSubmissionStatus($id,$status) {
        $db = JFactory::getDBO();
        $sql = "UPDATE `#__lps_submissions` SET `status`='".$status."' WHERE `id`=".$id;
        $db->setQuery($sql);
        $db->execute();
    }

    function removeSubmissionItem($id) {
        $db = JFactory::getDBO();

        //remove any submission values from this form
        $sql = "DELETE FROM `#__lps_submission_values` WHERE `submission_id`=".$id;
        $db->setQuery($sql);
        $db->execute();  

        //remove leads
        $sql = "DELETE FROM `#__lps_leads` WHERE `submission_id`=".$id;
        $db->setQuery($sql);
        $db->execute();    
        
        //remove submission record
        $sql = "DELETE FROM `#__lps_submissions` WHERE `id`=".$id;
        $db->setQuery($sql);
        $db->execute();        

        return true;
    }

}