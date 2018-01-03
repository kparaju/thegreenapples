;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);
	var isMobile = $win.width() < 768 ? true : false; 

	
	$doc.ready(function(){

		$('.nav-button').on('click', function(e) {
			$(this).toggleClass('active');
			$('.navigation-container-wrapper .tga-header').toggleClass('open');
			$('.navigation-container-wrapper').toggleClass('nav-open')
			e.preventDefault;

		})

		var mapHandler = {
			markers: [],
			centerLat: 37.09024,
			centerLng: -95.712891,
			zoom: 4,

			initialize: function() {

				var map = this.map;
				var myLatlng = new google.maps.LatLng(this.centerLat, this.centerLng);
				var mapOptions = {
					zoom: this.zoom,
					center: myLatlng
				}

				if ( isMobile ) {
					mapOptions.draggable = false;
				}

				map = this.map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

				this.renderAllMarkers();
			},

			setMarkers: function(markers) {
				var _this = this;
				this.clearMarkers();

				var bounds = new google.maps.LatLngBounds();
				
				for (var i = 0; i < markers.length; i++) {
					var data = markers[i];
					markersPosition = new google.maps.LatLng(parseFloat(data.lat) ,parseFloat(data.lng))

					var marker = new google.maps.Marker({
			  			position: markersPosition,
				  		map: this.map,
				  		address: data.address
			  		});

			  		this.markers.push(marker);
		  			bounds.extend(markersPosition);
				}

		  		this.map.fitBounds(bounds);
			},

			clearMarkers: function() {
				for (var i = 0; i < this.markers.length; i++) {
					this.markers[i].setMap(null);
				};

				this.markers = new Array();
			},

			mapReset: function() {
				this.clearMarkers();

				var myLatlng = new google.maps.LatLng(this.centerLat, this.centerLng);
				var mapOptions = {
					zoom: this.zoom,
					center: myLatlng
				}

				this.map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			},

			renderAllMarkers: function() {
				var _this = this;
				var location_id = crb_global.location_id;
				console.log(location_id);
				var request = $.ajax({
					url: crb_global.ajax_url,
					type: 'POST',
					dataType: 'json',
					data: { 
						action: 'get_makers',
						location_id: location_id
					}
				});

				request.done(function (response) {
					if (response && response.length) {
						_this.setMarkers(response);
					} else {
						$('<p>No environmentalists found. <a href="http://thegreenapples.org/supportus/" target="_blank">Be the first in your area!</a></p>').appendTo($('.markers-search-form'));
					}
				});

				request.fail(function(jqXHR, error, status) {
					alert('Something went wrong, please contact the administrator.');
				});
			}
		}

		google.maps.event.addDomListener(window, 'load', function() {
			mapHandler.initialize();
		});

		$('#location-finder').on('submit', function(e){

			$('.markers-search-form p').remove();
			var location = $('input[name=location]').val();
			var request = $.ajax({
				url: crb_global.ajax_url,
				type: 'POST',
				dataType: 'json',
				data: { 
					action: 'get_makers', 
					location: location
				}
			});

			request.done(function (response) {
				if (response && response.length) {
					mapHandler.setMarkers(response);
				} else {
					$('<p>No environmentalists found. <a href="http://thegreenapples.org/supportus/" target="_blank">Be the first in your area!</a></p>').appendTo($('.markers-search-form'));
					mapHandler.mapReset();
				}
			});

			request.fail(function(jqXHR, error, status) {
				alert('Something went wrong, please contact the administrator.');
			});

			e.preventDefault();
		})

	});
	
	// $win.on('resize', function(){ 
	// 	isMobile = $win.width() < 768 ? true : false;
	// 		google.maps.event.addDomListener(window, 'load', function() {
	// 		mapHandler.initialize();
	// 	});
	// })


})(jQuery, window, document);