export class VideoEmbedGenerator {
    constructor() {
        // Patrones para YouTube
        this.youtubePatterns = [
            /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/v\/|youtube\.com\/watch\?.*&v=)([a-zA-Z0-9_-]{11})/,
            /youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/,
            /youtube\.com\/live\/([a-zA-Z0-9_-]{11})/,
            /m\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/
        ];
        
        // Patrones para Vimeo
        this.vimeoPatterns = [
            /vimeo\.com\/(\d+)/,
            /vimeo\.com\/video\/(\d+)/,
            /vimeo\.com\/channels\/[\w-]+\/(\d+)/,
            /vimeo\.com\/groups\/[\w-]+\/videos\/(\d+)/,
            /vimeo\.com\/album\/\d+\/video\/(\d+)/,
            /vimeo\.com\/showcase\/\d+\/video\/(\d+)/,
            /player\.vimeo\.com\/video\/(\d+)/
        ];
    }
    
    detectPlatform(url) {
        // Normalizar URL
        url = url.trim();
        if (!url.startsWith('http')) {
            url = 'https://' + url;
        }
        
        // Detectar YouTube
        for (let pattern of this.youtubePatterns) {
            const match = url.match(pattern);
            if (match) {
                return {
                    platform: 'youtube',
                    id: match[1],
                    originalUrl: url
                };
            }
        }
        
        // Detectar Vimeo
        for (let pattern of this.vimeoPatterns) {
            const match = url.match(pattern);
            if (match) {
                return {
                    platform: 'vimeo',
                    id: match[1],
                    originalUrl: url
                };
            }
        }
        
        return null;
    }
    
    generateYouTubeEmbed(videoId, width = 560, height = 315, options = {}) {
        const params = new URLSearchParams({
            rel: options.rel || '0',
            modestbranding: options.modestbranding || '1',
            controls: options.controls || '1',
            showinfo: options.showinfo || '0',
            fs: options.fullscreen || '1',
            cc_load_policy: options.captions || '0',
            iv_load_policy: options.annotations || '3',
            autohide: options.autohide || '2'
        });
        
        if (options.start) params.set('start', options.start);
        if (options.end) params.set('end', options.end);
        if (options.autoplay) params.set('autoplay', '1');
        if (options.mute) params.set('mute', '1');
        if (options.loop) params.set('loop', '1');
        
        const embedUrl = `https://www.youtube.com/embed/${videoId}?${params.toString()}`;
        
        return `<iframe width="${width}" height="${height}" src="${embedUrl}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
    }
    
    generateVimeoEmbed(videoId, width = 560, height = 315, options = {}) {
        const params = new URLSearchParams();
        
        if (options.autoplay) params.set('autoplay', '1');
        if (options.loop) params.set('loop', '1');
        if (options.muted) params.set('muted', '1');
        if (options.controls === false) params.set('controls', '0');
        if (options.title === false) params.set('title', '0');
        if (options.byline === false) params.set('byline', '0');
        if (options.portrait === false) params.set('portrait', '0');
        if (options.color) params.set('color', options.color);
        
        const paramString = params.toString();
        const embedUrl = `https://player.vimeo.com/video/${videoId}${paramString ? '?' + paramString : ''}`;
        
        return `<iframe src="${embedUrl}" width="${width}" height="${height}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
    }
    
    generateEmbed(url, width = 560, height = 315, options = {}) {
        const detection = this.detectPlatform(url);
        
        if (!detection) {
            throw new Error('URL no reconocida. Asegúrate de usar una URL válida de YouTube o Vimeo.');
        }
        
        switch (detection.platform) {
            case 'youtube':
                return {
                    platform: 'YouTube',
                    id: detection.id,
                    embedCode: this.generateYouTubeEmbed(detection.id, width, height, options)
                };
            case 'vimeo':
                return {
                    platform: 'Vimeo',
                    id: detection.id,
                    embedCode: this.generateVimeoEmbed(detection.id, width, height, options)
                };
            default:
                throw new Error('Plataforma no soportada');
        }
    }
}