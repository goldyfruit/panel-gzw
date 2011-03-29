#BEGIN {{DOMAIN}}
<VirtualHost *:80>

	ServerAdmin {{EMAIL}}

	ServerName {{DOMAIN}}
	ServerAlias {{ALIAS}}

	SuexecUserGroup {{UID}} {{GID}}

	DocumentRoot "{{PATH}}{{UID}}/websites/{{DOMAIN}}"

	<Directory "{{PATH}}{{UID}}/websites/{{DOMAIN}}">

		DirectoryIndex index.php index.html index.htm
		AllowOverride All
		Options -Indexes Includes FollowSymLinks MultiViews
		Order allow,deny
		Allow from all
		Action php-script /php-exec/php-fcgi
		Addhandler php-script .php .php3 .php4

#        	php_admin_value open_basedir ".:{{PATH}}{{UID}}/websites/{{DOMAIN}}:{{TMP}}:/usr/share/php"
#	        php_admin_value include_path ".:{{PATH}}{{UID}}/websites/{{DOMAIN}}:{{TMP}}:/usr/share/php"
#	        php_admin_value session.save_path "{{PATH}}:{{TMP}}:/usr/share/php"
#	        php_admin_value upload_tmp_dir "{{PATH}}:{{TMP}}:/usr/share/php"
#	        php_admin_value sendmail_path "/usr/sbin/sendmail -t -i -f {{EMAIL}}"

	</Directory>

	AddType application/x-httpd-php .php .phtml
	AddType application/x-httpd-php-source .phps

	ScriptAlias /php-exec/ "{{PHPDIR}}{{UID}}/"
	<Directory "{{PHPDIR}}{{UID}}">
		Options -Indexes +ExecCGI +FollowSymLinks -MultiViews +SymLinksIfOwnerMatch
		SetHandler cgi-script
		AllowOverride None
		Order allow,deny
		Allow from all
	</Directory>

	ErrorLog {{LOG}}{{UID}}/log/{{DOMAIN}}-error.log
	CustomLog {{LOG}}{{UID}}/log/{{DOMAIN}}-access.log combined
	CustomLog {{LOG}}{{UID}}/log/{{DOMAIN}}-traffic.log traffic

</VirtualHost>
#END {{DOMAIN}}

