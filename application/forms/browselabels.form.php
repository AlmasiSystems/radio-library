<?php
//QuickForm class loaded in bootstrap

class browseLabelsForm extends HTML_QuickForm
{
    function browseLabelsForm($action) {
		$form_attr = NULL;

        parent::HTML_QuickForm('browselabels', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');
     	
		$sortby[] = HTML_QuickForm::createElement('select', 'sortby', 'Sort',
		 											array('label_name' => 'Alphabetically', 'add_datetime' => 'Add Date/Time'));
		$sortby[] = HTML_QuickForm::createElement('select', 'asc_desc', '', array('DESC' => 'Descending', 'ASC' => 'Ascending'));
		$sortby[] = HTML_QuickForm::createElement('submit', 'submit', 'Go');
		$form->addGroup($sortby, 'Sort', null, '&nbsp;');

    }
	
}