git reset --hard
git pull
cd  ..
sudo chmod 777 -R Flow/
cd Flow/
echo 'yes' | php composer.phar dump-env dev
echo 'yes' | php composer.phar dump-autoload
./tests/init.sh
echo 'yes' | php composer.phar dump-env prod
echo 'yes' | php composer.phar dump-autoload -o --no-dev
echo "[OK] Ready for prod"
