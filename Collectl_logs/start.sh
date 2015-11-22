#!/bin/bash
#
# Script para iniciar o Collectl 
# Captura os valores referentes a:
# CPU, Memoria, Disco e Rede
#

data=$(date +%Y_%m_%d-%H:%M)
fileName="Collectl_log_$data.txt"

/usr/bin/collectl -scmdn -oT | tee $fileName
#echo $fileName
