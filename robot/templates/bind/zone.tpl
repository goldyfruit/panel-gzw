$ORIGIN {{DOMAIN}}.
$TTL 86400
@       IN      SOA     {{NS1}}. {{CONTACT_DNS}}. (
;BEGIN SERIAL
                     {{SERIAL}}
;END SERIAL
                           3600
                            900
                        1209600
                          86400 )
 
				IN	NS	{{NS1}}.
				IN	NS	{{NS2}}.
 
				IN      MX	10	{{MX1}}.
				IN      MX	20	{{MX2}}.
 
{{DOMAIN}}.			IN	TXT	"v=spf1 ip4:{{IPNS1}} ip4:{{IPNS2}} a mx ptr mx:{{IPMX1}} mx:{{IPMX2}} ~all"
{{DOMAIN}}.			IN	HINFO	"Panel-GZW" "GoldZone Web"
 
{{DOMAIN}}.			IN	A	{{IPWEB}}
www				IN	CNAME	{{DOMAIN}}.
