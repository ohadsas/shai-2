/**
 * Created by majal on 10/28/17.
 */

var StatsModel = Backbone.Model.extend ({
	defaults: {
		day: null,
		platform_id: null,
		country_iso: null,
		impressions: null,
		conversions: null
	}
});

var StatsCollection = Backbone.Collection.extend ({
	model: StatsModel
});