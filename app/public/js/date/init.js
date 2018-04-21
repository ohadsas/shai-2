/**
 * Created by majal on 10/28/17.
 */
$(document).ready(function () {
	$.ajax(Configuration.API.stats.byDates, {
		type: 'get',
		dataType: 'json',
		success: function(response) {
			var collection = new StatsCollection(response.data);
			var view = new StatsView({collection: collection});
			view.render();
		},
		error: function () {
			Methods.showError('Something went wrong when fetching stats!');
		}
	})
});