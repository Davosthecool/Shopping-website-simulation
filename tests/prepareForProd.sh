git reset --hard
git pull
cd  ..
sudo chmod 777 -R Flow/
cd Flow/
./test/init.sh
php composer.phar dump-env prod
php composer.phar dump-autoload -o --no-dev
echo "[OK] Ready for prod"