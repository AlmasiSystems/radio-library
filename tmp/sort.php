<?php
    var_dump($_POST);
?>

<html>
<head>
<title>Edit</title>
<style type="text/css">.html_quickform_sorter_ul li{margin:2px;cursor:move;}
.html_quickform_sorter_ul img{border:1px dashed black;}</style>
<script src="prototype.js" type="text/javascript"></script>
<script src="effects.js" type="text/javascript"></script>
<script src="dragdrop.js" type="text/javascript"></script>
<script src="controls.js" type="text/javascript"></script>
</head>
<body><span style="color: red;"></span>
<form action="" method="post" name="admin" id="admin" enctype="multipart/form-data">

<h1>Edit</h1>
	<input name="edit_gallery_url" value="" type="hidden">
<input value="a:5:{i:2;s:9:&quot;index.jpg&quot;;i:3;s:24:&quot;rectangle_and_square.jpg&quot;;i:4;s:8:&quot;blob.jpg&quot;;i:5;s:8:&quot;pine.jpg&quot;;i:6;s:16:&quot;checkerboard.jpg&quot;;}" name="sortorder_old" type="hidden">
<input value="1048576" name="MAX_FILE_SIZE" type="hidden">
<input value="/bluetest/sections/gallery" name="_url" type="hidden">
<input value="middle_content" name="_template_var" type="hidden">
<input value="47" name="id" type="hidden">
<input value="bluecms_singleeditor" name="bluecms_singleeditor" type="hidden">

<table id="qfOuterTable" border="0">
<tbody><tr>
		<td style="white-space: nowrap; background-color: rgb(204, 204, 204);" colspan="2" align="left" valign="top"><b>Select Record</b></td>
	</tr>

	<tr>
		<td align="right" valign="top"><b></b></td>
		<td align="left" valign="top"><select name="record"><option value="-1">  --- Select Record --- </option><option value="47" selected="selected">Test_Gallery</option></select><input name="btn" value="GO" type="submit"><input name="btn" value="New" type="submit"></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; background-color: rgb(204, 204, 204);" colspan="2" align="left" valign="top"><b>Edit Gallery</b></td>
	</tr>

	<tr>
		<td align="right" valign="top"><b>Name:</b></td>
		<td align="left" valign="top"><input name="name" value="Test_Gallery" type="text"></td>
	</tr>
	<tr>
		<td align="right" valign="top"><b>Drag thumbnails to order:</b></td>
		<td align="left" valign="top"><script type="text/javascript" language="javascript">
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
</script><input name="sortorder" value="2,3,4,5,6" type="hidden"><ul id="sorter_sortorder" class="html_quickform_sorter_ul" style="list-style-type: none; list-style-image: none; list-style-position: outside;"><li style="position: relative;" id="sortorder_2"><img alt="index.jpg" src="edit_gallery_files/index.jpg" width="75">

                                                        <label for="sortorder_delete_2">
                                                        <input value="2" name="sortorder_delete_2" type="checkbox">Delete</label></li><li style="position: relative;" id="sortorder_3"><img alt="rectangle_and_square.jpg" src="edit_gallery_files/rectangle_and_square.jpg" width="75">
                                                        <label for="sortorder_delete_3">
                                                        <input value="3" name="sortorder_delete_3" type="checkbox">Delete</label></li><li style="position: relative;" id="sortorder_4"><img alt="blob.jpg" src="edit_gallery_files/blob.jpg" width="75">
                                                        <label for="sortorder_delete_4">
                                                        <input value="4" name="sortorder_delete_4" type="checkbox">Delete</label></li><li style="position: relative;" id="sortorder_5"><img alt="pine.jpg" src="edit_gallery_files/pine.jpg" width="75">
                                                        <label for="sortorder_delete_5">

                                                        <input value="5" name="sortorder_delete_5" type="checkbox">Delete</label></li><li style="position: relative;" id="sortorder_6"><img alt="checkerboard.jpg" src="edit_gallery_files/checkerboard.jpg" width="75">
                                                        <label for="sortorder_delete_6">
                                                        <input value="6" name="sortorder_delete_6" type="checkbox">Delete</label></li></ul>
<script type="text/javascript" language="javascript">
        Sortable.create("sorter_sortorder",  {containment:["sorter_sortorder"], onChange: function(element){getOrder("sortorder");}});
</script></td>
	</tr>
	<tr>
		<td align="right" valign="top"><b>Check to regenerate thumbnails:</b></td>

		<td align="left" valign="top"><input name="thumbs" value="1" id="qf_aa0900" type="checkbox"></td>
	</tr>
	<tr>
		<td align="right" valign="top"><b>Upload New File:</b></td>
		<td align="left" valign="top"><input name="upload_file" type="file"></td>
	</tr>
	<tr>
		<td align="right" valign="top"><b> </b></td>

		<td align="left" valign="top"></td>
	</tr>
	<tr>
		<td align="right" valign="top"><b></b></td>
		<td align="left" valign="top"><input name="btn" value="Save" type="submit"><input name="btn" value="Delete" type="submit"></td>
	</tr></tbody></table>
</form></body></html>