#!/bin/bash
# Borramos el fichero de comandos
rm comandos_$2.txt
/usr/bin/youtube-dl --extract-audio --audio-format mp3 $1 -o $2.mp3
/usr/bin/php enviarAudio.php $2.mp3
# Borramos fichero mp3 una vez enviado.
rm $2.mp3
