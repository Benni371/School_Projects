# Server Hardening Documentation

__Name__: Koy Bennion

## Fail2Ban Log

![Fail2Ban Log](sc/jaillog.png)

## Custom Jails

### `jail.local`

![relevant lines](sc/Jails.png)

### `filter.d/jail.conf`

![relevant lines](sc/dos-ban.png)

![relevant lines](sc/iphone-ban.png)

...

## `fail2ban-regex`
DDOS Regex
![output showing matches](sc/dos-regex.png)
Prevent Iphone Regex
![output showing matches](sc/iphone-regex.png)
DDOS Ban Log
![Custom Jail(s) ban activity](sc/dos-banlog.png)
Iphone Ban Log
![Custom Jail(s) ban activity](sc/iphone-banlog.png)
## Python script

![python script](sc/py.png)

The python script for both of the jails is similar in its function so thats why I only included one photo. The basics of the script is that it uses built in libraries to create a tls connection with googles smtp server. After that is established the script will need the source user credentials, destination user's email, and a message so that the connection can be established and the email can be sent.
