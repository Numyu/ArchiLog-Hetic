
#!/bin/bash

username="$1"
oldpassword="$2"
newpassword="$3"

echo "$username:$newpassword" | sudo chpasswd 

sudo mysql -u root -p -e "UPDATE mysql.user SET password=PASSWORD('$newpassword') where User='$username'; FLUSH PRIVILEGES;"

# # repertoire des users
# userpath="/home/$username"

# # cherche dans le repertoire /home si l'utilisateur existe
# if find $userpath
# then 
# # si oui, change le mdp 
# echo "$username:$password" | sudo chpasswd 

# sudo mysql -u $username -e "SET PASSWORD FOR "$username"@'localhost' = PASSWORD('$newpassword');"
# sudo mysql -u $username -e "FLUSH PRIVILEGES;"



# echo "mot de passe changé pour l'utilisateur $username"
# else
# # sinon, il se passe rien
# echo "le nom d'utilisateur : $username n'existe pas"
# fi
