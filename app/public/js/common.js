
var Configuration = {
	API: {
		publishers: '/api/publishers',
		countries: 'api/countries',
		platforms: 'api/platforms',
		stats: {
			'byDates': '/api/stats',
			'byPublisher': '/api/stats/publishers',
			'byPlatforms': '/api/stats/platforms'
		}
	}
};

// Global data collections
var Globals = {};

var Methods = {
	showError: function (message) {
		$('#error_msg').html(message).removeClass('hidden');
	}
};