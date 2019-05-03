#!/bin/bash
aviso=$1
chatid=$2
hora=$3
echo "#!/bin/bash" > tarea_alarma.sh
#cambiar rutas deseadas
echo "/usr/bin/php /var/dominios/misitio/public/bot_telegram/aviso_alarma.php $aviso.$chatid" >> tarea_alarma.sh
echo "#!/bin/bash" > at_script.sh
echo "/usr/bin/at -f /var/dominios/misitio/public/bot_telegram/tarea_alarma.sh $hora" >> at_script.sh
#para usar sudo: visudo -> www-data ALL=(ALL:ALL) NOPASSWD:ALL
sudo -u root sh at_script.sh