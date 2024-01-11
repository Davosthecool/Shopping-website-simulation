#installation initiale nécessaire
composer install;

#suppression de potentielles versions anciennes
symfony console doctrine:database:drop --force;
rm migrations/*;

#creation de la base de données
symfony console doctrine:database:create;
symfony console make:migration;
echo yes | symfony console doctrine:migrations:migrate;

#alimentation de celle-ci avec des données
echo "insert into article values(1,'Pull en polystyrène',64.99,'S,M,L','R,G,B','hiver,pull','Abibas',10,'image 5.png')" | mariadb -u admin -ppassword app ;
echo "insert into article values(2,'Sweat confortable',38.99,'XS,S,M,L,XL','Bleu clair, Vert clair','automne,sweat','Pouma',5,'image 5.png')" | mariadb -u admin -ppassword app ;
