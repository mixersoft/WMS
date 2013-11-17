$(document).ready(function(){
	bindWorkorderAjaxDetail();
	bindShowAssignedTasks();
	statusRadioReadOnly();
	statusCheckboxReadOnly();
});

function bindWorkorderAjaxDetail() {
	$('.expand-detail > i').click(function(e){
		var $target = $(e.currentTarget);
		var $row = $target.closest('.row');
		var id = $target.parent().attr('id');
		if ($target.hasClass('in')) {
			$target.addClass('fa-plus-square').removeClass('fa-minus-square in'); 
			$('#expanded-assigned-detail-'+id+'.expanded-assigned-detail').hide();
		} else {
			$target.removeClass('fa-plus-square').addClass('fa-minus-square in'); 

			var expanded = '#expanded-assigned-detail-'+id+'.expanded-assigned-detail';
			var $expanded = $(expanded);
			if ($expanded.length) {
				$expanded.show();
			} else {	// load
				$expanded = $('<tr><td colspan="13" class="expanded-assigned-detail" id="expanded-assigned-detail-' + id+ '">Loading...</td></tr>');
				$row.after($expanded);
				$expanded.find('td').load($target.closest('a').attr('href'));
			}
		}
		return false;
	});
}

function bindShowAssignedTasks() {
	$('a.expand-assigned > i').click(function(e){
		var $target = $(e.currentTarget);
		var $row = $target.closest('.row');
		var id = $target.parent().attr('id');
		if ($target.hasClass('in')) {
			$target.addClass('fa-plus-square').removeClass('fa-minus-square in'); 
			$('#expanded-assigned-detail-'+id+'.expanded-assigned-detail').hide();
		} else {
			$target.removeClass('fa-plus-square').addClass('fa-minus-square in'); 

			var expanded = '#expanded-assigned-detail-'+id+'.expanded-assigned-detail';
			var $expanded = $(expanded);
			if ($expanded.length) {
				$expanded.show();
			} else {	// load
				$expanded = $('<tr><td colspan="13" class="expanded-assigned-detail" id="expanded-assigned-detail-' + id+ '">Loading...</td></tr>');
				$row.after($expanded);
				$expanded.find('td').load($target.closest('a').attr('href'));
			}
		}
		return false;
	});

}

function statusRadioReadOnly() {
	$('.radioReadOnly input[type=radio]').click(function(){return false});
}

function statusCheckboxReadOnly() {
	$('.checkboxReadOnly input[type=checkbox]').click(function(){return false});
}