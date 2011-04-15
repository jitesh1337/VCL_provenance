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

function analyze_io_usage()
{
	sar -f $LOGFILE -b |  
	(read; read; read; #Skip first 3 lines. Header.
	IO_PEAK=0;
	while read LINE; do
		if [ ! -z "`echo $LINE | grep \"^Average\"`" ]; then
			#Average line
			IO_BREAD=`echo $LINE | awk '{print $5}'`;
			IO_BWRITE=`echo $LINE | awk '{print $6}'`;
			echo IO_BLOCK_READS=$IO_BREAD
			echo IO_BLOCK_WRITES=$IO_BWRITE
		else
			#Extract information from intermediate readings.
			IO_SUM=0;
			IO_BREAD=`echo $LINE | awk '{print $6}'`;
			IO_BWRITE=`echo $LINE | awk '{print $7}'`;
			IO_SUM=`echo $IO_BREAD + $IO_BWRITE | bc`
			COMPARISON=`echo $IO_SUM \> $IO_PEAK | bc`
			if [ "1" == "$COMPARISON" ]; then
				IO_PEAK=$IO_SUM;
			fi
		fi
	done;
	echo IO_PEAK=$IO_PEAK; )
}

function analyze_paging_usage()
{
	sar -f $LOGFILE -B |  
	(read; read; read; #Skip first 3 lines. Header.
	PG_FAULTS_PEAK=0;
	PG_MAJOR_FAULTS_PEAK=0;
	while read LINE; do
		if [ ! -z "`echo $LINE | grep \"^Average\"`" ]; then
			#Average line
			PG_PGIN=`echo $LINE | awk '{print $2}'`;
			PG_PGOUT=`echo $LINE | awk '{print $3}'`;
			PG_FAULT=`echo $LINE | awk '{print $4}'`;
			PG_MAJFAULT=`echo $LINE | awk '{print $5}'`;
			echo PAGING_PAGE_INS=$PG_PGIN
			echo PAGING_PAGE_OUTS=$PG_PGOUT
			echo PAGING_FAULTS=$PG_FAULT
			echo PAGING_MAJOR_=$PG_MAJFAULT
		else
			#Extract information from intermediate readings.
			PG_PGIN=`echo $LINE | awk '{print $3}'`;
			PG_PGOUT=`echo $LINE | awk '{print $4}'`;
			PG_FAULT=`echo $LINE | awk '{print $5}'`;
			PG_MAJFAULT=`echo $LINE | awk '{print $6}'`;

			COMPARISON=`echo $PG_FAULT \> $PG_FAULTS_PEAK | bc`
			if [ "1" == "$COMPARISON" ]; then
				PG_FAULTS_PEAK=$PG_FAULT;
			fi

			COMPARISON=`echo $PG_MAJFAULT \> $PG_MAJOR_FAULTS_PEAK | bc`
			if [ "1" == "$COMPARISON" ]; then
				PG_MAJOR_FAULTS_PEAK=$PG_MAJFAULT;
			fi
		fi
	done;
	echo PAGING_PEAK_FAULTS=$PG_FAULTS_PEAK;
	echo PAGING_PEAK_MAJOR_FAULTS=$PG_MAJOR_FAULTS_PEAK;
	 )
}

LOGFILE=$1
if [ -z "$LOGFILE" ]; then
	usage;
	exit;
fi

analyze_cpu_usage;
analyze_io_usage;
analyze_paging_usage;
