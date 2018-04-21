/**
 * Created by majal on 10/28/17.
 */

var StatsView = Backbone.View.extend({
	el: '#stats_table',
	template: _.template($("#row").html()),
	sortedBy: 'impressions',
	sortedOrder: 'DESC',
	events: {
		'click .sort_by' : 'onSortBy'
	},
	render: function() {
		var content = '';
		this.collection.each(function(e) {
			this.collection.get(e).set('publisher_name', _.findWhere(Globals.publishers, {id: e.get('publisher_id')}).name);
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
	}

});