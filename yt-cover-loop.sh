#!/bin/bash
# ============================================
# YouTube Cover Loop Generator
# Generates a short vertical MP4 loop from a YouTube video
# for use as cover/preview in video cards (9:16 aspect ratio)
# ============================================

set -e

# --- Defaults ---
DURATION=3
START=0
WIDTH=540
HEIGHT=960
OUTPUT_DIR="./assets/video-thumbs"
QUALITY=26  # CRF: lower = better quality, higher = smaller file (18-28 is good)

# --- Colors ---
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m'

usage() {
    echo ""
    echo -e "${CYAN}YouTube Cover Loop Generator${NC}"
    echo -e "Generates a short vertical MP4 loop from a YouTube video"
    echo ""
    echo -e "${YELLOW}Usage:${NC}"
    echo "  ./yt-cover-loop.sh <youtube-url> [options]"
    echo ""
    echo -e "${YELLOW}Options:${NC}"
    echo "  -s, --start <seconds>     Start time in seconds (default: 0)"
    echo "  -d, --duration <seconds>  Duration in seconds (default: 3)"
    echo "  -o, --output <filename>   Output filename without extension (default: auto from video title)"
    echo "  -q, --quality <crf>       Quality 18-28, lower=better (default: 26)"
    echo "  -w, --width <pixels>      Output width (default: 540)"
    echo "  -h, --height <pixels>     Output height (default: 960)"
    echo "  --dir <path>              Output directory (default: ./assets/video-thumbs)"
    echo ""
    echo -e "${YELLOW}Examples:${NC}"
    echo "  # Basic: 3 seconds from start"
    echo "  ./yt-cover-loop.sh https://youtube.com/watch?v=abc123"
    echo ""
    echo "  # Start at 10s, duration 4s"
    echo "  ./yt-cover-loop.sh https://youtube.com/watch?v=abc123 -s 10 -d 4"
    echo ""
    echo "  # Custom name, better quality"
    echo "  ./yt-cover-loop.sh https://youtube.com/watch?v=abc123 -s 30 -o my-cover -q 18"
    echo ""
    exit 0
}

# --- Parse args ---
if [ $# -eq 0 ]; then
    usage
fi

URL="$1"
shift

# Check if first arg is --help
if [ "$URL" = "--help" ] || [ "$URL" = "-h" ]; then
    usage
fi

while [[ $# -gt 0 ]]; do
    case $1 in
        -s|--start) START="$2"; shift 2 ;;
        -d|--duration) DURATION="$2"; shift 2 ;;
        -o|--output) OUTPUT_NAME="$2"; shift 2 ;;
        -q|--quality) QUALITY="$2"; shift 2 ;;
        -w|--width) WIDTH="$2"; shift 2 ;;
        -h|--height) HEIGHT="$2"; shift 2 ;;
        --dir) OUTPUT_DIR="$2"; shift 2 ;;
        --help) usage ;;
        *) echo -e "${RED}Unknown option: $1${NC}"; usage ;;
    esac
done

# --- Validate ---
if ! command -v yt-dlp &> /dev/null; then
    echo -e "${RED}Error: yt-dlp not installed. Run: brew install yt-dlp${NC}"
    exit 1
fi
if ! command -v ffmpeg &> /dev/null; then
    echo -e "${RED}Error: ffmpeg not installed. Run: brew install ffmpeg${NC}"
    exit 1
fi

# --- Create output dir ---
mkdir -p "$OUTPUT_DIR"

# --- Get video title for filename ---
if [ -z "$OUTPUT_NAME" ]; then
    echo -e "${CYAN}Fetching video info...${NC}"
    VIDEO_TITLE=$(yt-dlp --get-title "$URL" 2>/dev/null | head -1)
    # Sanitize: lowercase, replace spaces/special chars with hyphens
    OUTPUT_NAME=$(echo "$VIDEO_TITLE" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9]/-/g' | sed 's/--*/-/g' | sed 's/^-//' | sed 's/-$//' | cut -c1-50)
fi

OUTPUT_FILE="$OUTPUT_DIR/${OUTPUT_NAME}.mp4"
TEMP_FILE=$(mktemp -t yt-cover)

echo ""
echo -e "${CYAN}Downloading video...${NC}"
yt-dlp -f "best[ext=mp4][height<=1080]/best[height<=1080]" \
    -o "$TEMP_FILE" \
    --force-overwrites \
    --no-playlist \
    "$URL"

echo -e "${CYAN}Processing: ${DURATION}s from ${START}s, ${WIDTH}x${HEIGHT} (9:16)${NC}"

# --- FFmpeg: trim + crop to 9:16 center + resize + compress ---
ffmpeg -y \
    -ss "$START" \
    -i "$TEMP_FILE" \
    -t "$DURATION" \
    -vf "crop=ih*9/16:ih,scale=${WIDTH}:${HEIGHT}" \
    -c:v libx264 \
    -preset slow \
    -crf "$QUALITY" \
    -pix_fmt yuv420p \
    -movflags +faststart \
    -an \
    "$OUTPUT_FILE" \
    -loglevel warning

# --- Cleanup ---
rm -f "$TEMP_FILE"

# --- Result ---
FILE_SIZE=$(du -h "$OUTPUT_FILE" | cut -f1)
echo ""
echo -e "${GREEN}Done!${NC}"
echo -e "  File: ${CYAN}${OUTPUT_FILE}${NC}"
echo -e "  Size: ${CYAN}${FILE_SIZE}${NC}"
echo -e "  Dimensions: ${CYAN}${WIDTH}x${HEIGHT}${NC}"
echo -e "  Duration: ${CYAN}${DURATION}s${NC}"
echo ""
