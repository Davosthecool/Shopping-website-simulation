git reset --hard
git pull
./init.sh
php composer.phar dump-env prod
php composer.phar dump-autoload -o --no-dev
echo "[OK] Ready for prod"