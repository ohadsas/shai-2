/**
 * Created by majal on 10/28/17.
 */

var StatsView = Backbone.View.extend({
	el: '#stats_page',
	template: _.template($("#row").html()),
	sortedBy: 'day',
	sortedOrder: 'ASC',
	events: {
		'click .sort_by' : 'onSortBy',
		'click .filter_stats' : 'filterStats'
	},
	render: function() {
		var content = '';
		this.collection.each(function(e) {
			content += this.template({ model: e.toJSON() });
		}, this);
		this.$el.find('#stats_content').html(content);
		return this;
	},
	onSortBy: function(e) {
		e.preventDefault();
		var sortBy = $(e.target).attr('href');
		if (this.sortedBy == sortBy && this.sortedOrder == 'ASC') {
			// Change order only
			var reversed = this.collection.toArray().reverse();
			this.collection = new StatsCollection(reversed);
			this.sortedOrder = 'DESC';
		} else {
			this.collection = new StatsCollection(this.collection.sortBy(sortBy));
			this.sortedBy = sortBy;
			this.sortedOrder = 'ASC';
		}
		this.render();
	},
	filterStats: function(e) {
		e.preventDefault();
		var start = this.$el.find('#start_date').val();
		var end = this.$el.find('#end_date').val();
		//start = start || this.start;
		//end = end || this.end;
		var t = this;
		$.ajax(Configuration.API.stats.byDates, {
			type: 'get',
			dataType: 'json',
			data: JSON.stringify({ start: start, end: end }),
			success: function(response) {
				t.collection = new StatsCollection(response.data);
				t.render();
			},
			error: function () {
				Methods.showError('Something went wrong when fetching stats!');
			}
		})

	}

});