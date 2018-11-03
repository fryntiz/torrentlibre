/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

$(document).ready(function() {
    var defaultTrackers = [
        "http://tracker.tfile.me/announce",
        "udp://tracker.openbittorrent.com:80/announce",
        "udp://tracker.internetwarriors.net:1337/announce",
        "udp://tracker.sktorrent.net:6969/announce",
        "udp://tracker.opentrackr.org:1337/announce",
        "udp://tracker.coppersurfer.tk:6969/announce",
        "udp://tracker.leechers-paradise.org:6969/announce",
        "udp://tracker.zer0day.to:1337/announce",
        "udp://explodie.org:6969/announce",
        "udp://exodus.desync.com:6969/announce",
        "udp://tracker.pirateparty.gr:6969/announce",
        "udp://public.popcorn-tracker.org:6969/announce",
        "udp://tracker1.wasabii.com.tw:6969/announce",
        "udp://tracker2.wasabii.com.tw:6969/announce"
    ];

    var magnet = $('#magnet').text();

    var trackers = Array.from(document.querySelectorAll(".trackers dl a"))
                  .map(node => node.textContent.trim()).concat(defaultTrackers);

    var trackersCmps = trackers.reduce((result, uri) => result + "&tr=" + encodeURIComponent(uri), "");

    var uri = `${magnet}${trackersCmps}`;

    $('#magnet').attr('href', uri);

    /**
     * Esta función copia al portapapeles el enlace magnet
     */
    function copyMagnetToClipboard() {
        var magnet = $('#magnet').attr('href');
        var $temp = $("<input>");

        $("body").append($temp);
        $temp.val(magnet).select();
        document.execCommand("copy");
        $temp.remove();
    }

    // Asigno evento para copiar al pulsar el icono de magnet
    $('#copymagnet').click(copyMagnetToClipboard);

    /**
     * Esta función refresca las descargas al pulsar el botón "Descargar"
     */
    function recargarDescargas() {
        var id = $('#btn-torrent-download').data('torrent_id');

        setTimeout(function() {
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: "/torrents/obtenerdescargas",
                async: false,
                data: { 'id': id },
                timeout:5000,  // Tiempo a esperar antes de dar error
                success: function(data) {
                    $('#torrents-veces-descargado').text(data);
                },
            });
        }, 3000);
    }

    // Añado evento al pulsar sobre el botón descargas para actualizar valor.
    $('#btn-torrent-download').click(recargarDescargas);


    function modificarPuntuacion(puntuacion, torrent) {
        $.ajax({
            type: 'GET',
            url: "/puntuacion-torrents/modificar",
            async: false,
            data: {
                'puntuacion': puntuacion,
                'torrent' : torrent,
            },
            timeout:5000,
        });
    }

    // Llamada al plugin de votación "star-rating"
    $('.rating').starRating({
        minus: true // step minus button
    });

    // Al pulsar un valor se actualiza en la DB.
    $('.rating').click(function() {
        var puntuacion = $('.rating').attr('data-val');
        var torrent = $('.rating').attr('data-torrent');
        modificarPuntuacion(puntuacion, torrent);
        window.location = '/torrents/view?id='+torrent;
    });

    // Al cargar el documento se actualiza el valor

});
