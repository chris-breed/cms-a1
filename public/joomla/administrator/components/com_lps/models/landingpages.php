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
 * Landing pages main model.
 */
class LpsModelLandingPages extends JModelAdmin
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
    public function getTable($type = 'LandingPages', $prefix = 'LpsTable', $config = array())
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

    public function getListItems() {
        $db = JFactory::getDBO();

        $sql = "SELECT * FROM `#__lps_landing_pages`";

        //filter by name
        //echo $this->getState('lps_landing_pages_search');
        if ($this->getState('lps_landing_pages_search')){
            $sql .= " WHERE `name` LIKE '%".$this->getState('lps_landing_pages_search')."%'";
        }

        $db->setQuery($sql);
        return $db->loadObjectList();
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

        //search filter states
        $search = $app->getUserStateFromRequest('lps_landing_pages_search','lps-landing-pages-search','');

        //limits states
        $limit = $app->getUserStateFromRequest('lps_landing_pages_limit','lps_landing_pages_limit',10);
        $limitstart = $app->getUserStateFromRequest('lps_landing_pages_limitstart','lps_landing_pages_limitstart',0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0) ? (floor($limitstart / $limit) * $limit) : 0;
                
        //set states
        $this->setState('lps_landing_pages_search', $search);
        $this->setState('lps_landing_pages_limit', $limit);
        $this->setState('lps_landing_pages_limitstart', $limitstart);
        
    }

    function performBatchAction() {
        $input = JFactory::getApplication()->input; //get the request data

        if ( ($batchActions = $input->getString('art-calendar-batch-actions')) && 
             ($selectedIds = $input->getString('art-calendar-batch-item-ids')) ) {

            $selectedIds = json_decode($selectedIds);
            $batchActions = json_decode($batchActions);

            if ( (count($selectedIds) > 0) && (count($batchActions) > 0) ) {

                $db = JFactory::getDBO();
                $sql = "UPDATE `#__artcalendar_calendar` SET ";
                $set = array();
                $where = " WHERE `id` IN (".implode(',',$selectedIds).")";

                if (in_array('published',$batchActions)) {
                    $set[] = '`published`='.$input->getString('art-calendar-batch-publishing');
                }
                if (in_array('showTitle',$batchActions)) {
                    $set[] = '`title`='.$input->getString('art-calendar-batch-show-title');
                }
                if (in_array('showButtons',$batchActions)) {
                    $set[] = '`buttons`='.$input->getString('art-calendar-batch-show-buttons');
                }
                if (in_array('showTime',$batchActions)) {
                    $set[] = '`showTime`='.$input->getString('art-calendar-batch-show-time');
                }
                if (in_array('access',$batchActions)) {
                    $set[] = '`access`='.$input->getString('art-calendar-batch-access');
                }
                if (in_array('year',$batchActions)) {
                    $set[] = '`year`='.$input->getString('art-calendar-batch-start-year');
                }
                if (in_array('month',$batchActions)) {
                    $set[] = '`month`='.$input->getString('art-calendar-batch-start-month');
                }
                if (in_array('day',$batchActions)) {
                    $set[] = '`weekStart`='.$input->getString('art-calendar-batch-start-day');
                }

                $db->setQuery( $sql.implode(',',$set).$where );
                $db->execute();
                
                return true;

            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    function togglePublishing($state,$landingPageId) {
        $db = JFactory::getDBO();
        $sql = "UPDATE `#__lps_landing_pages` SET `published`=".$state." WHERE `id`=".$landingPageId;
        $db->setQuery($sql);
        $db->execute();
        return true;
    }

    function removeLandingPageItem($landingPageId) {
        $db = JFactory::getDBO();
        $sql = "DELETE FROM `#__lps_landing_pages` WHERE `id`=".$landingPageId;
        $db->setQuery($sql);
        $db->execute();
        return true;
    }

    function editLandingPageItem() {

        $db = JFactory::getDBO();
        $input = JFactory::getApplication()->input;
        $set = array();

        $sql = "UPDATE `#__lps_landing_pages` ";

        if ($landingPageId = $input->getInt('lps-landing-pages-edit-item-id')) {

        } else {
            return false;
        }
        if ($input->getString('lps-landing-pages-edit-name') !="") {
            $set[] = "`name`='".$input->getString('lps-landing-pages-edit-name')."'";
        }        
        if (LpsHelper::isValueNumeric( $input->getInt('lps-landing-pages-edit-published') )) {
            $set[] = "`published`=".$input->getInt('lps-landing-pages-edit-published');
        }
        if ($input->getString('lps-landing-pages-edit-description') !="") {
            $set[] = "`description`='".$input->getString('lps-landing-pages-edit-description')."'";
        }

        
        if (count($set) > 0) {
            $sql .= "SET ".implode(",",$set)." WHERE `id`=".$landingPageId;
            $db->setQuery($sql);
            $db->execute();
        } else {
            return false;
        }

        return true;        
    }

    function associateTemplate($templateId,$landingPageId) {
        $db = JFactory::getDBO();
        if ( ($templateId > 0) && ($landingPageId > 0) ) {
            $sql = "UPDATE `#__lps_landing_pages` SET `template_id`=".$templateId." WHERE `id`=".$landingPageId;
            $db->setQuery($sql);
            $db->execute();
            return true;
        } else {
            return false;
        }
    }

    function associateForm($formId,$landingPageId) {
        $db = JFactory::getDBO();
        if ( ($formId > 0) && ($landingPageId > 0) ) {
            $sql = "UPDATE `#__lps_landing_pages` SET `form_id`=".$formId." WHERE `id`=".$landingPageId;
            $db->setQuery($sql);
            $db->execute();
            return true;
        } else {
            return false;
        }
    }

}