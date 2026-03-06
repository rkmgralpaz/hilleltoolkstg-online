// ============================================
// Block: YouTube Embeds
// Inline video player — mirrors ADL Monitor's UniversalVideoPlayer
// ============================================

import { VideoEmbedGenerator } from '../globals/video-embed-generator.js';

// ============================================
// SVG ICONS (exact copies from ADL Monitor ny-video-player.js)
// ============================================
const icons = {
    play: `<svg class="svg-icon-play-2" width="24" height="24" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 24 24"><path class='svg__stroke' d="M7.8,21h8.4c1.7,0,2.5,0,3.2-.3.6-.3,1-.7,1.3-1.3.3-.6.3-1.5.3-3.2V7.8c0-1.7,0-2.5-.3-3.2-.3-.6-.7-1-1.3-1.3-.6-.3-1.5-.3-3.2-.3H7.8c-1.7,0-2.5,0-3.2.3-.6.3-1,.7-1.3,1.3-.3.6-.3,1.5-.3,3.2v8.4c0,1.7,0,2.5.3,3.2.3.6.7,1,1.3,1.3.6.3,1.5.3,3.2.3ZM9.8,15.6v-7.2l6,3.6-6,3.6Z" stroke="#F8F7F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" /></svg>`,
    pause: `<svg class="svg-icon-pause-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path class='svg__stroke' d="M9.5 15V9M14.5 15V9M7.8 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V7.8C21 6.11984 21 5.27976 20.673 4.63803C20.3854 4.07354 19.9265 3.6146 19.362 3.32698C18.7202 3 17.8802 3 16.2 3H7.8C6.11984 3 5.27976 3 4.63803 3.32698C4.07354 3.6146 3.6146 4.07354 3.32698 4.63803C3 5.27976 3 6.11984 3 7.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21Z" stroke="#F8F7F6" stroke-width="1.5" stroke-linecap="square"/></svg>`,
    mute: `<svg class="svg-icon-mute-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path class='svg__stroke' d="M22 8.99993L16 14.9999M16 8.99993L22 14.9999M9.63432 4.36561L6.46863 7.5313C6.29568 7.70425 6.2092 7.79073 6.10828 7.85257C6.01881 7.9074 5.92127 7.9478 5.81923 7.9723C5.70414 7.99993 5.58185 7.99993 5.33726 7.99993H3.6C3.03995 7.99993 2.75992 7.99993 2.54601 8.10892C2.35785 8.20479 2.20487 8.35777 2.10899 8.54594C2 8.75985 2 9.03987 2 9.59993V14.3999C2 14.96 2 15.24 2.10899 15.4539C2.20487 15.6421 2.35785 15.7951 2.54601 15.8909C2.75992 15.9999 3.03995 15.9999 3.6 15.9999H5.33726C5.58185 15.9999 5.70414 15.9999 5.81923 16.0276C5.92127 16.0521 6.01881 16.0925 6.10828 16.1473C6.2092 16.2091 6.29568 16.2956 6.46863 16.4686L9.63431 19.6342C10.0627 20.0626 10.2769 20.2768 10.4608 20.2913C10.6203 20.3038 10.7763 20.2392 10.8802 20.1175C11 19.9773 11 19.6744 11 19.0686V4.9313C11 4.32548 11 4.02257 10.8802 3.88231C10.7763 3.76061 10.6203 3.69602 10.4608 3.70858C10.2769 3.72305 10.0627 3.93724 9.63432 4.36561Z" stroke="#F8F7F6" stroke-width="1.5" stroke-linecap="square"/></svg>`,
    unmute: `<svg class="svg-icon-unmute" width="24" height="24" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 24 24"><path class="svg__stroke" d="M9.6,4.4l-3.2,3.2c-.2.2-.3.3-.4.3,0,0-.2,0-.3.1-.1,0-.2,0-.5,0h-1.7c-.6,0-.8,0-1.1.1-.2,0-.3.2-.4.4-.1.2-.1.5-.1,1.1v4.8c0,.6,0,.8.1,1.1,0,.2.2.3.4.4.2.1.5.1,1.1.1h1.7c.2,0,.4,0,.5,0,.1,0,.2,0,.3.1.1,0,.2.1.4.3l3.2,3.2c.4.4.6.6.8.7.2,0,.3,0,.4-.2.1-.1.1-.4.1-1V4.9c0-.6,0-.9-.1-1-.1-.1-.3-.2-.4-.2-.2,0-.4.2-.8.7ZM17.1,9v6M21.6,6.5v11.1" fill="none" stroke="#F8F7F6" stroke-linecap="round" stroke-width="1.5" /></svg>`,
    captions: `<svg class="svg-icon-captions" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="svg__fill" d="M7.5,17.9c-.8,0-1.6-.2-2.2-.7s-1.2-1.2-1.5-2.1c-.4-.9-.6-1.9-.6-3.1s.2-2.3.6-3.1.9-1.6,1.5-2.1,1.4-.7,2.2-.7,1,0,1.4.3c.4.2.8.4,1.2.8.3.3.6.8.9,1.2s.4,1,.5,1.6h-1.4c0-.4-.2-.7-.3-1s-.3-.5-.6-.7c-.2-.2-.5-.4-.7-.5-.3-.1-.6-.2-.9-.2-.6,0-1.1.2-1.5.5-.4.4-.8.9-1,1.5-.2.7-.4,1.4-.4,2.3s.1,1.7.4,2.3.6,1.1,1,1.5.9.5,1.5.5.6,0,.9-.2c.3-.1.5-.3.7-.5s.4-.4.6-.7.3-.6.3-1h1.4c0,.6-.2,1.1-.5,1.6-.2.5-.5.9-.9,1.2s-.7.6-1.2.8c-.4.2-.9.3-1.4.3Z"/><path class="svg__fill" d="M16.9,17.9c-.8,0-1.6-.2-2.2-.7s-1.2-1.2-1.5-2.1c-.4-.9-.6-1.9-.6-3.1s.2-2.3.6-3.1.9-1.6,1.5-2.1,1.4-.7,2.2-.7,1,0,1.4.3c.4.2.8.4,1.2.8.3.3.6.8.9,1.2s.4,1,.5,1.6h-1.4c0-.4-.2-.7-.3-1s-.3-.5-.6-.7c-.2-.2-.5-.4-.7-.5-.3-.1-.6-.2-.9-.2-.6,0-1.1.2-1.5.5-.4.4-.8.9-1,1.5-.2.7-.4,1.4-.4,2.3s.1,1.7.4,2.3.6,1.1,1,1.5.9.5,1.5.5.6,0,.9-.2c.3-.1.5-.3.7-.5s.4-.4.6-.7.3-.6.3-1h1.4c0,.6-.2,1.1-.5,1.6-.2.5-.5.9-.9,1.2s-.7.6-1.2.8c-.4.2-.9.3-1.4.3Z"/></svg>`,
    captionsOff: `<svg class="svg-icon-captions-off" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="svg__fill" d="M20.4,15.6c.2-.5.4-1,.5-1.6h-1.4c0,.4-.2.7-.3,1-.2.3-.3.5-.6.7s-.5.4-.7.5c-.1,0-.2,0-.3,0l-3.4-3.5c0-.3,0-.5,0-.8,0-.9.1-1.7.4-2.3.2-.7.6-1.2,1-1.5.4-.3.9-.5,1.5-.5s.6,0,.9.2c.3.1.5.3.7.5.2.2.4.5.6.7.2.3.3.6.3,1h1.4c0-.6-.2-1.2-.5-1.6-.2-.5-.5-.9-.9-1.2-.3-.3-.7-.6-1.2-.8-.4-.2-.9-.3-1.4-.3-.8,0-1.6.2-2.2.7-.7.5-1.2,1.2-1.5,2.1-.3.7-.5,1.5-.5,2.5L4.4,3l-1.1,1,2.4,2.4c-.2,0-.3.2-.5.3-.7.5-1.2,1.2-1.5,2.1-.4.9-.6,1.9-.6,3.1s.2,2.2.6,3.1c.4.9.9,1.6,1.5,2.1.7.5,1.4.7,2.2.7s1,0,1.4-.3c.4-.2.8-.5,1.2-.8.3-.3.6-.8.9-1.2.2-.5.4-1,.5-1.6h-1.4c0,.4-.2.7-.3,1-.2.3-.3.5-.6.7-.2.2-.5.4-.7.5-.3.1-.6.2-.9.2-.6,0-1.1-.2-1.5-.5-.4-.3-.8-.8-1-1.5-.2-.6-.4-1.4-.4-2.3s.1-1.7.4-2.3c.2-.7.6-1.2,1-1.5.3-.2.6-.4,1-.5l12.8,13.1,1.1-1-2.2-2.2c.3-.2.6-.4.9-.7.3-.3.6-.8.9-1.2Z"/></svg>`,
    playLarge: `<svg width="28" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><polygon points="5,3 19,12 5,21" fill="#fff"/></svg>`
};

// ============================================
// YouTube IFrame API Loader
// ============================================
const YTLoader = {
    loaded: false,
    loading: false,
    callbacks: [],
    load() {
        return new Promise((resolve) => {
            if (window.YT && window.YT.Player) { this.loaded = true; resolve(); return; }
            if (this.loading) { this.callbacks.push(resolve); return; }
            this.loading = true;
            this.callbacks.push(resolve);
            const tag = document.createElement('script');
            tag.src = 'https://www.youtube.com/iframe_api';
            window.onYouTubeIframeAPIReady = () => {
                this.loaded = true; this.loading = false;
                this.callbacks.forEach(cb => cb());
                this.callbacks = [];
            };
            document.head.appendChild(tag);
        });
    }
};

// Unique ID counter (avoids id collisions when multiple cards exist)
let uid = 0;

// Global registry — only one player active at a time
const activePlayers = [];

function resetAllExcept(current) {
    activePlayers.forEach(p => {
        if (p !== current && p.playerReady) p.reset();
    });
}

// ============================================
// INLINE CARD PLAYER
// ============================================
class InlineCardPlayer {
    constructor(wrapper) {
        this.wrapper = wrapper;
        this.uid = ++uid;
        this.mode = wrapper.dataset.mode || 'url';
        this.videoSrc = wrapper.dataset.videoSrc || '';
        this.posterUrl = wrapper.dataset.poster || '';
        this.thumbUrl = wrapper.dataset.videoThumb || '';
        this.platform = wrapper.dataset.platform || '';
        this.videoId = wrapper.dataset.videoId || '';
        this.autoplayLoop = wrapper.dataset.autoplayLoop === '1';

        // Fallback: detect platform/ID from URL via VideoEmbedGenerator
        if (this.videoSrc && (!this.platform || (this.platform === 'youtube' && !this.videoId))) {
            const det = new VideoEmbedGenerator().detectPlatform(this.videoSrc);
            if (det) { this.platform = det.platform; this.videoId = det.id; }
        }
        if (this.mode === 'file') this.platform = 'html5';

        this.subs = [];
        try { this.subs = JSON.parse(wrapper.dataset.subs || '[]'); } catch (e) { this.subs = []; }

        this.player = null;
        this.playerType = null;
        this.isPlaying = false;
        this.isMuted = false;
        this.showSubs = false;
        this.duration = 0;
        this.currentTime = 0;
        this.volume = 1;
        this.updateInterval = null;
        this.playerReady = false;
        this._shouldAutoplayOnReady = false;

        this.elements = {};

        this.render();
    }

    // ============================================
    // RENDER — always starts with preview/poster
    // ============================================
    render() {
        // Priority:
        // 1. autoplay_loop=true + video thumb → loop mp4 (poster is ignored)
        // 2. Has poster → show poster image
        // 3. Nothing → black background
        // Loop ONLY happens when autoplay_loop is true.

        let previewContent = '';

        if (this.autoplayLoop && this.thumbUrl) {
            // Looping mp4 preview — no poster shown
            previewContent = `<video class="video-preview-loop" muted autoplay loop playsinline webkit-playsinline preload="metadata" src="${this.thumbUrl}"></video>`;
        } else if (this.posterUrl) {
            // Static poster image
            previewContent = `<img class="video-poster-img" src="${this.posterUrl}" alt="" draggable="false" />`;
        }

        this.wrapper.innerHTML = `
            ${previewContent}
            <button class="yt-embed-play-btn" aria-label="Play video">${icons.playLarge}</button>
        `;

        // Mark as loaded once the preview content is ready
        const loopVid = this.wrapper.querySelector('.video-preview-loop');
        const posterImg = this.wrapper.querySelector('.video-poster-img');

        if (loopVid) {
            loopVid.addEventListener('canplay', () => this.wrapper.classList.add('loaded'), { once: true });
        } else if (posterImg) {
            if (posterImg.complete) {
                this.wrapper.classList.add('loaded');
            } else {
                posterImg.addEventListener('load', () => this.wrapper.classList.add('loaded'), { once: true });
            }
        } else {
            // No preview — just show the play button
            this.wrapper.classList.add('loaded');
        }

        // Click anywhere on card → activate real player
        const onClick = (e) => {
            e.stopPropagation();
            this.wrapper.removeEventListener('click', onClick);
            this.activatePlayer();
        };
        this.wrapper.addEventListener('click', onClick);
    }

    // ============================================
    // ACTIVATE REAL PLAYER (on click)
    // Replaces preview with ADL Monitor–style player UI
    // ============================================
    async activatePlayer() {
        if (this.playerReady) return;

        // Flag to autoplay when ready (user clicked, so it's allowed)
        this._shouldAutoplayOnReady = true;

        // Register in global list and reset all others back to cover
        if (!activePlayers.includes(this)) activePlayers.push(this);
        resetAllExcept(this);

        // Add loading state (shows spinner, keeps cover visible)
        this.wrapper.classList.add('loading');

        // Keep the loop video as overlay while the real player loads underneath
        const loopVideo = this.wrapper.querySelector('.video-preview-loop');
        if (loopVideo) {
            loopVideo.classList.add('video-preview-overlay');
            this._loopOverlay = loopVideo;
        }

        // Keep poster image visible during loading
        const posterImg = this.wrapper.querySelector('.video-poster-img');
        if (posterImg) {
            posterImg.classList.add('video-preview-overlay');
            this._posterOverlay = posterImg;
        }

        // Safety fallback: remove loading and overlay after 3s if not already removed
        this._overlayTimeout = setTimeout(() => {
            this.removeLoadingAndOverlay();
        }, 3000);

        // Remove only the play button (keep poster/loop visible with loading spinner)
        const playBtn = this.wrapper.querySelector('.yt-embed-play-btn');
        if (playBtn) playBtn.remove();

        const holderId = `video-holder-${this.uid}`;
        const posterId = `video-poster-${this.uid}`;

        // Build player UI — append alongside the loop overlay (don't replace innerHTML)
        const playerHTML = document.createElement('div');
        playerHTML.className = 'video-player-wrapper';
        playerHTML.innerHTML = `
            <div class="video-poster" id="${posterId}"></div>
            <div class="video-holder" id="${holderId}"></div>
            <div class="video-subs"></div>
            <div class="video-controls">
                <div class="progress-bar">
                    <div class="progress-bar-fill"></div>
                </div>
                <div class="controls-row">
                    <div class="controls-col">
                        <button class="control-btn play-pause-btn btn btn--frosted btn--puffy btn--icon-after btn--icon-only btn--unhoverable" aria-label="Play/Pause">
                            <div class="btn__holder"><div class="btn__icon">${icons.play}</div></div>
                        </button>
                        <span class="time-display">0:00 / 0:00</span>
                        <div class="volume-control">
                            <button class="control-btn mute-btn btn btn--frosted btn--puffy btn--icon-after btn--icon-only btn--unhoverable" aria-label="Mute">
                                <div class="btn__holder"><div class="btn__icon">${icons.mute}</div></div>
                            </button>
                            <input type="range" class="volume-slider" min="0" max="100" value="100">
                        </div>
                        <button class="captions-btn control-btn btn btn--frosted btn--puffy btn--icon-after btn--icon-only btn--unhoverable" aria-label="Closed Captions">
                            <div class="btn__holder"><div class="btn__icon">${icons.captions}</div></div>
                        </button>
                    </div>
                </div>
            </div>
        `;
        this.wrapper.appendChild(playerHTML);

        // Cache elements (scoped to this wrapper)
        const w = this.wrapper;
        this.elements = {
            poster:        w.querySelector('.video-poster'),
            holder:        w.querySelector('.video-holder'),
            playPauseBtn:  w.querySelector('.play-pause-btn'),
            playPauseBtnIcon: w.querySelector('.play-pause-btn .btn__icon'),
            muteBtn:       w.querySelector('.mute-btn'),
            muteBtnIcon:   w.querySelector('.mute-btn .btn__icon'),
            subsBtn:       w.querySelector('.captions-btn'),
            subsBtnIcon:   w.querySelector('.captions-btn .btn__icon'),
            timeDisplay:   w.querySelector('.time-display'),
            progressBar:   w.querySelector('.progress-bar'),
            progressFill:  w.querySelector('.progress-bar-fill'),
            volumeSlider:  w.querySelector('.volume-slider'),
            controls:      w.querySelector('.video-controls'),
            subs:          w.querySelector('.video-subs'),
        };

        // Show poster while player loads (only if no loop overlay)
        if (this.posterUrl && !this._loopOverlay) {
            this.elements.poster.style.backgroundImage = `url(${this.posterUrl})`;
        }

        // Init the right player type
        const isIOS = /iP(ad|hone|od)/.test(navigator.userAgent) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);

        if (this.platform === 'youtube' && this.videoId) {
            await YTLoader.load();
            const ytDiv = document.createElement('div');
            ytDiv.id = `yt-player-${this.uid}`;
            this.elements.holder.appendChild(ytDiv);

            this.player = new YT.Player(ytDiv.id, {
                videoId: this.videoId,
                playerVars: {
                    controls: 0,
                    modestbranding: 1,
                    rel: 0,
                    playsinline: 1,
                    autoplay: 1,
                    mute: isIOS ? 1 : 0,
                    iv_load_policy: 3,
                    disablekb: 1,
                    fs: 0
                },
                events: {
                    onReady: () => {
                        this.playerType = 'youtube';
                        this.playerReady = true;
                        this.duration = this.player.getDuration();
                        this.isMuted = isIOS;
                        this.updateMuteIcon();

                        // Remove loop overlay immediately when player is ready (mobile fix)
                        this.removeLoopOverlay();

                        // Show video holder immediately (mobile fix - don't wait for playback)
                        this.elements.holder.style.opacity = 1;

                        // Captions setup — ON by default, OFF only if user disabled
                        if (this.subs.length) {
                            this.elements.subsBtn.classList.add('show');
                            if (localStorage.getItem('hillelVideoCaptions') !== 'false') {
                                requestAnimationFrame(() => this.elements.subsBtn.click());
                            }
                        }

                        // Click on holder = play/pause
                        this.elements.holder.onclick = () => this.elements.playPauseBtn.click();

                        // iOS auto-muted → unmute on first interaction
                        if (isIOS) {
                            setTimeout(() => this.elements.muteBtn.click(), 150);
                        }

                        // Autoplay if user clicked (mobile fix - trigger play immediately)
                        if (this._shouldAutoplayOnReady) {
                            this._shouldAutoplayOnReady = false;
                            setTimeout(() => {
                                this.player.playVideo();
                            }, 100);
                        }

                        this.startUpdateLoop();
                    },
                    onStateChange: (e) => {
                        this.isPlaying = (e.data === YT.PlayerState.PLAYING);
                        this.updatePlayPauseButton();
                        if (this.isPlaying) {
                            this.removeLoopOverlay();
                            this.startUpdateLoop();
                        } else {
                            this.stopUpdateLoop();
                        }
                    }
                }
            });
        } else if (this.videoSrc) {
            // HTML5
            this.playerType = 'html5';

            // Captions setup — ON by default, OFF only if user disabled
            if (this.subs.length) {
                this.elements.subsBtn.classList.add('show');
                if (localStorage.getItem('hillelVideoCaptions') !== 'false') {
                    requestAnimationFrame(() => this.elements.subsBtn.click());
                }
            }

            this.elements.holder.innerHTML = `
                <video playsinline webkit-playsinline autoplay>
                    <source src="${this.videoSrc}" type="video/mp4">
                </video>
            `;
            if (this.posterUrl && !this._loopOverlay) {
                this.elements.poster.style.backgroundImage = `url(${this.posterUrl})`;
            }

            this.player = this.elements.holder.querySelector('video');
            this.playerReady = true;

            // Remove loop overlay immediately when player is ready (mobile fix)
            this.removeLoopOverlay();

            // Show video holder immediately (mobile fix)
            this.elements.holder.style.opacity = 1;

            this.elements.holder.onclick = () => this.elements.playPauseBtn.click();

            this.player.addEventListener('loadedmetadata', () => {
                this.duration = this.player.duration;

                // Autoplay if user clicked (mobile fix - trigger play immediately)
                if (this._shouldAutoplayOnReady) {
                    this._shouldAutoplayOnReady = false;
                    this.player.play().catch(() => {});
                }
            });
            this.player.addEventListener('play', () => {
                this.isPlaying = true;
                this.removeLoopOverlay();
                this.updatePlayPauseButton();
                this.startUpdateLoop();
            });
            this.player.addEventListener('pause', () => {
                this.isPlaying = false;
                this.updatePlayPauseButton();
                this.stopUpdateLoop();
            });
            this.player.addEventListener('ended', () => {
                this.isPlaying = false;
                this.updatePlayPauseButton();
                this.stopUpdateLoop();
            });
            this.player.addEventListener('timeupdate', () => {
                this.currentTime = this.player.currentTime;
            });

            this.startUpdateLoop();
        }

        this.attachControlEvents();
    }

    // Remove the loading state and overlays once the real video is ready
    removeLoadingAndOverlay() {
        if (this._overlayTimeout) {
            clearTimeout(this._overlayTimeout);
            this._overlayTimeout = null;
        }
        // Remove loading state
        this.wrapper.classList.remove('loading');

        // Remove loop overlay
        if (this._loopOverlay) {
            this._loopOverlay.remove();
            this._loopOverlay = null;
        }

        // Remove poster overlay
        if (this._posterOverlay) {
            this._posterOverlay.remove();
            this._posterOverlay = null;
        }
    }

    // Backwards compatibility alias
    removeLoopOverlay() {
        this.removeLoadingAndOverlay();
    }

    // ============================================
    // UNIFIED CONTROLS (mirrors ADL Monitor)
    // ============================================
    play() {
        resetAllExcept(this);
        if (this.playerType === 'youtube') this.player.playVideo();
        else if (this.playerType === 'html5') this.player.play().catch(() => {});
    }
    pause() {
        if (this.playerType === 'youtube') this.player.pauseVideo();
        else if (this.playerType === 'html5') this.player.pause();
    }
    seekTo(seconds) {
        if (this.playerType === 'youtube') this.player.seekTo(seconds, true);
        else if (this.playerType === 'html5') this.player.currentTime = seconds;
    }
    setVolume(volume) {
        this.volume = volume;
        if (this.playerType === 'youtube') this.player.setVolume(volume * 100);
        else if (this.playerType === 'html5') this.player.volume = volume;
    }
    mute() {
        if (this.playerType === 'youtube') this.player.mute();
        else if (this.playerType === 'html5') this.player.muted = true;
        this.isMuted = true;
        this.updateMuteIcon();
    }
    unmute() {
        if (this.playerType === 'youtube') this.player.unMute();
        else if (this.playerType === 'html5') this.player.muted = false;
        this.isMuted = false;
        this.updateMuteIcon();
    }
    getCurrentTime() {
        if (this.playerType === 'youtube') return this.player.getCurrentTime();
        if (this.playerType === 'html5') return this.player.currentTime;
        return 0;
    }

    // ============================================
    // UI UPDATES
    // ============================================
    updatePlayPauseButton() {
        if (!this.elements.playPauseBtnIcon) return;
        this.elements.playPauseBtnIcon.innerHTML = this.isPlaying ? icons.pause : icons.play;
    }
    updateMuteIcon() {
        if (!this.elements.muteBtnIcon) return;
        this.elements.muteBtnIcon.innerHTML = this.isMuted ? icons.unmute : icons.mute;
    }
    formatTime(seconds) {
        if (!seconds || isNaN(seconds)) return '0:00';
        const m = Math.floor(seconds / 60);
        const s = Math.floor(seconds % 60);
        return `${m}:${s.toString().padStart(2, '0')}`;
    }

    updateProgress() {
        const current = this.getCurrentTime();
        this.currentTime = current;
        if (this.duration > 0) {
            const pct = (current / this.duration) * 100;
            this.elements.progressFill.style.width = `${pct}%`;
            this.elements.timeDisplay.textContent = `${this.formatTime(current)} / ${this.formatTime(this.duration)}`;
        }
        this.updateSubtitle(current);
    }

    updateSubtitle(currentTime) {
        if (!this.elements.subs) return;
        if (!this.showSubs || !this.subs.length) {
            this.elements.subs.textContent = '';
            this.elements.subs.style.display = 'none';
            this.elements.subs.removeAttribute('aria-label');
            return;
        }
        const time = currentTime * 1000;
        const active = this.subs.find(s => time >= s.start && time <= s.end);
        if (active) {
            this.elements.subs.textContent = active.text;
            this.elements.subs.style.display = 'block';
            this.elements.subs.setAttribute('aria-label', active.text);
        } else {
            this.elements.subs.style.display = 'none';
            this.elements.subs.removeAttribute('aria-label');
        }
    }

    startUpdateLoop() {
        this.stopUpdateLoop();
        this.updateInterval = setInterval(() => {
            if (this.playerReady) this.updateProgress();
        }, 100);
    }
    stopUpdateLoop() {
        if (this.updateInterval) { clearInterval(this.updateInterval); this.updateInterval = null; }
    }

    // ============================================
    // RESET — destroy player and return to cover/preview
    // ============================================
    reset() {
        this.stopUpdateLoop();

        // Destroy active player
        if (this.player) {
            if (this.playerType === 'youtube') {
                try { this.player.destroy(); } catch (e) {}
            } else if (this.playerType === 'html5') {
                this.player.pause();
                this.player.removeAttribute('src');
                this.player.load();
            }
            this.player = null;
        }

        // Reset state
        this.playerType = null;
        this.isPlaying = false;
        this.playerReady = false;
        this.duration = 0;
        this.currentTime = 0;
        this.showSubs = false;
        this.elements = {};
        this._loopOverlay = null;

        // Clear wrapper and re-render the preview (poster/thumb + play button)
        this.wrapper.innerHTML = '';
        this.render();
    }

    // ============================================
    // EVENT HANDLERS (mirrors ADL Monitor)
    // ============================================
    attachControlEvents() {
        if (!this.elements.playPauseBtn) return;

        // Play/Pause
        this.elements.playPauseBtn.addEventListener('click', () => {
            if (this.isPlaying) this.pause(); else this.play();
        });

        // Mute/Unmute
        this.elements.muteBtn.addEventListener('click', () => {
            if (this.isMuted) this.unmute(); else this.mute();
        });

        // Subs toggle
        this.elements.subsBtn.addEventListener('click', () => {
            this.showSubs = !this.showSubs;
            if (this.showSubs) {
                this.elements.subsBtnIcon.innerHTML = icons.captionsOff;
                localStorage.setItem('hillelVideoCaptions', 'true');
            } else {
                this.elements.subsBtnIcon.innerHTML = icons.captions;
                localStorage.setItem('hillelVideoCaptions', 'false');
            }
            this.updateSubtitle(this.currentTime);
        });

        // Volume slider
        this.elements.volumeSlider.addEventListener('input', (e) => {
            const vol = e.target.value / 100;
            this.setVolume(vol);
            if (this.isMuted) this.unmute();
        });

        // Progress bar seek
        this.elements.progressBar.addEventListener('click', (e) => {
            const rect = this.elements.progressBar.getBoundingClientRect();
            const pct = (e.clientX - rect.left) / rect.width;
            const seekTime = pct * this.duration;
            this.seekTo(seekTime);
        });

        // Touch: show controls
        let hideTimeout;
        this.wrapper.addEventListener('touchstart', () => {
            this.elements.controls.classList.add('show');
            clearTimeout(hideTimeout);
            hideTimeout = setTimeout(() => {
                this.elements.controls.classList.remove('show');
            }, 3000);
        });
    }
}

// ============================================
// MODULE ENTRY
// ============================================
const startModule = (block) => {
    const wrappers = block.querySelectorAll('.block-youtube-embeds__item-video-wrapper');
    wrappers.forEach(w => new InlineCardPlayer(w));
    block.classList.add('loaded');
};

export { startModule };
