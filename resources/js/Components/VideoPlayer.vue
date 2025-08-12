<template>
    <div class="video-player-container relative group">
        <!-- Video Element -->
        <video
            ref="videoPlayer"
            class="w-full rounded-xl shadow-lg bg-black aspect-video"
            :poster="poster"
            @click="togglePlay"
            @timeupdate="updateProgress"
            @ended="onVideoEnded"
            @pause="onPause"
            @play="onPlay"
            @waiting="onWaiting"
            @canplay="onCanPlay"
        >
            <source :src="src" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Controls Overlay -->
        <div
            class="controls-overlay absolute inset-0 flex items-end opacity-0 group-hover:opacity-100 transition-opacity duration-300"
            @mouseenter="showControls = true"
            @mouseleave="onMouseLeaveControls"
        >
            <!-- Progress Bar -->
            <div class="progress-container w-full px-4 pb-1">
                <div
                    class="progress-bar bg-gray-300 dark:bg-gray-600 rounded-full h-1.5 cursor-pointer"
                    @click="seekVideo"
                    ref="progressBar"
                >
                    <div
                        class="progress-fill h-full bg-red-500 rounded-full relative"
                        :style="`width: ${progressPercent}%`"
                    >
                        <div class="progress-dot w-3 h-3 bg-red-500 rounded-full absolute -right-1.5 -top-1"></div>
                    </div>
                </div>
            </div>

            <!-- Main Controls -->
            <div class="controls-panel w-full bg-gradient-to-t from-black/80 to-transparent p-4 rounded-b-xl">
                <div class="flex items-center justify-between">
                    <!-- Left Controls -->
                    <div class="flex items-center space-x-4">
                        <button
                            @click.stop="togglePlay"
                            class="text-white hover:text-red-400 transition-colors"
                            aria-label="Play/Pause"
                        >
                            <PlayIcon v-if="!isPlaying" class="h-8 w-8" />
                            <PauseIcon v-else class="h-8 w-8" />
                        </button>

                        <span class="time-display text-white text-sm font-mono">
                            {{ formattedCurrentTime }} / {{ formattedDuration }}
                        </span>
                    </div>

                    <!-- Right Controls -->
                    <div class="flex items-center space-x-3">
                        <!-- Playback Speed -->
                        <select
                            v-model="playbackRate"
                            @change="changeSpeed"
                            class="bg-black/50 text-white text-sm rounded px-2 py-1 focus:outline-none"
                        >
                            <option value="0.5">0.5x</option>
                            <option value="1">1x</option>
                            <option value="1.5">1.5x</option>
                            <option value="2">2x</option>
                        </select>

                        <!-- Volume -->
                        <button
                            @click.stop="toggleMute"
                            class="text-white hover:text-red-400 transition-colors"
                            aria-label="Mute/Unmute"
                        >
<!--                            <VolumeUpIcon v-if="!isMuted" class="h-5 w-5" />-->
<!--                            <VolumeOffIcon v-else class="h-5 w-5" />-->
                        </button>

                        <!-- Fullscreen -->
                        <button
                            @click.stop="toggleFullscreen"
                            class="text-white hover:text-red-400 transition-colors"
                            aria-label="Fullscreen"
                        >
                            <ArrowsPointingOutIcon class="h-5 w-5" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Spinner -->
        <div
            v-if="isLoading"
            class="absolute inset-0 flex items-center justify-center bg-black/50"
        >
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500"></div>
        </div>

        <!-- Big Play Button -->
        <div
            v-if="showBigPlayButton"
            class="absolute inset-0 flex items-center justify-center"
        >
            <button
                @click.stop="togglePlay"
                class="play-button bg-black/50 hover:bg-black/70 rounded-full p-4 text-white transition-all transform hover:scale-110"
                aria-label="Play"
            >
                <PlayIcon class="h-12 w-12" />
            </button>
        </div>
    </div>
</template>

<script>
import {
    PlayIcon,
    PauseIcon,
    // VolumeUpIcon,
    // VolumeOffIcon,
    ArrowsPointingOutIcon
} from '@heroicons/vue/24/outline';

export default {
    name: 'VideoPlayer',
    components: {
        PlayIcon,
        PauseIcon,
        // VolumeUpIcon,
        // VolumeOffIcon,
        ArrowsPointingOutIcon
    },
    props: {
        src: {
            type: String,
            required: true
        },
        poster: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            isPlaying: false,
            isMuted: false,
            isLoading: true,
            showControls: true,
            showBigPlayButton: true,
            currentTime: 0,
            duration: 0,
            playbackRate: 1,
            isFullscreen: false,
            controlsTimeout: null
        };
    },
    computed: {
        progressPercent() {
            return this.duration > 0 ? (this.currentTime / this.duration) * 100 : 0;
        },
        formattedCurrentTime() {
            return this.formatTime(this.currentTime);
        },
        formattedDuration() {
            return this.formatTime(this.duration);
        }
    },
    methods: {
        togglePlay() {
            if (this.$refs.videoPlayer.paused) {
                this.$refs.videoPlayer.play();
                this.showBigPlayButton = false;
            } else {
                this.$refs.videoPlayer.pause();
                this.showBigPlayButton = true;
            }
        },
        toggleMute() {
            this.$refs.videoPlayer.muted = !this.$refs.videoPlayer.muted;
            this.isMuted = this.$refs.videoPlayer.muted;
        },
        toggleFullscreen() {
            if (!this.isFullscreen) {
                this.$refs.videoPlayer.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        },
        changeSpeed() {
            this.$refs.videoPlayer.playbackRate = this.playbackRate;
        },
        updateProgress() {
            this.currentTime = this.$refs.videoPlayer.currentTime;
            this.duration = this.$refs.videoPlayer.duration;
        },
        seekVideo(e) {
            const rect = this.$refs.progressBar.getBoundingClientRect();
            const pos = (e.pageX - rect.left) / rect.width;
            this.$refs.videoPlayer.currentTime = pos * this.$refs.videoPlayer.duration;
        },
        onVideoEnded() {
            this.isPlaying = false;
            this.showBigPlayButton = true;
        },
        onPause() {
            this.isPlaying = false;
            this.showBigPlayButton = true;
        },
        onPlay() {
            this.isPlaying = true;
            this.showBigPlayButton = false;
        },
        onWaiting() {
            this.isLoading = true;
        },
        onCanPlay() {
            this.isLoading = false;
        },
        onMouseLeaveControls() {
            // Hide controls after 2 seconds if not hovering
            this.controlsTimeout = setTimeout(() => {
                if (!this.isPlaying) return;
                this.showControls = false;
            }, 2000);
        },
        formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = Math.floor(seconds % 60);
            return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
        },
        handleKeyDown(e) {
            if (e.code === 'Space') this.togglePlay();
            if (e.code === 'ArrowRight') this.$refs.videoPlayer.currentTime += 5;
            if (e.code === 'ArrowLeft') this.$refs.videoPlayer.currentTime -= 5;
            if (e.code === 'KeyM') this.toggleMute();
        },
        handleFullscreenChange() {
            this.isFullscreen = document.fullscreenElement !== null;
        }
    },
    mounted() {
        document.addEventListener('keydown', this.handleKeyDown);
        document.addEventListener('fullscreenchange', this.handleFullscreenChange);

        // Auto-hide controls after 3 seconds
        this.controlsTimeout = setTimeout(() => {
            if (this.isPlaying) {
                this.showControls = false;
            }
        }, 3000);
    },
    beforeUnmount() {
        document.removeEventListener('keydown', this.handleKeyDown);
        document.removeEventListener('fullscreenchange', this.handleFullscreenChange);
        clearTimeout(this.controlsTimeout);
    }
};
</script>

<style scoped>
.video-player-container {
    position: relative;
    overflow: hidden;
}

.controls-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.controls-overlay * {
    pointer-events: auto;
}

.progress-bar {
    transition: height 0.2s;
}

.progress-bar:hover {
    height: 6px;
}

.progress-fill {
    transition: width 0.1s linear;
}

.play-button {
    backdrop-filter: blur(5px);
    border: 2px solid rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}

.play-button:hover {
    box-shadow: 0 0 0 8px rgba(239, 68, 68, 0.3);
}

/* Fullscreen styles */
:fullscreen .video-player-container {
    width: 100%;
    height: 100%;
    background: #000;
}

:fullscreen video {
    object-fit: contain;
}
</style>
