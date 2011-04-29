#!/bin/sh

/usr/bin/yum install python -y
/usr/bin/yum install MySQL-python -y

/sbin/iptables -I RH-Firewall-1-INPUT -p tcp -m state --state NEW -m tcp --dport 5001 -j ACCEPT
/sbin/iptables -I RH-Firewall-1-INPUT -p tcp -m state --state NEW -m tcp --dport 5000 -j ACCEPT

