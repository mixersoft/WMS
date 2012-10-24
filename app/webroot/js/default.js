$(document).ready(function(){
	bindWorkorderAjaxDetail();
	bindShowAssignedTasks();
	statusRadioReadOnly();
});

function bindWorkorderAjaxDetail() {
	$('.expand-detail').click(function(){
		$this = $(this);
		$this.parent().parent().after('<tr><td colspan="8" class="expanded-detail" id="expanded-detail-' + $this.attr('id') + '">Loading...</td></tr>');
		$('#expanded-detail-' + $this.attr('id')).load($this.attr('href'));
		$this.hide();
		return false;
	});
}

function bindShowAssignedTasks() {
	$('.expand-assigned').click(function(){
		$this = $(this);
		$this.parent().parent().after('<tr><td colspan="13" class="expanded-assigned-detail" id="expanded-assigned-detail-' + $this.attr('id') + '">Loading...</td></tr>');
		$('#expanded-assigned-detail-' + $this.attr('id')).load($this.attr('href'));
		$this.hide();
		return false;
	})
}

function statusRadioReadOnly() {
	$('.radioReadOnly input[type=radio]').click(function(){return false});
}