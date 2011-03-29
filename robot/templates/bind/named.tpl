
//BEGIN {{DOMAIN}}
zone "{{DOMAIN}}" {
type master;
file "{{PATH_ZONE}}{{DOMAIN}}.conf";
notify yes;
allow-transfer { {{IPNS2}}; };
};
//END {{DOMAIN}}
