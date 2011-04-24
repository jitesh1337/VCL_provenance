#!/bin/sh

/bin/cp /etc/ssh/sshd_config ssh_config_1
/bin/cp /etc/ssh/sshd_config ssh_config_2
/bin/cp /etc/ssh/sshd_config ssh_config_3

/bin/sed -i 's/ListenAddress .*/ListenAddress 192.168.40.1/g' ssh_config_1
/bin/sed -i 's/AllowUsers .*/AllowUsers sskanitk/g' ssh_config_1

/bin/sed -i 's/ListenAddress .*/ListenAddress 192.168.5.1/g' ssh_config_2
/bin/sed -i 's/AllowUsers .*/AllowUsers sskanitk/g' ssh_config_2

/bin/sed -i 's/ListenAddress .*/ListenAddress 192.168.60.1/g' ssh_config_3
/bin/sed -i 's/AllowUsers .*/AllowUsers sskanitk/g' ssh_config_3

/usr/sbin/sshd -f ssh_config_1
/usr/sbin/sshd -f ssh_config_2
/usr/sbin/sshd -f ssh_config_3

#/usr/bin/yum install python -y
#/usr/bin/yum install MySQL-python -y

#/sbin/iptables -I RH-Firewall-1-INPUT -p tcp -m state --state NEW -m tcp --dport 5001 -j ACCEPT
#/sbin/iptables -I RH-Firewall-1-INPUT -p tcp -m state --state NEW -m tcp --dport 5000 -j ACCEPT
