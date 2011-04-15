#!/bin/bash

function usage()
{
	echo "parse_sar.sh <logfile>"
}

function analyze_cpu_usage()
{
	sar -f $LOGFILE -u |  
	(read; read; read; #Skip first 3 lines. Header.
	CPU_PEAK=0;
	while read LINE; do
		if [ ! -z "`echo $LINE | grep \"^Average\"`" ]; then
			#Average line
			CPU_USER=`echo $LINE | awk '{print $3}'`;
			CPU_SYSTEM=`echo $LINE | awk '{print $5}'`;
			CPU_IOWAIT=`echo $LINE | awk '{print $6}'`;
			CPU_IDLE=`echo $LINE | awk '{print $8}'`;
			echo CPU_USER=$CPU_USER
			echo CPU_SYSTEM=$CPU_SYSTEM 
			echo CPU_IOWAIT=$CPU_IOWAIT
			echo CPU_IDLE=$CPU_IDLE
		else
			#Extract information from intermediate readings.
			CPU_SUM=0;
			CPU_USER=`echo $LINE | awk '{print $4}'`;
			CPU_SYSTEM=`echo $LINE | awk '{print $6}'`;
			CPU_IOWAIT=`echo $LINE | awk '{print $7}'`;
			CPU_IDLE=`echo $LINE | awk '{print $9}'`;
			CPU_SUM=`echo $CPU_USER + $CPU_SYSTEM | bc`
			COMPARISON=`echo $CPU_SUM \> $CPU_PEAK | bc`
			if [ "1" == "$COMPARISON" ]; then
				CPU_PEAK=$CPU_SUM;
			fi
		fi
	done;
	echo CPU_PEAK=$CPU_PEAK; )
}

LOGFILE=$1
if [ -z "$LOGFILE" ]; then
	usage;
	exit;
fi

analyze_cpu_usage;
