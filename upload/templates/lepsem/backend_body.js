/**
 *  @template       LEPSem
 *  @version        see info.php of this template
 *  @author         cms-lab
 *  @copyright      2014-2016 cms-lab
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

 /* admin header navigation */
$('.browse')
  .popup({
    inline   : true,
    hoverable: true,
    position : 'bottom left',
    delay: {
      show: 300,
      hide: 300
    }
  })
;

/* checkboxes */
$('.ui.checkbox')
  .checkbox()
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

  
 /* enable drag and drop plugin (external)   */  
$(document).ready(function() {
    // Initialise the table
    $("#page_table1,#page_table2").tableDnD();
});

  