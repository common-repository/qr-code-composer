(function($) {
    'use strict';
    function QRCShortcode() {
        jQuery(".qrc_canvass").each(function() {
            var options = {
				text:$(this).data('text'),	 
				width: datas.size,
				height: datas.size,
				background: datas.background,
				foreground: datas.color,
            };
                var ereer = $(this).attr('id');
                var $Mqrds = '#' + ereer;
				$($Mqrds).qrcode(options);

        });
    }
    QRCShortcode();

    function QRCShortcodeButon() {
        jQuery(".qrcdownloads").each(function(index) {
            $(this).on("click", function() {
                var ereer = $(this).closest('.qrcprowrapper').children('.qrc_canvass').attr('id');
                var $Mqrds = '#' + ereer + ' canvas';
                var image = document.querySelector($Mqrds).toDataURL("image/png").replace("image/png", "image/octet-stream");
                this.setAttribute("href", image)
            });
        });

    }
    QRCShortcodeButon();

    function qrcpromodalwrapperQRS() {
        jQuery(".qrcpromodalwrapper").each(function() {
            var modlabutton = $(this).find('.qrc-modal-toggle');
            var modla = $(this).find('.qrc_modal');
            $(modlabutton).on('click', function(e) {
                e.preventDefault();
                $(modla).toggleClass('is-visible');
            });

        });
    }
    qrcpromodalwrapperQRS();
}(jQuery));