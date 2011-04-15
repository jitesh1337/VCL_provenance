#!/bin/bash

function usage()
{
	echo "parse_sar.sh <logfile>"
}

function analyze_cpu_usage()
{
	LINE=`sar -f $LOGFILE -u | grep "^Average"`;
	CPU_USER=`echo $LINE | awk '{print $3}'`;
	CPU_SYSTEM=`echo $LINE | awk '{print $5}'`;
	CPU_IOWAIT=`echo $LINE | awk '{print $6}'`;
	CPU_IDLE=`echo $LINE | awk '{print $8}'`;
	echo CPU_USER=$CPU_USER
	echo CPU_SYSTEM=$CPU_SYSTEM 
	echo CPU_IOWAIT=$CPU_IOWAIT
	echo CPU_IDLE=$CPU_IDLE
}

LOGFILE=$1
if [ -z "$LOGFILE" ]; then
	usage;
	exit;
fi

analyze_cpu_usage;
