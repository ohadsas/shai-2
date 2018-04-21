/**
 * Created by majal on 10/28/17.
 */

var StatsView = Backbone.View.extend({
	el: '#stats_page',
	aggregatedCollection: null,
	templatePub: _.template($("#publisher_select").html()),
	templateCtry: _.template($("#country_select").html()),
	templateHead: _.template($("#header_row").html()),
	platforms: [],
	graphVisible: false,
	graphObject: null,
	events: {
		'click .filter_stats' : 'filterStats',
		'click .update_country' : 'updateCountryData',
		'click .check_show_graph' : 'toggleGraphVisibility'
	},

	aggregateStats: function () {
		var aggregated = [];
		// Group and sum up collection data
		_.each(this.collection.groupBy('day'), function (dayList, day) {
			groupedDday = _.groupBy(dayList, function (dataRow) {
				return dataRow.attributes.platform_id;
			});
			aggregated[day] = {
				day: day
			};
			var aggrRow = {day: day};
			_.each(groupedDday, function (platformlist, platformId) {
				var impressions = 0;
				var conversions = 0;
				_.each(platformlist, function (dataRow) {
					impressions += dataRow.attributes.impressions;
					conversions += dataRow.attributes.conversions;
				});
				var rate = (impressions == 0) ? 0 : (conversions/impressions) * 100;
				aggrRow[platformId] = rate.toPrecision(2);
			});
			aggregated.push(aggrRow);
		});

		this.aggregatedCollection = aggregated;
	},

	render: function() {
		this.renderPublishers();
		this.renderCountries();
		this.renderColumnNames();
		this.renderStats();
		return this;
	},

	renderColumnNames: function() {
		this.platforms = _.sortBy(Globals.platforms, 'id');
		var content = '<th>Day</th>';
		_.each(this.platforms, function (e) {
			content += this.templateHead({ model: e });
		}, this);
		this.$el.find('#stats_header').html(content);
	},

	renderStats: function() {
		this.aggregateStats();
		this.$el.find('#stats_content').html('');
		_.each(this.aggregatedCollection, function (dataRow) {
			var content = '<td>' + dataRow.day + '</td>';
			// Organize according to column data to be sure the right rate appears under the column name
			_.each(this.platforms, function (platform) {
				var rate = dataRow[platform.id] || 0;
				content += '<td>' + rate + '%</td>';
			});
			this.$el.find('#stats_content').append($('<tr></tr>').html(content));
		}, this);

		if (this.graphVisible) {
			this.renderGraph();
		}
	},

	renderPublishers: function() {
		var content = '';
		_.each(Globals.publishers, function (e) {
			content += this.templatePub({ model: e });
		}, this);
		this.$el.find('#stats_publisher').html(content);
	},

	renderCountries: function() {
		var content = '';
		_.each(Globals.countries, function (e) {
			content += this.templateCtry({ model: e });
		}, this);
		this.$el.find('#stats_country').html(content);
	},

	filterStats: function(e) {
		e.preventDefault();
		var publisherId = this.$el.find('#stats_publisher').val();
		var t = this;
		$.ajax(Configuration.API.stats.byPlatforms, {
			type: 'get',
			dataType: 'json',
			data: JSON.stringify({ publisherId: publisherId }),
			success: function(response) {
				t.collection = new StatsCollection(response.data);
				t.renderStats();
			},
			error: function () {
				Methods.showError('Something went wrong when fetching stats!');
			}
		})
	},

	updateCountryData: function (e) {
		e.preventDefault();
		var iso = this.$el.find('#stats_country').val();
		var impressions = parseInt(this.$el.find('#update_impressions').val(), 10) || null;
		var conversions = parseInt(this.$el.find('#update_conversions').val(), 10) || null;
		var setValues = {};
		if (impressions !== null) {
			setValues.impressions = impressions
		}
		if (conversions !== null) {
			setValues.conversions = conversions;
		}
		var changeList = this.collection.where({'country_iso' : iso});
		_.each(changeList, function (model) {
			this.collection.get(model.cid).set(setValues);
		}, this);

		this.renderStats();
	},

	renderGraph: function () {
		var graphConf = {
			series: {
				lines: { show: true },
				points: { show: false }
			},
			xaxis: {
				mode: "time",
				timeformat: "%m/%d"
			},
			yaxis: {
				min: 0,
				max: 1
			}
		};
		var graphData = {};
		// Create data collection format for graph
		_.each(this.platforms, function (platform) {
			graphData[platform.id] = {
				label: platform.name,
				data: []
			};
		});
		_.each(this.aggregatedCollection, function(dataRow){
			_.each(this.platforms, function (platform) {
				graphData[platform.id].data.push([Date.parse(dataRow.day), dataRow[platform.id]]);
			}, this);
		}, this);
		var data = [];
		_.each(graphData, function (e, i) {
			data.push({
				label: e.label,
				data: e.data
			})
		});

		// Show graph
		if (this.graphObject == null) {
			this.graphObject = $("#placeholder").plot(data, graphConf).data("plot");
		} else {
			this.graphObject.setData(data);
			this.graphObject.draw();
		}
	},

	toggleGraphVisibility: function(e) {
		var showGraph = this.$el.find('#show_graph').is(":checked");
		if (showGraph) {
			if (!this.graphVisible) {
				this.$el.find('#placeholder').removeClass('hidden');
				this.renderGraph();
				this.graphVisible = true;
			}
		} else {
			this.graphVisible = false;
			this.$el.find('#placeholder').addClass('hidden');
		}
	}

});