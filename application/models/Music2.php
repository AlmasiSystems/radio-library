<?php

Zend_Loader::loadClass('Music');

class Tops extends Zend_Db_Table_Abstract {
    protected $_name = 'tops';
}

//Master model
class Music2 extends Music
{
    protected $_addForm;
    protected $_editForm;

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getAddForm()
    {
        if ($this->_addForm === null) {
            $this->_addForm = $this->buildAddForm();
        }
        
        return $this->_addForm;
    }
    
    public function getEditForm()
    {
        if ($this->_editForm === null) {
            $this->_editForm = $this->buildEditForm();
        }
        
        return $this->_editForm;
    }
    
    public function getFormHtml(HTML_QuickForm $form)
    {
        //change renderer for xhtml
        $renderer = new HTML_QuickForm_Renderer_Tableless();
			
        $form->accept($renderer);
        return $renderer->toHtml();
    }
    
    protected function buildAddForm()
    {
        // Zend 1.0.0 doesn't have Zend_Form so we are using quickform
        require_once('topspins.form.php');
        return new topSpinsAddForm(); 
    }
    
    protected function buildEditForm()
    {
        // Zend 1.0.0 doesn't have Zend_Form so we are using quickform
        require_once('topspins.form.php');
        return new topSpinsEditForm(); 
    }
    
    public function getTopByDate($date)
    {
        if ($date == '') {
            $date = date( 'Y-m-d', time() );
        }
        
        $table = new Tops();
        $db = $table->getAdapter();
        $select = $db->select();
        $select->from('tops')
               ->where('post_date <= ?', $date)
               ->order('id DESC')
               ->limit(1)
        ;
        
        $rows = $db->fetchAll($select);
        
        return $rows;
    }
	public function updateEdit($data)
    {
        if (is_array($data)){
			$post_date=$data['post_date'];
			unset($data['post_date']);
			$table = new Tops();
			$db = $table->getAdapter();
			$db->update('tops',$data,"post_date = '$post_date'");
			return true;
		}
    }
	public function updateAdd($data)
    {
        if (is_array($data)){
			$table = new Tops();
			$db = $table->getAdapter();
			$db->insert('tops',$data);
			return true;
		}
    }
	
}
