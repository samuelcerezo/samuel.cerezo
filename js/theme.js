// fitvids to make all videos full width http://fitvidsjs.com/
(function(e){"use strict";e(function(){e(".the-content").fitVids()})})(jQuery);

jQuery(function($) {
	$('#primary, .elementor-location-single, .elementor-location-archive').css('padding-top', $('.elementor-location-header').height()+'px');
	$('.parallax, [class*="parallax"]').each(function() {
		var t = $(this),
			i = t.css('background-image'),
			p = t.css('background-position'),
			v = t.css('background-size'),
			w = t.outerWidth(),
			h = t.outerHeight(),
			s = 0.05,
			c = t.attr('class').split(/\s+/);
		if (t.hasClass('elementor-column')) {
			i = t.children().css('background-image');
			p = t.children().css('background-position');
			v = t.children().css('background-size');
		}
		if (t.data('speed')) {
			s = t.data('speed');
		};
		$.each(c, function(index, value) {
			if (/^parallax-/.test(value)) {
				s = parseFloat('0.'+value.split('-')[1]);
			}
		});
		i = /^url\((['"]?)(.*)\1\)$/.exec(i);
		i = i ? i[2] : "";
		if (t.hasClass('elementor-column')) {
			t.css('background', 'transparent');
			t.css('overflow: hidden');
		} else {
			t.css('background', 'transparent').css('overflow: hidden');
		}
		$('<div class="parallax-bg" style="background-image: url('+i+'); background-position: '+p+'; background-size: '+v+';" data-speed="'+s+'"></div>').appendTo(t);
	});
	parallax();
})

function parallax() {
		var s = jQuery(window).scrollTop();
		jQuery('.parallax-bg').each(function() {
			var t = jQuery(this),
				e = t.data('speed'),
				s = ((t.parent('[class*="parallax"]').offset().top - (jQuery(window).scrollTop() + jQuery(window).height()))*e)+'px';
			t.height(((jQuery(window).height()*parseFloat(e))+t.parent('[class*="parallax"]').height())*(1+parseFloat(e))).css('top', s);
		});
}

function check_email(email) {
	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return re.test(email);
}

jQuery(window).scroll(function(e){
	parallax();
});

jQuery(window).on('load', function() {
	jQuery('.map-wrapper').each(function() {
		var t = jQuery(this),
			i = t.attr('id').split('-')[1],
			o = window['options_'+i],
			m = o['markers'],
			b = false;
		if (o.hasOwnProperty('bounds')) {
			b = o.bounds;
			delete o['bounds'];
		}
		delete o['markers'];
		o.container = t.attr('id');
		mapboxgl.accessToken = o.token;
		delete o['token'];
		window['map_'+i] = new mapboxgl.Map(o);
		var y = 1;
		m.forEach(function(marker) {
			var e = document.createElement('div'),
				s = marker.icon.size[0];
			e.style.width = s+'px';
			e.style.height = s+'px';
			e.style.marginLeft = (-s/2)*marker.icon.anchor[0]+'px';
			e.style.marginTop = (-s/2)*marker.icon.anchor[1]+'px';
			e.className = 'marker marker_'+i+'_'+y;
			e.style.backgroundImage = 'url('+marker.icon.url+')';
			if (marker.info.open == 'yes') {
				e.innerHTML = '<div class="bubble">'+marker.info.text+'</div>';
			}
			new mapboxgl.Marker(e).setLngLat(marker.position).addTo(window['map_'+i]);
			y++;
		});
		if (b != false) {
			window['map_'+i].fitBounds(b, {
				animate: false,
				padding: o.padding[0]
			});
		}
		window['map_'+i].addControl(new mapboxgl.NavigationControl({
			zoomControl: o.zoomControl
		}), 'top-left');
	});
});