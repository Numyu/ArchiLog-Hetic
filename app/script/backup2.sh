#!/bin/bash

username="$1"
password="$2"
db_name="$3"
echo $db_name

echo sudo "mysqldump -u $username -p $password $db_name > backup_$db_name.sql"

echo sudo "tar -cvzf mon_backup.tar.gz backup_$db_name.sql"
