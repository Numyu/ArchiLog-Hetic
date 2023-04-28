#!/bin/bash

# Prompt for the new username
username=$1
password=$2
serveurName=$3


config=`sudo sed "s/placeholder/$serveurName/g" /etc/nginx/sites-available/template`
echo $config | sudo tee /etc/nginx/sites-available/$serveurName > /dev/null
sudo cp -r /etc/nginx/sites-available/$serveurName /etc/nginx/sites-enabled
echo "it's work"