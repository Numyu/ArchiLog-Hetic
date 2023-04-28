sudo mysql -e "CREATE DATABASE $3;"
sudo mysql -e "CREATE USER '$1'@'localhost' IDENTIFIED BY '$2';"
sudo mysql -e "GRANT ALL PRIVILEGES ON $3.* TO '$1'@'localhost';"

echo "BDD CREATED"
