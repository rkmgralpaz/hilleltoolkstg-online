#!/bin/bash
# ============================================
# YouTube Captions Generator with Whisper AI
# Extracts audio from YouTube and generates captions using OpenAI Whisper
# Converts to JSON format compatible with Hillel video embeds
# ============================================

set -e

# --- Defaults ---
LANGUAGE="English"
OUTPUT_DIR="./assets/captions"
MODEL="base"  # tiny, base, small, medium, large

# --- Colors ---
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m'

usage() {
    echo ""
    echo -e "${CYAN}YouTube Captions Generator (Whisper AI)${NC}"
    echo -e "Generates captions from YouTube video audio using AI"
    echo ""
    echo -e "${YELLOW}Usage:${NC}"
    echo "  ./yt-captions-whisper.sh <youtube-url> [options]"
    echo ""
    echo -e "${YELLOW}Options:${NC}"
    echo "  -l, --language <lang>    Language: English, Spanish, French, German, etc (default: English)"
    echo "  -m, --model <model>      Whisper model: tiny, base, small, medium, large (default: base)"
    echo "                           tiny=fast but less accurate, large=slower but most accurate"
    echo "  -o, --output <filename>  Output filename without extension (default: auto from video title)"
    echo "  --dir <path>             Output directory (default: ./assets/captions)"
    echo "  --copy                   Copy JSON to clipboard (macOS)"
    echo ""
    echo -e "${YELLOW}Examples:${NC}"
    echo "  # Basic: English captions with base model (10-20 min)"
    echo "  ./yt-captions-whisper.sh https://youtube.com/watch?v=abc123"
    echo ""
    echo "  # Faster: tiny model (5-10 min, less accurate)"
    echo "  ./yt-captions-whisper.sh https://youtube.com/watch?v=abc123 -m tiny"
    echo ""
    echo "  # Better quality: small model (20-30 min)"
    echo "  ./yt-captions-whisper.sh https://youtube.com/watch?v=abc123 -m small"
    echo ""
    echo "  # Spanish captions, copy to clipboard"
    echo "  ./yt-captions-whisper.sh https://youtube.com/watch?v=abc123 -l Spanish --copy"
    echo ""
    exit 0
}

# --- Parse args ---
if [ $# -eq 0 ]; then
    usage
fi

URL="$1"
shift

if [ "$URL" = "--help" ] || [ "$URL" = "-h" ]; then
    usage
fi

COPY_TO_CLIPBOARD=0

while [[ $# -gt 0 ]]; do
    case $1 in
        -l|--language) LANGUAGE="$2"; shift 2 ;;
        -m|--model) MODEL="$2"; shift 2 ;;
        -o|--output) OUTPUT_NAME="$2"; shift 2 ;;
        --dir) OUTPUT_DIR="$2"; shift 2 ;;
        --copy) COPY_TO_CLIPBOARD=1; shift ;;
        --help) usage ;;
        *) echo -e "${RED}Unknown option: $1${NC}"; usage ;;
    esac
done

# --- Validate ---
if ! command -v yt-dlp &> /dev/null; then
    echo -e "${RED}Error: yt-dlp not installed. Run: brew install yt-dlp${NC}"
    exit 1
fi

if ! command -v whisper &> /dev/null; then
    echo -e "${RED}Error: Whisper not installed. Run: pip3 install openai-whisper${NC}"
    exit 1
fi

if ! command -v python3 &> /dev/null; then
    echo -e "${RED}Error: python3 not installed${NC}"
    exit 1
fi

# --- Create output dir ---
mkdir -p "$OUTPUT_DIR"

# --- Get video title for filename ---
if [ -z "$OUTPUT_NAME" ]; then
    echo -e "${CYAN}Fetching video info...${NC}"
    VIDEO_TITLE=$(yt-dlp --get-title "$URL" 2>/dev/null | head -1)
    OUTPUT_NAME=$(echo "$VIDEO_TITLE" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9]/-/g' | sed 's/--*/-/g' | sed 's/^-//' | sed 's/-$//' | cut -c1-50)
fi

OUTPUT_JSON="$OUTPUT_DIR/${OUTPUT_NAME}.srt"
TEMP_AUDIO=$(mktemp -t yt-audio)
TEMP_VTT=$(mktemp -t yt-captions)

echo ""
echo -e "${CYAN}Downloading audio...${NC}"

# --- Download audio only (try multiple formats) ---
AUDIO_FILE="${TEMP_AUDIO}.m4a"

if yt-dlp -f "bestaudio/best" \
    -x --audio-format m4a \
    -o "${TEMP_AUDIO}.%(ext)s" \
    --quiet \
    "$URL"; then
    # Check if file was actually created
    if [ ! -f "$AUDIO_FILE" ]; then
        # Try with mp3 instead
        AUDIO_FILE="${TEMP_AUDIO}.mp3"
        yt-dlp -f "bestaudio/best" \
            -x --audio-format mp3 \
            -o "${TEMP_AUDIO}.%(ext)s" \
            --quiet \
            "$URL"
    fi
else
    echo -e "${RED}Error: Failed to download audio${NC}"
    rm -f "$TEMP_AUDIO" "$TEMP_VTT"
    exit 1
fi

if [ ! -f "$AUDIO_FILE" ]; then
    echo -e "${RED}Error: Audio file not found at $AUDIO_FILE${NC}"
    ls -lh "$TEMP_AUDIO"* 2>/dev/null || echo "No temp files found"
    rm -f "$TEMP_AUDIO"* "$TEMP_VTT"
    exit 1
fi

echo -e "${GREEN}✓ Audio downloaded: $(du -h "$AUDIO_FILE" | cut -f1)${NC}"

echo -e "${CYAN}Generating captions with Whisper (model: ${MODEL}, language: ${LANGUAGE})...${NC}"
echo -e "${CYAN}Input: $AUDIO_FILE ($(du -h "$AUDIO_FILE" | cut -f1))${NC}"
echo -e "${YELLOW}This may take a few minutes depending on video length and model size${NC}"

# --- Run Whisper with better error handling ---
if ! whisper "$AUDIO_FILE" \
    --model "$MODEL" \
    --language "$LANGUAGE" \
    --output_format vtt \
    --output_dir /tmp \
    --verbose False; then
    echo -e "${RED}Error: Whisper generation failed${NC}"
    echo -e "${RED}Try running manually: whisper \"$AUDIO_FILE\" --model $MODEL --language \"$LANGUAGE\"${NC}"
    rm -f "$TEMP_AUDIO"* "$TEMP_VTT"
    exit 1
fi

# --- Find generated VTT (Whisper creates it from the audio filename) ---
echo -e "${CYAN}Looking for generated VTT file...${NC}"

# Get the base filename without extension
AUDIO_BASE=$(basename "$AUDIO_FILE" | sed 's/\.[^.]*$//')

# Whisper outputs to the same directory with .vtt extension
VTT_FILE="/tmp/${AUDIO_BASE}.vtt"

# If not found, search more broadly
if [ ! -f "$VTT_FILE" ]; then
    VTT_FILE=$(find /tmp -name "${AUDIO_BASE}.vtt" -type f 2>/dev/null | head -1)
fi

# If still not found, get the most recent .vtt file
if [ ! -f "$VTT_FILE" ]; then
    VTT_FILE=$(ls -t /tmp/*.vtt 2>/dev/null | head -1)
fi

if [ -z "$VTT_FILE" ] || [ ! -f "$VTT_FILE" ]; then
    echo -e "${RED}Error: VTT file not found${NC}"
    echo -e "${YELLOW}Expected: $VTT_FILE${NC}"
    echo -e "${YELLOW}Recent VTT files in /tmp:${NC}"
    ls -lht /tmp/*.vtt 2>/dev/null | head -5 || echo "None found"
    rm -f "$TEMP_AUDIO"* "$TEMP_VTT"
    exit 1
fi

echo -e "${GREEN}✓ VTT generated: $(basename "$VTT_FILE") ($(du -h "$VTT_FILE" | cut -f1))${NC}"

echo -e "${CYAN}Converting VTT to SRT format (for ACF)...${NC}"

# --- Create Python converter script (VTT to SRT) ---
cat > /tmp/vtt-to-srt.py << 'EOF'
import re
import sys
import os

vtt_file = sys.argv[1]

if not os.path.exists(vtt_file):
    print("Error: VTT file not found", file=sys.stderr)
    sys.exit(1)

subtitles = []
counter = 1

with open(vtt_file, 'r', encoding='utf-8') as f:
    content = f.read()

# Split by double newlines to get subtitle blocks
blocks = content.strip().split('\n\n')

for block in blocks:
    lines = block.strip().split('\n')
    if len(lines) < 2:
        continue

    timecode = lines[0].strip()

    # Skip WEBVTT header and invalid lines
    if 'WEBVTT' in timecode or '-->' not in timecode:
        continue

    # Parse times - handle both HH:MM:SS.ms and MM:SS.ms formats
    # Try HH:MM:SS format first
    time_match = re.match(r'(\d{2}):(\d{2}):(\d{2})\.(\d{3})\s+-->\s+(\d{2}):(\d{2}):(\d{2})\.(\d{3})', timecode)

    if time_match:
        # HH:MM:SS format - keep milliseconds as is (3 digits)
        start_str = f"{time_match.group(1)}:{time_match.group(2)}:{time_match.group(3)},{time_match.group(4)}"
        end_str = f"{time_match.group(5)}:{time_match.group(6)}:{time_match.group(7)},{time_match.group(8)}"
    else:
        # Try MM:SS.ms format (Whisper format) - convert to HH:MM:SS,ms
        time_match = re.match(r'(\d{2}):(\d{2})\.(\d{3})\s+-->\s+(\d{2}):(\d{2})\.(\d{3})', timecode)
        if time_match:
            start_m, start_s, start_ms = int(time_match.group(1)), int(time_match.group(2)), int(time_match.group(3))
            end_m, end_s, end_ms = int(time_match.group(4)), int(time_match.group(5)), int(time_match.group(6))

            start_h = start_m // 60
            start_m = start_m % 60
            end_h = end_m // 60
            end_m = end_m % 60

            # Keep milliseconds as 3 digits for SRT format
            start_str = f"{start_h:02d}:{start_m:02d}:{start_s:02d},{start_ms:03d}"
            end_str = f"{end_h:02d}:{end_m:02d}:{end_s:02d},{end_ms:03d}"
        else:
            continue

    # Get text (join all remaining lines)
    text = ' '.join(lines[1:]).strip()

    # Remove styling tags
    text = re.sub(r'<[^>]+>', '', text)

    if text:
        subtitles.append({
            "counter": counter,
            "start": start_str,
            "end": end_str,
            "text": text
        })
        counter += 1

# Output SRT format
output = []
for sub in subtitles:
    output.append(str(sub["counter"]))
    output.append(f"{sub['start']} --> {sub['end']}")
    output.append(sub["text"])
    output.append("")

print('\n'.join(output))
EOF

# --- Run converter ---
python3 /tmp/vtt-to-srt.py "$VTT_FILE" > "$OUTPUT_JSON"

# --- Copy to clipboard if requested ---
if [ $COPY_TO_CLIPBOARD -eq 1 ] && command -v pbcopy &> /dev/null; then
    cat "$OUTPUT_JSON" | pbcopy
    echo -e "${GREEN}✓ JSON copied to clipboard!${NC}"
fi

# --- Cleanup ---
rm -f "$TEMP_AUDIO"* "$TEMP_VTT" "$VTT_FILE" /tmp/vtt-to-json.py

# --- Result ---
LINE_COUNT=$(jq 'length' "$OUTPUT_JSON" 2>/dev/null || grep -c '"start"' "$OUTPUT_JSON" 2>/dev/null || echo "?")
FILE_SIZE=$(du -h "$OUTPUT_JSON" | cut -f1)

echo ""
echo -e "${GREEN}Done!${NC}"
echo -e "  File: ${CYAN}${OUTPUT_JSON}${NC}"
echo -e "  Size: ${CYAN}${FILE_SIZE}${NC}"
echo -e "  Captions: ${CYAN}${LINE_COUNT}${NC}"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "  1. Open: ${CYAN}${OUTPUT_JSON}${NC}"
echo "  2. Copy all content (or use --copy flag)"
echo "  3. Paste in the 'captions' field in ACF video embed"
echo ""
