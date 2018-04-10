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
8、用phantomjs去截取中文页面的网站可能会出现乱码的情况，也就是截图中中文的位置全是方框。
解决办法就是安装字体。
在centos中执行：yum install bitmap-fonts bitmap-fonts-cjk
在ubuntu中执行：sudo apt-get install xfonts-wqy


需修改：
将数据库长文本字段改为text