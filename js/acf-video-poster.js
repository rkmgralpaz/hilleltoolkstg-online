(function($){
    if (typeof acf === 'undefined') return;

    function detectPlatform(url){
        var u = url.toLowerCase();
        if (u.indexOf('youtube.com') !== -1 || u.indexOf('youtu.be') !== -1) return 'youtube';
        if (u.indexOf('vimeo.com') !== -1) return 'vimeo';
        return 'unknown';
    }

    function isYouTubeShort(url){
        try {
            var u = new URL(url, window.location.origin);
            var host = u.hostname.replace(/^www\./,'').toLowerCase();
            var path = u.pathname || '';
            if (host.indexOf('youtube.com') !== -1 && path.indexOf('/shorts/') !== -1) return true;
            return false;
        } catch(e){
            return (url.indexOf('/shorts/') !== -1);
        }
    }

    function extractYouTubeId(url){
        try {
            var u = new URL(url, window.location.origin);
            var host = u.hostname.replace(/^www\./,'').toLowerCase();

            if (host === 'youtu.be') {
                var id = (u.pathname || '').replace('/','').trim();
                return id ? id.substring(0, 11) : '';
            }

            if (host.indexOf('youtube.com') !== -1) {
                if ((u.pathname || '').indexOf('/shorts/') !== -1) {
                    var parts = u.pathname.split('/shorts/');
                    if (parts[1]) return parts[1].split('/')[0].substring(0, 11);
                }
                var v = u.searchParams.get('v');
                if (v) return v.substring(0, 11);
            }
        } catch(e){}

        var m = String(url).match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|shorts\/))([^?&#/\s]{11})/i);
        return m && m[1] ? m[1] : '';
    }

    // Listen for changes in video_url fields inside youtube_embeds layouts
    $(document).on('blur change keyup', '.layout-youtube_embeds [data-name="video_url"] input[type="url"]', function () {
        var $this = $(this);
        var $parent = $this.closest('.acf-fields');
        var url = $this.val();
        var platform = detectPlatform(url);
        var $poster = $parent.find('[data-name="poster_default"] input[type="text"]');
        var $plattform = $parent.find('[data-name="plattform"] input[type="text"]');

        if (platform !== 'unknown') {
            var poster = '';

            if (platform === 'youtube') {
                var id = extractYouTubeId(url);
                if (id) {
                    poster = 'https://img.youtube.com/vi/' + id + '/maxresdefault.jpg';
                }
                $poster.val(poster);
                $plattform.val('youtube');
            } else if (platform === 'vimeo') {
                $plattform.val('vimeo');
                // Try oEmbed for Vimeo poster
                fetch('https://vimeo.com/api/oembed.json?url=' + encodeURIComponent(url))
                    .then(function(r){ return r.json(); })
                    .then(function(data){
                        if (data && data.thumbnail_url) {
                            $poster.val(data.thumbnail_url);
                        }
                    })
                    .catch(function(){});
            }
        } else {
            $poster.val('');
            $plattform.val('');
        }
    });

})(jQuery);
