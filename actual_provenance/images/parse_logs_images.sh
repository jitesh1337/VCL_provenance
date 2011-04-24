#!/bin/bash

SSH_LOG="/var/log/secure"
SYSLOG="/var/log/messages"
LOG_COUNT_FILE="log_counts"

if [ ! -f "$LOG_COUNT_FILE" ]; then
        echo SSHD_CNT=`cat $SSH_LOG | wc -l` > $LOG_COUNT_FILE
        echo SYSLOG_CNT=`cat $SYSLOG | wc -l` >> $LOG_COUNT_FILE
fi

. $LOG_COUNT_FILE

function parse_secure_log()
{
        line="$1"
        echo $line | grep Accepted | awk '{print "3#" $1, $2, $3, "Accepted: " $9, $11}'
	echo $line | grep "session opened for" | grep -v "gdm-password" | awk '{print "3#" $1,$2,$3, "Session_Opened: " $5,$13}' | sed 's/\[.*\]//g' | sed 's/\([A-Za-z][a-z]*\):/\1/'
	echo $line | grep "Failed password for" | grep -v "invalid user" | awk '{print "1#" $1, $2, $3, "Failed_password: ", $5, $9, $11, $13}' | sed 's/\[.*\]://g'
	echo $line | grep "Failed password for invalid user"  | awk '{print "1#" $1, $2, $3, "Failed_password: ", $5, $11, $13, $15}' | sed 's/\[.*\]://g'
	echo $line | grep "refused"  | awk '{print "1#" $1, $2, $3, "Refused: ", $5, $9}' | sed 's/\[.*\]://g'
}

function parse_firewall()
{
	nmap -sS -p 1-65535 localhost |
	(
		while read line; do
			if [ ! -z "`echo $line | grep ^PORT`" ]; then
				break;
			fi
		done

		while read line; do
			if [ -z "$line" ]; then break; fi;
			OPEN_PORTS=$OPEN_PORTS"`echo $line | cut -d'/' -f1`,"
		done

		echo LIST_OF_OPEN_PORTS $OPEN_PORTS
	)
}

function parse_syslog()
{
	line="$1"
	echo $line | grep "yum" | grep yum | awk '{print "3#" $1,$2,$3,$6,$7}'
	echo $line | grep "log daemon terminating" | awk '{print "1#" $1,$2,$3,$5,$6,$7,$8,$9}'
	echo $line | grep "updated /etc/resolv.conf" | awk '{print "1#" $1,$2,$3,$5,$6,$8,$9}'
}

SSHD_CNT_CUR=`cat $SSH_LOG | wc -l`
DIFF=$((SSHD_CNT_CUR-SSHD_CNT))
echo DAEMON_NAME=SSHD
tail -n $DIFF $SSH_LOG |
(
        while read line; do
                parse_secure_log "$line";
        done
)
echo SSHD_CNT=$SSHD_CNT_CUR > $LOG_COUNT_FILE
echo DAEMON_END

echo DAEMON_NAME=FIREWALL
echo -n "1#`date | awk '{print $2,$3,$4}'` "
parse_firewall;
echo DAEMON_END

SYSLOG_CNT_CUR=`cat $SYSLOG | wc -l`
DIFF=$((SYSLOG_CNT_CUR-SYSLOG_CNT))
echo DAEMON_NAME=SYSLOG
tail -n $DIFF $SYSLOG |
(
	while read line; do
		parse_syslog "$line";
	done
)
echo SYSLOG_CNT=$SYSLOG_CNT_CUR >> $LOG_COUNT_FILE
echo DAEMON_END

