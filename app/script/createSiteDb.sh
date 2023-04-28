#!/bin/bash

username="$1"
password="$2"
dns="$3"

sudo mysql -u "$username" -p"$password" -e "CREATE DATABASE IF NOT EXISTS $dns";

