<?php
//QuickForm class loaded in bootstrap
//Zend_Loader::loadClass('Music2');

class topSpinsAddForm extends HTML_QuickForm
{
    function __construct($data = null, $action = "/music/topspins/", $button_value="Add Spin!")
    {
        parent::HTML_QuickForm('addTopSpins', 'post', $action);
        //remove for xhtml
        $this->removeAttribute('name');

        $this->setDefaults($data);

        //begin elements
        $this->addElement('header', '', 'Add New Entry');
        $this->addElement('text', 'post_date', 'Date');
        $this->addElement('textarea', 'top_5', 'Top 5', array('cols'=>63, 'rows'=>10));
        $this->addElement('textarea', 'top_30', 'Top 30', array('cols'=>63, 'rows'=>35));
        
        $this->addElement('submit', 'add', $button_value);
    }
}

class topSpinsEditForm extends HTML_QuickForm
{
    function __construct($data = null, $action = "/music/topspins/", $button_value="Update Spin!")
    {
        parent::HTML_QuickForm('editTopSpins', 'post', $action);
        //remove for xhtml
        $this->removeAttribute('name');

        //begin elements
        $this->addElement('header', '', 'Edit Spin Entry');
        $this->addElement('text', 'post_date', 'Date');
        $this->addElement('hidden', 'id');
        $this->addElement('submit', 'lookup', 'Lookup Date');
        $this->addElement('textarea', 'top_5', 'Top 5', array('cols'=>63, 'rows'=>10));
        $this->addElement('textarea', 'top_30', 'Top 30', array('cols'=>63, 'rows'=>35));
        

        $this->addElement('submit', 'edit', $button_value);
    }
}
