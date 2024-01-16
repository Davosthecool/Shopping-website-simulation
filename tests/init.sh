#installation initiale nécessaire
php composer.phar update;
sudo service mariadb start;

#suppression de potentielles versions anciennes
#symfony console doctrine:database:drop --force;
#rm -r migrations
#mkdir migrations
#creation de la base de données
#symfony console doctrine:database:create;
#symfony console make:migration;
#echo yes | symfony console doctrine:migrations:migrate;

#echo yes | symfony console doctrine:fixture:load;
