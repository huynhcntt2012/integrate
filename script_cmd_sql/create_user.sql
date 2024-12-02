userid = 1001
dial = 'SIP/1001'
devicetype = 'fixed'
name = 'John Doe'
INSERT INTO devices (id, tech, dial, devicetype, user, description) 
VALUES ('1001', 'pjsip', 'SIP/1001', 'fixed', '1001', 'John Doe');

userid = 1001

INSERT INTO users (extension, password, name, voicemail, mohclass) 
VALUES ('1001', 'mypassword', 'John Doe', 'novm', 'default');



table userman_users
table cxpanel_users

asterisk -rx "module show like sip"

sip 


delete FROM `devices`;
delete FROM `sip`;
delete FROM `userman_users`;
delete FROM `users`;

sudo fwconsole ma delete firewall sysadmin
cat /etc/freepbx.conf

$amp_conf['AMPDBUSER'] = 'freepbxuser';
$amp_conf['AMPDBPASS'] = 'cb9fce788ee8e8405f942fb6d8fd6c49';
$amp_conf['AMPDBHOST'] = 'localhost';
$amp_conf['AMPDBNAME'] = 'asterisk';
$amp_conf['AMPDBENGINE'] = 'mysql';
$amp_conf['datasource'] = ''; //for sqlite3

require_once('/var/www/html/admin/bootstrap.php');


yum install prosody
systemctl start prosody
systemctl enable prosody

nano /etc/prosody/prosody.cfg.lua


VirtualHost "pbx.yourdomain.com"
    enabled = true
prosodyctl adduser youruser@pbx.yourdomain.com
systemctl restart prosody
