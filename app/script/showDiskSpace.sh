#!/bin/bash

username="$1"
password="$2"
database="$3"

# Déclaration des chemin et nom de fichier de backup
backup_dir="/home/${username}/backup"
backup_path_site="/home/${username}/site"



# Sauvegarde du site
diskUsageSite=$(sudo du -sh $backup_path_site | awk '{print $1}')


# Sauvegarde de la base de données
queryDb="SELECT sum(data_length + index_length) / (1024 * 1024) AS Size FROM information_schema.tables WHERE table_schema = '${database}';"
sizeDb=$(mysql -u ${username} -p${password} -e "${queryDb}" -sN ${database})


echo "<br> <br>"
echo "Taille espace disque utilisé =  ${diskUsageSite}."
echo "<br> <br>"
echo "La taille de la base de données ${database} est de ${sizeDb} Mo."
echo "<br> <br>"

