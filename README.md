# yuqing-entrust
����
1��cp .env.example
2���޸�.env CACHE_DRIVER=array
3��php artisan key:generate
4��php artisan migrate
5��php artisan db:seed
6���޸ķ����vim /etc/crontab
	���*  *    * * *   root    php /home/vagrant/code/yuqing-entrust/artisan schedule:run >> /dev/null 2>&1
   windowsϵͳ��Ҫ�����ĵ�
7���޸�php.ini  timezone=PRC


���޸ģ�
�����ݿⳤ�ı��ֶθ�Ϊtext