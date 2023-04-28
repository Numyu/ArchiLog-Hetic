#!/bin/bash

username="$1"
password="$2"
database="$3"

# Déclaration des chemin et nom de fichier de backup
backup_dir="/home/${username}/backup"
backup_path_site="/home/${username}/site"
backup_file_site="backup_$(date +"%Y%m%d_%H%M%S").tgz"
backup_file_db="backup_$(date +"%Y%m%d_%H%M%S")_dump.sql"


# Création du dossier de sauvegarde s'il n'existe pas encore
mkdir -p $backup_dir

# Sauvegarde du site
sudo tar -cvzf "$backup_dir/$backup_file_site" $backup_path_site

filenameDump="$backup_dir/$backup_file_db"
sudo mysqldump -u $username -p$password $database > $filenameDump
