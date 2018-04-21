/**
 * Created by majal on 10/28/17.
 */


var StatsModel = Backbone.Model.extend ({
	defaults: {
		publisher_id: null,
		impressions: null,
		conversions: null,
		rate: null,
		publisher_name: null
	}
});

var StatsCollection = Backbone.Collection.extend ({
	model: StatsModel
});