jQuery(function($) {
	$('form button[type="submit"]').on('click', function(e) {
		var t = $(this),
			f = t.closest('form'),
			g = 0,
			m = ['Existen errores en el formulario. Por favor, corrígelos antes de continuar.'];
		f.children('.response').remove();
		t.find('.invalid').removeClass('invalid');
		f.find('.elementor-field-required').each(function() {
			var c = $(this);
			c.find('input').each(function() {
				var x = $(this)
				switch (x.attr('type')) {
					case 'text':
						if (x.val() == '') {
							g++;
							m.push('Completa los campos marcados.');
							c.addClass('invalid');
						}
						break;
					case 'radio':
						if (c.find('input:checked').length == 0) {
							g++;
							m.push('Completa los campos marcados.');
							c.addClass('invalid');
						}
						break;
					case 'checkbox':
						if (c.find('input:checked').length == 0) {
							g++;
							if (c.hasClass('elementor-field-type-acceptance')) {
								m.push('Debes aceptar el aviso legal');
							} else {
								m.push('Completa los campos marcados.');
							}
							c.addClass('invalid');
						}
						break;
					case 'email':
						if (x.val() == '') {
							g++;
							m.push('Completa los campos marcados.');
							c.addClass('invalid');
						} else if (check_email(x.val()) == false) {
							g++;
							m.push('Dirección de correo incorrecta.');
							c.addClass('invalid');
						}
						break;
					case 'date':
						if (x.val() == '') {
							g++;
							m.push('Completa los campos marcados.');
							c.addClass('invalid');
						}
						break;
				}
			});
			c.find('select').each(function() {
				var x = $(this);
				if (x.val() == null) {
					g++;
					m.push('Completa los campos marcados.');
					c.addClass('invalid');
				}
			});
			c.find('textarea').each(function() {
				var x = $(this);
				if (x.val() == '') {
					g++;
					m.push('Completa los campos marcados.');
					c.addClass('invalid');
				}
			});
		});
		if (g > 0) {
			e.preventDefault();
			var n = [];
			$.each(m, function(i, el) {
				if($.inArray(el, n) === -1) n.push(el);
			});
			if (f.find('.elementor-message').length > 0) {
				f.find('.elementor-message').html(n.join(' '));
			} else {
				$('<div class="elementor-message">'+n.join(' ')+'</div>').appendTo(f);
			}
		}
	});
	$('input, select, label, textarea').on('click focus', function() {
		$(this).closest('.elementor-field-required').removeClass('invalid');
	});
});

jQuery(window).on('scroll', function() {

});

jQuery(window).on('load', function() {

});