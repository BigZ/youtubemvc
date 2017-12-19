#!/bin/sh

rm -f test.png && php video.php > test.png
ffmpeg -loop 1 -i test.png -i 2.wav -c:a aac -ab 112k -c:v libx264 -shortest -strict -2 out.mp4

