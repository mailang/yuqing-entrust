# yuqing-entrust
部署
1、cp .env.example
2、修改.env CACHE_DRIVER=array
3、php artisan key:generate
4、php artisan migrate
5、php artisan db:seed
6、修改服务端vim /etc/crontab
	添加*  *    * * *   root    php /home/vagrant/code/yuqing-entrust/artisan schedule:run >> /dev/null 2>&1
   windows系统需要找下文档
7、修改php.ini  timezone=PRC


需修改：
将数据库长文本字段改为text