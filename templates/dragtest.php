<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Draggable + Sortable</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  <style>
  ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
  li { margin: 5px; padding: 5px; width: 150px; }
  </style>
  <script>
  
$(document).ready(function(){
    $('#sortable').sortable({
        update: function() {
            var stringDiv = "";
            $("#sortable").children().each(function(i) {
                var li = $(this);
                stringDiv += " " + li.attr("name");
            });

            $.ajax({
                type: "POST",
                url: "updateOrder.php",
                data: {order: stringDiv}
            }); 
        }
    });
    $( "#draggable" ).draggable({
      connectToSortable: "#sortable",
      revert: "true"
    }); 
    $( "#sortable" ).disableSelection();    
});

  </script>
</head>
<body>
 
<ul>
  <li id="draggable" class="ui-state-highlight" name="newsys1">Drag me down</li>
</ul>

<ul id="sortable">
<?php
require('../inc/db.php');
$db = new \labmanager\db();
$devorder = $db->querySingle('SELECT deviceorder FROM racks WHERE id=2');
$orderArray = explode(" ", $devorder);
unset($orderArray[0]);
foreach ($orderArray as $id) {
	echo '<li class="ui-state-default" name="'. $id . '">'. $id . '</li>';
}

?> 
</ul>
 
 
</body>
</html>
