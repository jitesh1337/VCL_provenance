#!/bin/sh

MY_PUBLIC_ADDR=`/sbin/ifconfig eth1 | grep "inet addr" | awk '{print $2}' | cut -d ':' -f 2`

MY_TUNNEL_ADDR1=192.168.40.1
MY_TUNNEL_ADDR2=192.168.5.1
MY_TUNNEL_ADDR3=192.168.60.1

MN1_PUBLIC_ADDR=0
MN2_PUBLIC_ADDR=0
MN2_PUBLIC_ADDR=0

MN1_TUNNEL_ADDR=192.168.40.2
MN2_TUNNEL_ADDR=192.168.5.2
MN3_TUNNEL_ADDR=192.168.60.2

TAB_MN_INFO_FILE="/tmp/tab_mn_info"

. /etc/mn_info
MN1_PUBLIC_ADDR=$MN1
MN2_PUBLIC_ADDR=$MN2
MN3_PUBLIC_ADDR=$MN3

echo $MN1_PUBLIC_ADDR $MN2_PUBLIC_ADDR $MN3_PUBLIC_ADDR
echo $MY_PUBLIC_ADDR

# Create the first Tunnel Interface at PI.
/sbin/modprobe tun
/sbin/modprobe ip_gre
/sbin/ip tunnel add gre1 mode gre remote $MN1_PUBLIC_ADDR local $MY_PUBLIC_ADDR
/sbin/ip addr add $MY_TUNNEL_ADDR1 dev gre1 peer $MN1_TUNNEL_ADDR
/sbin/ip link set gre1 up

# echo "Creating tunnel interface at MN1"
# Create the Tunnel Interface at MN1.
echo "/sbin/modprobe tun" > mn1
echo "/sbin/modprobe ip_gre" >> mn1
echo "/sbin/ip tunnel add gre1 mode gre remote $MY_PUBLIC_ADDR local $MN1_PUBLIC_ADDR" >> mn1
echo "/sbin/ip addr add $MN1_TUNNEL_ADDR dev gre1 peer $MY_TUNNEL_ADDR1" >> mn1
echo "/sbin/ip link set gre1 up" >> mn1

echo "1#$MN1_PUBLIC_ADDR#gre1#$MY_TUNNEL_ADDR1#$MN1_TUNNEL_ADDR" >  $TAB_MN_INFO_FILE

# Create the second Tunnel Interface at PI.
/sbin/modprobe tun
/sbin/modprobe ip_gre
/sbin/ip tunnel add gre2 mode gre remote $MN2_PUBLIC_ADDR local $MY_PUBLIC_ADDR
/sbin/ip addr add $MY_TUNNEL_ADDR2 dev gre2 peer $MN2_TUNNEL_ADDR
/sbin/ip link set gre2 up

# echo "Creating tunnel interface at MN2"
# Create the Tunnel Interface at MN2.
echo "/sbin/modprobe tun" > mn2
echo "/sbin/modprobe ip_gre" >> mn2
echo "/sbin/ip tunnel add gre1 mode gre remote $MY_PUBLIC_ADDR local $MN2_PUBLIC_ADDR" >> mn2
echo "/sbin/ip addr add $MN2_TUNNEL_ADDR dev gre1 peer $MY_TUNNEL_ADDR2" >> mn2
echo "/sbin/ip link set gre1 up" >> mn2

echo "2#$MN2_PUBLIC_ADDR#gre2#$MY_TUNNEL_ADDR2#$MN2_TUNNEL_ADDR" >>  $TAB_MN_INFO_FILE

# Create the third Tunnel Interface at PI.
/sbin/modprobe tun
/sbin/modprobe ip_gre
/sbin/ip tunnel add gre3 mode gre remote $MN3_PUBLIC_ADDR local $MY_PUBLIC_ADDR
/sbin/ip addr add $MY_TUNNEL_ADDR3 dev gre3 peer $MN3_TUNNEL_ADDR
/sbin/ip link set gre3 up

# echo "Creating tunnel interface at MN3"
# Create the Tunnel Interface at MN3.
echo "/sbin/modprobe tun" > mn3
echo "/sbin/modprobe ip_gre" >> mn3
echo "/sbin/ip tunnel add gre1 mode gre remote $MY_PUBLIC_ADDR local $MN3_PUBLIC_ADDR" >> mn3
echo "/sbin/ip addr add $MN3_TUNNEL_ADDR dev gre1 peer $MY_TUNNEL_ADDR3" >> mn3 
echo "/sbin/ip link set gre1 up" >> mn3

echo "3#$MN3_PUBLIC_ADDR#gre3#$MY_TUNNEL_ADDR3#$MN3_TUNNEL_ADDR" >>  $TAB_MN_INFO_FILE

chmod +x mn1
chmod +x mn2
chmod +x mn3

# dyn_server will be listening on 5000 port
/sbin/iptables -I RH-Firewall-1-INPUT -p tcp -m state --state NEW -m tcp --dport 5000 -j ACCEPT
# static_server will be listening on 5001 port
/sbin/iptables -I RH-Firewall-1-INPUT -p tcp -m state --state NEW -m tcp --dport 5001 -j ACCEPT
