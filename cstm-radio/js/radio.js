(function($){
    var titleEl = document.getElementById('title'),
        artistEl = document.getElementById('artist'),
        albumEl = document.getElementById('album'),
        genreEl = document.getElementById('genre'),
        durationEl = document.getElementById('duration'),
        nextEl = document.getElementById('next'),
        most = document.getElementById('most'),
        title, artist, album, genre, duration, next;

    setInterval(getXML, 1000);

    most.onchange = function(){
        var most_kind = this.value,
            period = document.getElementById('period').value;

        $.ajax({
            url: "cstm-radio/include/radio-ajax.php",
            data: {
                action: 'stat',
                period: period,
                most_kind: most_kind
            },
            type: 'post',
            success: function (response) {
                var res = JSON.parse(response),
                    statRes = document.getElementById('stat-res'),
                    countValue;
                console.log(res);

                switch (res.kind) {
                    case 'genre':
                    case 'artist':
                        countValue = 'tracks';
                        break;

                    default:
                        countValue = 'times';
                        break;
                }

                if (res.length != 0) {
                    if (res.kind === 'longest' || res.kind === 'shortest') {
                        statRes.innerHTML = res.most_kind + ' is <b>' +
                            res.artist + ' - ' + res.title + '</b> (' + res.duration + ' sec)';
                    } else {
                        statRes.innerHTML = res.most_kind + ' is <b>' +
                            res.name + '</b> (' + res.number + ' ' + countValue + ')';
                    }
                } else {
                    statRes.innerHTML = '';
                }
            }
        });

        return false;
    };

    function getXML() {
        getTrackData();
        $.ajax({
            url: "cstm-radio/include/radio-ajax.php",
            data: {
                action: 'xml',
                title: title,
                artist: artist,
                album: album,
                genre: genre,
                duration: duration
            },
            type: 'post',
            success: function (response) {
                var res = JSON.parse(response);
                var radio = document.getElementById('customRadio');
                var error = document.getElementById('radio-error');

                var ticker_el = document.getElementById('ticker');
                ticker_el.innerHTML = res.ticker;

                if (!res.error) {
                    if (error !== null) {
                        error.remove();
                    }

                    nextEl.innerHTML = res.next[0];
                    changeElementValue(titleEl, res.title);
                    changeElementValue(artistEl, res.artist);
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

    function getTrackData() {
        title = titleEl.innerHTML;
        album = albumEl.innerHTML;
        genre = genreEl.innerHTML;
        duration = durationEl.innerHTML;
        next = nextEl.innerHTML;
    }

    function changeElementValue(element, responseElement) {
        if (element.innerHTML !== responseElement[0]) {
            element.innerHTML = responseElement[0];
        }
    }

})(jQuery);
