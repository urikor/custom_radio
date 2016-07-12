(function($){
    var ticker = 0,
        titleEl = document.getElementById('title'),
        albumEl = document.getElementById('album'),
        genreEl = document.getElementById('genre'),
        durationEl = document.getElementById('duration'),
        nextEl = document.getElementById('next'),
        title, album, genre, duration, next;

    setInterval(getXML, 1000);

    function getTrackData() {
        title = titleEl.innerHTML;
        album = albumEl.innerHTML;
        genre = genreEl.innerHTML;
        duration = durationEl.innerHTML;
        next = nextEl.innerHTML;
    }

    function getXML() {
        getTrackData();
        $.ajax({
            url: "cstm-radio/include/ajax.php",
            data: {
                ticker: ticker,
                title: title,
                album: album,
                genre: genre,
                duration: duration
            },
            type: 'post',
            success: function (response) {
                var res = JSON.parse(response);
                var radio = document.getElementById('customRadio');
                var error = document.getElementById('radio-error');
                console.log(res);

                var ticker_el = document.getElementById('ticker');
                ticker = res.ticker;
                ticker_el.innerHTML = ticker;

                if (!res.error) {
                    if (error !== null) {
                        error.remove();
                    }

                    nextEl.innerHTML = res.next[0];
                    changeElementValue(titleEl, res.title);
                    changeElementValue(albumEl, res.album);
                    changeElementValue(genreEl, res.genre);
                    changeElementValue(durationEl, res.duration);

                    getTrackData();
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

    function changeElementValue(element, responseElement) {
        if (element.innerHTML !== responseElement[0]) {
            element.innerHTML = responseElement[0];
        }
    }

})(jQuery);
