<?php
require_once("HTML/QuickForm/input.php");
/**
*For this class to work, prototype and scriptaculous (see http://script.aculo.us) must be included.
*in blueCMS, call to method getJsIncludes() will return
*<script src="' . BLUECMS_WEBROOT . 'bluecms/jsapps/prototype/prototype.js" type="text/javascript"></script>
*<script src="' . BLUECMS_WEBROOT . 'bluecms/jsapps/scriptaculous/effects.js" type="text/javascript"></script>
*<script src="' . BLUECMS_WEBROOT . 'bluecms/jsapps/scriptaculous/dragdrop.js" type="text/javascript"></script>
*<script src="' . BLUECMS_WEBROOT . 'bluecms/jsapps/scriptaculous/controls.js" type="text/javascript"></script>
*
*Your setup may vary...
*/
class HTML_QuickForm_Sorter extends HTML_QuickForm_input
{
     var $_html = '';
    /**
    * Class constructor
    * 
    * @param     string    $elementName    (optional)Input field name attribute
    * @param     string    $elementLabel   (optional)Input field label
    * @param     mixed     $attributes       (optional) array 
    * @return    void
    */
    function HTML_QuickForm_Sorter($elementName=null, $elementLabel=null, $attributes=null)
    {        
        HTML_QuickForm_input::HTML_QuickForm_input($elementName, $elementLabel, $attributes);
        $this->_persistantFreeze = true;
    }
    function getJsIncludes($dir = '')
    {
        if(empty($dir))
            $dir = BLUECMS_WEBROOT . 'bluecms/jsapps/scriptaculous/';
        $js='<script src="' . $dir . 'prototype.js" type="text/javascript"></script>
        <script src="' . $dir . 'effects.js" type="text/javascript"></script>
        <script src="' . $dir . 'dragdrop.js" type="text/javascript"></script>
        <script src="' . $dir . 'controls.js" type="text/javascript"></script>';
        return($js);
    }
    function toHTML()
    {
        return($this->_html);
    }
    
    /**
    *Function called by quickform.
    *$values is array of form (key1=>value1, key2=>value2...) where keyX is integer and array reflects current order
    */
    function setValue($values)
    {        
        if(is_array($values))
        {
            if(! defined('HTML_QUICKFORM_SORTER_JS'))
            {
                define('HTML_QUICKFORM_SORTER_JS', true);
                $js =<<<JS
<script type="text/javascript" language="javascript">
function getOrder(id)
{
    var ul = document.getElementById('sorter_' + id);
    var order = '';
    var ar;
    for(var i=0;i<ul.childNodes.length;i++)
    {
        ar = ul.childNodes[i].id.split('_');
        if(order.length>0)
            order = order + "," + ar[ar.length-1];
        else 
            order = ar[ar.length-1];            
    }
    document.forms[0].elements[id].value = order;
}
</script>
JS;
            $this->_html .= $js;
        }
        $html = &$this->_html;
        $name = $this->_attributes['name'];
        $this->_html .= '<input type="hidden" name="' . $name . '" value="' . implode(",",array_keys($values)) . '">';
        $this->_html .= '<ul id="sorter_' . $name . "\" class=\"html_quickform_sorter_ul\" style=\"list-style:none;\">\n";
        foreach($values as $k => $v)
        {
            $this->_html .= '<li id="' . $name . '_' . $k . '">' . $v . "</li>\n";
        }
        $this->_html .="</ul>\n";
        $this->_html .= '<script type="text/javascript" language="javascript">
        Sortable.create("sorter_' . $this->_attributes['name'] . '",  {containment:["sorter_' . $this->_attributes['name']  . '"], onChange: function(element){getOrder("' . $name. '");}});
</script>';

        }
    }
}
?>
