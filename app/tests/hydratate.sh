#alimentation  de user avec des données
echo "
insert into user values(1, 'dada@gmail.com', '["user"]', '$2y$13$6X.eFQ4MvgGhkp77z0DaOeJZp/KkrBxdI.O/mAF1v0V4fwnm/hD8a', 'H', 'ddd', 'ddd');
" | mariadb -u admin -ppassword app ;


#alimentation de article avec des données
echo "
insert into article values(1,'Pull en polystyrène',64.99,'S,M,L','R,G,B','hiver,pull','Abibas',10,'image 5.png');
insert into article values(2,'Sweat confortable',38.99,'XS,S,M,L,XL','Bleu clair, Vert clair','automne,sweat','Pouma',5,'image 5.png');
" | mariadb -u admin -ppassword app ;

#alimentation de exemplaire avec des données
echo "
insert into exemplaire values(19,1,NULL,3,'vert');
insert into exemplaire values(20,1,NULL,2,'vert');
insert into exemplaire values(21,1,NULL,5,'vert');
insert into exemplaire values(22,1,NULL,5,'bleu');
" | mariadb -u admin -ppassword app ;