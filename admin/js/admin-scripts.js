(function () {

    var win = window;
    var FR = win.FileReader;
    var doc = win.document;
    var kjua = win.kjua;

    var gui_val_pairs = [
        ['size', 'px'],
        ['minversion', ''],
        ['quiet', ' modules'],
        ['rounded', '%'],
        ['msize', '%'],
        ['mposx', '%'],
        ['mposy', '%']
    ];

    function el_by_id(id) {
        return doc.getElementById(id);
    }

    function val_by_id(id) {
        var el = el_by_id(id);
        return el && el.value;
    }

    function int_by_id(id) {
        return parseInt(val_by_id(id), 10);
    }

    function on_event(el, type, fn) {
        el.addEventListener(type, fn);
    }

    function on_ready(fn) {
        on_event(doc, 'DOMContentLoaded', fn);
    }

    function for_each(list, fn) {
        Array.prototype.forEach.call(list, fn);
    }

    function all(query, fn) {
        var els = doc.querySelectorAll(query);
        if (fn) {
            for_each(els, fn);
        }
        return els;
    }

    function update_gui() {
        gui_val_pairs.forEach(function (pair) {
            var label = all('label[for="' + pair[0] + '"]')[0];
            var text = label.innerHTML;
            label.innerHTML = text.replace(/:.*$/, ': ' + val_by_id(pair[0]) + pair[1]);
        });
    }

			function update_qrcode() {
	            var options = {
				text:"QR Code Composer",	 
				width: val_by_id('qwe_sizw'),
				height: val_by_id('qwe_sizw'),
				background: val_by_id('qr_bg'),
				foreground: val_by_id('fill'),					
				};	
			var container = el_by_id("qrccomsposerprview");
			for_each(container.childNodes, function (child) {
				container.removeChild(child);
			});
			jQuery(container).qrcode(options);
			var container1 = el_by_id("qrccomsposerprviewss");
			for_each(container1.childNodes, function (child) {
				container1.removeChild(child);
			});
			jQuery(container1).qrcode(options);


}

    function update() {
        // update_gui();
        update_qrcode();
    }

    jQuery(document).ready(function () {
        function qrcpromodalwrapperQRSsdh() {
            jQuery(".qrc-modal-toggle").on("click", function () {
                jQuery(".qrc_modal").toggleClass("is-visible");
            });
        }qrcpromodalwrapperQRSsdh();
		 jQuery(".qrc-color-picker").wpColorPicker({
         change: function(event, ui) {
						
		 el_by_id('fill');
		el_by_id('qr_bg');

            setTimeout(update, 100);			
						
    },
	clear: function (event) {
		el_by_id('qr_bg').value = 'transparent';
		     setTimeout(update, 100);
	
    }
});


    })
    on_ready(function () {
        all("input, textarea, select", function (el) {
            on_event(el, "input", update);
            on_event(el, "change", update);
        });
        on_event(win, "load", update);
        setTimeout(update, 250);
    });



}(jQuery));


