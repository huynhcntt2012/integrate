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


fwconsole userman --create-token --user=admin --password=fwa@865221
 The "--create-token" option does not exist.
