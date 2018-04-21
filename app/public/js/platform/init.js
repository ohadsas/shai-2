/**
 * Created by majal on 10/28/17.
 */
$(document).ready(function () {
	// init
	$.ajax(Configuration.API.publishers, {
		success: function(response) {
			Globals.publishers = response.data;
			$.ajax(Configuration.API.countries, {
				success: function(response) {
					Globals.countries = response.data;
					$.ajax(Configuration.API.platforms, {
						success: function(response) {
							Globals.platforms = response.data;
							$.ajax(Configuration.API.stats.byPlatforms, {
								contentType: "application/json",
								success: function(response) {
									var collection = new StatsCollection(response.data);
									var view = new StatsView({collection: collection});
									view.render();
								},
								error: function () {
									Methods.showError('Something went wrong when fetching stats!');
								}
							})
						},
						error: function () {
							Methods.showError('Something went wrong when fetching platforms!');
						}
					})
				},
				error: function () {
					Methods.showError('Something went wrong when fetching countries!');
				}
			})
		},
		error: function () {
			Methods.showError('Something went wrong when fetching publishers!');
		}
	})
});

