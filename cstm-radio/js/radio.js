(function($){
    var ticker = 0;

    setInterval(getXML, 1000);

    function getXML() {
        $.ajax({
            url: "cstm-radio/include/ajax.php",
            data: {
                action: '',
                ticker: ticker
            },
            type: 'post',
            success: function (response) {
                var res = JSON.parse(response);
                var radio = document.getElementById('customRadio');
                var error = document.getElementById('radio-error');

                if (!res.error) {
                    if (error !== null) {
                        error.remove();
                    }
                    ticker = res.ticker;
                    var next = document.getElementById('next');
                    next.innerHTML = ticker;
                } else {
                    if (error !== null) {
                        error.innerHTML = res.error;
                    } else {
                        var error_msg = document.createElement('div');
                        var error_text = document.createTextNode(res.error);
                        error_msg.id = 'radio-error';
                        error_msg.appendChild(error_text);
                        radio.appendChild(error_msg);
                    }
                }
            }
        });

        return false;
    }
})(jQuery);
