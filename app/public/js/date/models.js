/**
 * Created by majal on 10/28/17.
 */

var StatsModel = Backbone.Model.extend ({
	defaults: {
		day: null,
		impressions: null,
		conversions: null,
		rate: null
	}
});

var StatsCollection = Backbone.Collection.extend ({
	model: StatsModel
});