#!/bin/bash
#
# Script para testar aplicacao web
# usando o Apache Bench para analisar as respostas
#
#
servidor="192.168.1.252"
path="/RestAPI/RestDBClient.php"

#max="1 10 20 30 40 50 60 70 80 90 100 110 120 130 140 150"
max="1 10 20 30 40 50 60 70 80 90 100 110 120 130 140 150 160 170 180 190 200 210 220 230 240 250"
for i in $max
do
	/usr/bin/ab -l -r -n $i -c $i -k http://$servidor$path
	#echo "$i - http://$servidor$path"
done
