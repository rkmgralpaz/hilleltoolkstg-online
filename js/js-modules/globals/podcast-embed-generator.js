export class PodcastEmbedGenerator {
    constructor() {
        this.patterns = {
            applePodcasts: [
                // Apple Podcasts app URLs
                /https?:\/\/podcasts\.apple\.com\/([a-z]{2}\/)?podcast\/([^\/]+\/)?id(\d+)(\?i=(\d+))?/i,
                // iTunes legacy URLs
                /https?:\/\/itunes\.apple\.com\/([a-z]{2}\/)?podcast\/([^\/]+\/)?id(\d+)(\?i=(\d+))?/i,
                // Apple Music individual track/episode
                /https?:\/\/music\.apple\.com\/([a-z]{2}\/)?album\/([^\/]+\/)?(\d+)\?i=(\d+)/i,
                // Apple Music full album/show
                /https?:\/\/music\.apple\.com\/([a-z]{2}\/)?album\/([^\/]+\/)?(\d+)(?!\?i=)/i,
                // Apple Music playlist
                /https?:\/\/music\.apple\.com\/([a-z]{2}\/)?playlist\/([^\/]+\/)?(\d+)/i,
                // Apple Music artist
                /https?:\/\/music\.apple\.com\/([a-z]{2}\/)?artist\/([^\/]+\/)?(\d+)/i
            ],
            spotify: [
                // Spotify episode
                /https?:\/\/open\.spotify\.com\/episode\/([a-zA-Z0-9]+)(\?.*)?/i,
                // Spotify show/podcast
                /https?:\/\/open\.spotify\.com\/show\/([a-zA-Z0-9]+)(\?.*)?/i,
                // Spotify track
                /https?:\/\/open\.spotify\.com\/track\/([a-zA-Z0-9]+)(\?.*)?/i,
                // Spotify album
                /https?:\/\/open\.spotify\.com\/album\/([a-zA-Z0-9]+)(\?.*)?/i,
                // Spotify playlist
                /https?:\/\/open\.spotify\.com\/playlist\/([a-zA-Z0-9]+)(\?.*)?/i,
                // Spotify artist
                /https?:\/\/open\.spotify\.com\/artist\/([a-zA-Z0-9]+)(\?.*)?/i,
                // Spotify short links
                /https?:\/\/spotify\.link\/([a-zA-Z0-9]+)/i,
                // Spotify embed URLs
                /https?:\/\/open\.spotify\.com\/embed\/(episode|show|track|album|playlist|artist)\/([a-zA-Z0-9]+)/i
            ],
            youtube: [
                // Standard YouTube watch URLs
                /https?:\/\/(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/i,
                // YouTube short URLs
                /https?:\/\/youtu\.be\/([a-zA-Z0-9_-]+)/i,
                // YouTube embed URLs
                /https?:\/\/(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]+)/i,
                // YouTube playlist
                /https?:\/\/(?:www\.)?youtube\.com\/playlist\?list=([a-zA-Z0-9_-]+)/i,
                // YouTube channel
                /https?:\/\/(?:www\.)?youtube\.com\/channel\/([a-zA-Z0-9_-]+)/i,
                // YouTube user
                /https?:\/\/(?:www\.)?youtube\.com\/user\/([a-zA-Z0-9_-]+)/i,
                // YouTube handle (@username)
                /https?:\/\/(?:www\.)?youtube\.com\/@([a-zA-Z0-9_-]+)/i,
                // YouTube Shorts
                /https?:\/\/(?:www\.)?youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/i
            ]
        };
    }

    detectPlatform(url) {
        // Apple Podcasts & Apple Music
        for (let i = 0; i < this.patterns.applePodcasts.length; i++) {
            const pattern = this.patterns.applePodcasts[i];
            const match = url.match(pattern);
            if (match) {
                if (url.includes('music.apple.com')) {
                    if (url.includes('?i=')) {
                        // Episode específico en Apple Music
                        return {
                            platform: 'apple',
                            id: match[3],
                            episodeId: match[4],
                            originalUrl: url,
                            type: 'music-episode'
                        };
                    } else if (url.includes('/album/')) {
                        // Álbum completo en Apple Music
                        return {
                            platform: 'apple',
                            id: match[3],
                            originalUrl: url,
                            type: 'music-album'
                        };
                    } else if (url.includes('/playlist/')) {
                        // Playlist en Apple Music
                        return {
                            platform: 'apple',
                            id: match[3],
                            originalUrl: url,
                            type: 'music-playlist'
                        };
                    } else if (url.includes('/artist/')) {
                        // Artista en Apple Music
                        return {
                            platform: 'apple',
                            id: match[3],
                            originalUrl: url,
                            type: 'music-artist'
                        };
                    }
                } else {
                    // Apple Podcasts clásico
                    return {
                        platform: 'apple',
                        id: match[3],
                        episodeId: match[5] || null,
                        originalUrl: url,
                        type: 'podcast'
                    };
                }
            }
        }

        // Spotify
        for (let i = 0; i < this.patterns.spotify.length; i++) {
            const pattern = this.patterns.spotify[i];
            const match = url.match(pattern);
            if (match) {
                if (url.includes('/embed/')) {
                    // URL de embed existente
                    return {
                        platform: 'spotify',
                        id: match[2],
                        originalUrl: url,
                        type: match[1] // episode, show, track, album, playlist, artist
                    };
                } else if (url.includes('spotify.link')) {
                    // Link corto de Spotify
                    return {
                        platform: 'spotify',
                        id: match[1],
                        originalUrl: url,
                        type: 'short-link'
                    };
                } else {
                    // URLs normales de Spotify
                    let type = 'show'; // default
                    if (url.includes('/episode/')) type = 'episode';
                    else if (url.includes('/show/')) type = 'show';
                    else if (url.includes('/track/')) type = 'track';
                    else if (url.includes('/album/')) type = 'album';
                    else if (url.includes('/playlist/')) type = 'playlist';
                    else if (url.includes('/artist/')) type = 'artist';
                    
                    return {
                        platform: 'spotify',
                        id: match[1],
                        originalUrl: url,
                        type: type
                    };
                }
            }
        }

        // YouTube
        for (let i = 0; i < this.patterns.youtube.length; i++) {
            const pattern = this.patterns.youtube[i];
            const match = url.match(pattern);
            if (match) {
                let type = 'video'; // default
                if (url.includes('/playlist')) type = 'playlist';
                else if (url.includes('/channel/')) type = 'channel';
                else if (url.includes('/user/')) type = 'user';
                else if (url.includes('/@')) type = 'handle';
                else if (url.includes('/shorts/')) type = 'shorts';
                
                return {
                    platform: 'youtube',
                    id: match[1],
                    originalUrl: url,
                    type: type
                };
            }
        }

        return null;
    }

    generateAppleEmbed(data) {
        switch (data.type) {
            case 'music-episode':
                // Episodio específico en Apple Music
                return `<iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0" height="175" style="width:100%;overflow:hidden;border-radius:10px;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.music.apple.com/album/${data.id}?i=${data.episodeId}"></iframe>`;
            
            case 'music-album':
                // Álbum completo en Apple Music
                return `<iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0" height="450" style="width:100%;overflow:hidden;border-radius:10px;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.music.apple.com/album/${data.id}"></iframe>`;
            
            case 'music-playlist':
                // Playlist en Apple Music
                return `<iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0" height="450" style="width:100%;overflow:hidden;border-radius:10px;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.music.apple.com/playlist/${data.id}"></iframe>`;
            
            case 'music-artist':
                // Artista en Apple Music
                return `<iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0" height="450" style="width:100%;overflow:hidden;border-radius:10px;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.music.apple.com/artist/${data.id}"></iframe>`;
            
            case 'podcast':
            default:
                // Apple Podcasts clásico
                if (data.episodeId) {
                    return `<iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0" height="175" style="width:100%;overflow:hidden;border-radius:10px;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.podcasts.apple.com/podcast/id${data.id}?i=${data.episodeId}"></iframe>`;
                } else {
                    return `<iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0" height="450" style="width:100%;overflow:hidden;border-radius:10px;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.podcasts.apple.com/podcast/id${data.id}"></iframe>`;
                }
        }
    }

    generateSpotifyEmbed(data) {
        if (data.type === 'short-link') {
            // Para links cortos, usamos el formato de show por defecto
            return `<iframe style="border-radius:12px" src="https://open.spotify.com/embed/show/${data.id}?utm_source=generator&theme=0" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>`;
        }
        
        const heights = {
            'track': '152',
            'episode': '232',
            'show': '352', 
            'album': '352',
            'playlist': '352',
            'artist': '352'
        };
        
        const height = heights[data.type] || '352';
        
        return `<iframe style="border-radius:12px" src="https://open.spotify.com/embed/${data.type}/${data.id}?utm_source=generator&theme=0" width="100%" height="${height}" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>`;
    }

    generateYouTubeEmbed(data) {
        switch (data.type) {
            case 'playlist':
                return `<iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=${data.id}" title="YouTube playlist player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
            
            case 'shorts':
                return `<iframe width="315" height="560" src="https://www.youtube.com/embed/${data.id}" title="YouTube Shorts player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
            
            case 'channel':
            case 'user':
            case 'handle':
                return `<div style="text-align: center; padding: 20px; background: #f0f0f0; border-radius: 8px;">
                    <p><strong>Canal de YouTube:</strong> ${data.originalUrl}</p>
                    <p>Los canales de YouTube no tienen embed directo. Visita el enlace para ver el contenido.</p>
                    <a href="${data.originalUrl}" target="_blank" style="background: #ff0000; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Ver Canal</a>
                </div>`;
            
            case 'video':
            default:
                return `<iframe width="560" height="315" src="https://www.youtube.com/embed/${data.id}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
        }
    }

    generateEmbed(url) {
        const detection = this.detectPlatform(url);
        
        if (!detection) {
            throw new Error('URL no reconocida. Asegúrate de usar una URL válida de Apple Podcasts, Spotify o YouTube.');
        }

        let embedCode;
        let platformName;
        let badgeClass;

        switch (detection.platform) {
            case 'apple':
                embedCode = this.generateAppleEmbed(detection);
                platformName = detection.type.includes('music') ? 'Apple Music' : 'Apple Podcasts';
                badgeClass = 'apple';
                break;
            case 'spotify':
                embedCode = this.generateSpotifyEmbed(detection);
                platformName = 'Spotify';
                badgeClass = 'spotify';
                break;
            case 'youtube':
                embedCode = this.generateYouTubeEmbed(detection);
                platformName = 'YouTube';
                badgeClass = 'youtube';
                break;
        }

        return {
            platform: platformName,
            badgeClass,
            embedCode,
            detection
        };
    }
}