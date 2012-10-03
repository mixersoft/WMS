$(document).ready(function(){
	bindWorkorderAjaxDetail();
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