#BEGIN {{DOMAIN}}
<VirtualHost *:80>

        ServerAdmin {{EMAIL}}

        ServerName {{DOMAIN}}
        ServerAlias {{ALIAS}}

        DocumentRoot {{PATH}}{{UID}}/websites/{{DOMAIN}}

        SuexecUserGroup {{UID}} {{GID}}

        <IfModule mod_fcgid.c>
                ScriptAlias /suexec/ /srv/data/php5-fcgi/

                AddHandler php-fastcgi .php .php3 .php4
                AddType application/x-httpd-php .php .phphtml
		AddType application/x-httpd-php-source .phps
                DirectoryIndex index.html index.php index.htm
                Action php-fastcgi /suexec/{{UID}}/php-fcgi.sh

                <Directory {{PATH}}{{UID}}/websites/{{DOMAIN}}>
                        Options +ExecCGI -MultiViews +SymLinksIfOwnerMatch
                        AllowOverride All
                        Order allow,deny
                        Allow from all
                </Directory>
        </IfModule>

        ErrorLog {{LOG}}{{UID}}/log/{{DOMAIN}}-error.log
        CustomLog {{LOG}}{{UID}}/log/{{DOMAIN}}-access.log combined
	CustomLog {{LOG}}{{UID}}/log/{{DOMAIN}}-traffic.log traffic
	LogSQLScoreDomain {{DOMAIN}}

</VirtualHost>
#END {{DOMAIN}}

