/**
 *  @template       LEPSem
 *  @version        see info.php of this template
 *  @author         cms-lab
 *  @copyright      2014-2017 cms-lab
 *  @license        GNU General Public License
 *  @license terms  see info.php of this template
 *  @platform       see info.php of this template
 */

  /* confirm links */
 function confirm_link(message, url) {
	if(confirm(message)) location.href = url + "&amp;leptokh=#-!leptoken-!#";
 }
 
/**
 *  semantic functions
 */

/* sidebar navi */ 
$('.ui.sidebar')
   .sidebar('attach events', '.toc.item')
;

/* checkboxes */
$('.ui.checkbox')
  .checkbox()
;

/* settings accordion */
$('.ui.accordion')
  .accordion()
;

 /* initialize drop down buttons */
$('.ui.dropdown, ui.select.dropdown ')
  .dropdown({
    on: 'hover'
  })
; 

 /* force new password to confirm modifications in preferences */
$(function(){ 
	$('#submit').click(function() {
		if(!$('#current_password').val()) {
			alert( unescape('{{ TEXT.NEED_PASSWORD_TO_CONFIRM }}!') ); return false;
		}
	});
}); 

 /* close message boxes on click  */
$('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
;


/**
 *  jQuery ui functions
 */

 /* enable datepicker    */
  $(function() {
    $( "#datepicker" ).datepicker();
  });

  
 /* enable drag and drop plugin (external)     
$(document).ready(function() {
    // Initialise the table
    $("#page_table1,#page_table2").tableDnD();
});
*/
$(document).ready(function() {

	// Initialise the first table (as before)
	//$("#lepsem_page_tree").tableDnD();

	// Make a nice striped effect on the table
	// $("#table-2 tr:even').addClass('alt')");

	// Initialise the second table specifying a dragClass and an onDrop function that will display an alert
	$("#table-3").tableDnD({
	    onDragClass: "myDragClass",
	    onDrop: function(table, row) {
            var rows = table.tBodies[0].rows;
            var debugStr = "Row dropped was "+row.id+". New order: ";
            for (var i=0; i<rows.length; i++) {
                debugStr += rows[i].id+" ";
            }
	        $(#debugArea).html(debugStr);
	    },
		onDragStart: function(table, row) {
			$(#debugArea).html("Started dragging row "+row.id);
		}
	});
	
	$("#table-3 tr").hover(function() {
          $(this.cells[0]).addClass('showDragHandle');
    }, function() {
          $(this.cells[0]).removeClass('showDragHandle');
    });
});

