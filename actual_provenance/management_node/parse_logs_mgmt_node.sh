#!/bin/bash

SSH_LOG="/var/log/secure"
SYSLOG="/var/log/messages"
LOG_COUNT_FILE="log_counts"
HTTPD_LOG="/var/log/httpd/error_log"
HTTPD_SSL_LOG="/var/log/httpd/ssl_error_log"
HTTPD_VCL_LOG="/var/log/httpd/vclssl-error_log"
VCLD_LOG="/var/log/vcld.log"

if [ ! -f "$LOG_COUNT_FILE" ]; then
        echo SSHD_CNT=`cat $SSH_LOG | wc -l` > $LOG_COUNT_FILE
        echo SYSLOG_CNT=`cat $SYSLOG | wc -l` >> $LOG_COUNT_FILE
        echo HTTPD_CNT=`cat $HTTPD_LOG | wc -l` >> $LOG_COUNT_FILE
        echo HTTPD_SSL_CNT=`cat $HTTPD_SSL_LOG | wc -l` >> $LOG_COUNT_FILE
        echo HTTPD_VCL_CNT=`cat $HTTPD_VCL_LOG | wc -l` >> $LOG_COUNT_FILE
        echo VCLD_CNT=`cat $VCLD_LOG | wc -l` >> $LOG_COUNT_FILE
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

function parse_httpd_log()
{
	line="$1"
	echo $line | grep "\[error\]" | awk '{print "3#" $2,$3,$4,$8,$9,$10,$11,$12,$13}' | sed 's/\]//g'
}

function parse_vcld_log()
{
	line="$1"
	echo $line | grep "No such virtual machine" | grep "vmware.pm" | sed 's/|/ /g' | awk '{print "3#" $1,$2,$10,$11,$12,$13,$17}'
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

echo DAEMON_NAME=HTTPD
HTTPD_CNT_CUR=`cat $HTTPD_LOG | wc -l`
DIFF=$((HTTPD_CNT_CUR-HTTPD_CNT))
tail -n $DIFF $HTTPD_LOG |
(
	while read line; do
		parse_httpd_log "$line";
	done
)
echo HTTPD_CNT=$HTTPD_CNT_CUR >> $LOG_COUNT_FILE

HTTPD_SSL_CNT_CUR=`cat $HTTPD_SSL_LOG | wc -l`
DIFF=$((HTTPD_SSL_CNT_CUR-HTTPD_SSL_CNT))
tail -n $DIFF $HTTPD_SSL_LOG |
(
	while read line; do
		parse_httpd_log "$line";
	done
)
echo HTTPD_SSL_CNT=$HTTPD_SSL_CNT_CUR >> $LOG_COUNT_FILE

HTTPD_VCL_CNT_CUR=`cat $HTTPD_VCL_LOG | wc -l`
DIFF=$((HTTPD_VCL_CNT_CUR-HTTPD_VCL_CNT))
tail -n $DIFF $HTTPD_VCL_LOG |
(
	while read line; do
		parse_httpd_log "$line";
	done
)
echo HTTPD_VCL_CNT=$HTTPD_VCL_CNT_CUR >> $LOG_COUNT_FILE
echo DAEMON_END


echo DAEMON_NAME=VCLD
VCLD_CNT_CUR=`cat $VCLD_LOG | wc -l`
DIFF=$((VCLD_CNT_CUR-VCLD_CNT))
tail -n $DIFF $VCLD_LOG |
(
	while read line; do
		parse_vcld_log "$line";
	done
)
echo VCLD_CNT=$VCLD_CNT_CUR >> $LOG_COUNT_FILE
echo DAEMON_END

