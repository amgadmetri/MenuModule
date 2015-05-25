<script type="text/javascript">
	(function ($) {

		function newPaginateObj()
		{
			var paginate = {
				init: function (paginateId) {
					paginate.prepare(paginateId);
					paginate.events();
				},

				prepare: function (paginateId) {
					paginate.paginateId      = paginateId;
					paginate.linkDataContent = $('#link_data_content');
				},

				events: function () {
					$(document).on('click', paginate.paginateId, function(e) {
						e.preventDefault();
						paginate.link = $(this).attr('href');
						paginate.ajaxAction($(this));
					});
				},

				ajaxAction: function (paginateobj) {
					$.ajax({
						url         : paginate.link,
						type        : 'GET',
						success		: function(data)
						{
							paginateobj.parents('div.link_data_content').empty().append(data);
						}
					});
				}
			}
			return paginate;
		}

		$(document).ready(function (){

			var linkDataPrevious =  newPaginateObj();
			linkDataPrevious.init(".linkDataPrevious");

			var linkDataNext     =  newPaginateObj();
			linkDataNext.init(".linkDataNext");

			var linkDataLinks    =  newPaginateObj();
			linkDataLinks.init(".linkDataLinks");
		});

	}(jQuery));
</script>