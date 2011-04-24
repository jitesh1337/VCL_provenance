#!/bin/bash

function usage()
{
	echo "parse_sar.sh <logfile>"
}

function analyze_cpu_usage()
{
	CPU_NUM_CORES=`cat /proc/cpuinfo  | grep ^processor | wc -l`;
	echo CPU_NUM_CORES=$CPU_NUM_CORES;
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


	sar -f $LOGFILE -q |  
	(read; read; read; #Skip first 3 lines. Header.
	CPU_PEAK=0;
	while read LINE; do
		if [ ! -z "`echo $LINE | grep \"^Average\"`" ]; then
			#Average line
			CPU_RUNQ=`echo $LINE | awk '{print $2}'`;
			CPU_LOADAVG_1=`echo $LINE | awk '{print $4}'`;
			CPU_LOADAVG_5=`echo $LINE | awk '{print $5}'`;
			CPU_LOADAVG_15=`echo $LINE | awk '{print $6}'`;
			echo CPU_RUNQ_LEN=$CPU_RUNQ
			echo CPU_LOADAVG_1=$CPU_LOADAVG_1
			echo CPU_LOADAVG_5=$CPU_LOADAVG_5
			echo CPU_LOADAVG_15=$CPU_LOADAVG_15
		fi
	done;
	)
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

function analyze_mem_usage()
{
	sar -f $LOGFILE -r |  
	(read; read; read; #Skip first 3 lines. Header.
	MEM_SIZE=`cat /proc/meminfo | grep "MemTotal" | awk '{print $2}'`
	echo MEM_SIZE=$MEM_SIZE;
	MEM_PEAK_USED=0;
	while read LINE; do
		if [ ! -z "`echo $LINE | grep \"^Average\"`" ]; then
			#Average line
			MEM_FREE=`echo $LINE | awk '{print $2}'`;
			MEM_USED=`echo $LINE | awk '{print $3}'`;
			echo MEM_FREE=$MEM_FREE
			echo MEM_USED=$MEM_USED
		else
			#Extract information from intermediate readings.
			MEM_USED=`echo $LINE | awk '{print $4}'`;

			COMPARISON=`echo $MEM_USED \> $MEM_PEAK_USED | bc`
			if [ "1" == "$COMPARISON" ]; then
				MEM_PEAK_USED=$MEM_USED
			fi
		fi
	done;
	echo MEM_PEAK_USED=$MEM_PEAK_USED;
	 )

	sar -f $LOGFILE -r |  
	(read; read; read; #Skip first 3 lines. Header.
	SWAP_SIZE=`cat /proc/meminfo  | grep SwapTotal | awk '{print $2}'`
	echo SWAP_SIZE=$SWAP_SIZE;
	SWAP_PEAK_USED=0;
	while read LINE; do
		if [ ! -z "`echo $LINE | grep \"^Average\"`" ]; then
			#Average line
			SWAP_FREE=`echo $LINE | awk '{print $7}'`;
			SWAP_USED=`echo $LINE | awk '{print $8}'`;
			echo SWAP_FREE=$SWAP_FREE
			echo SWAP_USED=$SWAP_USED
		else
			#Extract information from intermediate readings.
			SWAP_USED=`echo $LINE | awk '{print $9}'`;

			COMPARISON=`echo $SWAP_USED \> $SWAP_PEAK_USED | bc`
			if [ "1" == "$COMPARISON" ]; then
				SWAP_PEAK_USED=$SWAP_USED
			fi
		fi
	done;
	echo SWAP_PEAK_USED=$SWAP_PEAK_USED;
	 )
}

function analyze_task_stats()
{
	sar -f $LOGFILE -w |  
	(read; read; read; #Skip first 3 lines. Header.
	while read LINE; do
		if [ ! -z "`echo $LINE | grep \"^Average\"`" ]; then
			#Average line
			TASK_CREATED_PER_S=`echo $LINE | awk '{print $2}'`;
			TASK_CTX_SWTICH_PER_S=`echo $LINE | awk '{print $3}'`;
			echo TASK_CREATED_PER_SEC=$TASK_CREATED_PER_S
			echo TASK_CONTEX_SWTICH_PER_SEC=$TASK_CTX_SWTICH_PER_S
		fi
	done;
	echo TASK_NUM_TASKS=`ps aux --no-headers | wc -l`;
	 )
}

function analyze_file_usage()
{
	sar -f $LOGFILE -v |  
	(read; read; read; #Skip first 3 lines. Header.
	FILE_HANDLES_PEAK=0
	FILE_INODES_PEAK=0;
	FILE_PSEUDO_TERMS_PEAK=0
	while read LINE; do
		if [ ! -z "`echo $LINE | grep \"^Average\"`" ]; then
			#Average line
			FILE_HANDLES=`echo $LINE | awk '{print $3}'`;
			FILE_INODES=`echo $LINE | awk '{print $4}'`;
			FILE_PSEUDO_TERMS=`echo $LINE | awk '{print $5}'`;
			echo FILE_HANDLES=$FILE_HANDLES
			echo FILE_INODES=$FILE_INODES
			echo FILE_PSEUDO_TERMS=$FILE_PSEUDO_TERMS
		else
			#Extract information from intermediate readings.
			FILE_HANDLES=`echo $LINE | awk '{print $4}'`;
			FILE_INODES=`echo $LINE | awk '{print $5}'`;
			FILE_PSEUDO_TERMS=`echo $LINE | awk '{print $6}'`;

			COMPARISON=`echo $FILE_HANDLES \> $FILE_HANDLES_PEAK | bc`
			if [ "1" == "$COMPARISON" ]; then
				FILE_HANDLES_PEAK=$FILE_HANDLES
			fi

			COMPARISON=`echo $FILE_INODES \> $FILE_INODES_PEAK | bc`
			if [ "1" == "$COMPARISON" ]; then
				FILE_INODES_PEAK=$FILE_INODES;
			fi

			COMPARISON=`echo $FILE_PSEUDO_TERMS \> $FILE_PSEUDO_TERMS_PEAK | bc`
			if [ "1" == "$COMPARISON" ]; then
				FILE_PSEUDO_TERMS_PEAK=$FILE_PSEUDO_TERMS;
			fi
		fi
	done;
	echo FILE_HANDLES_PEAK=$FILE_HANDLES_PEAK;
	echo FILE_INODES_PEAK=$FILE_INODES_PEAK;
	echo FILE_PSEUDO_TERMS_PEAK=$FILE_PSEUDO_TERMS_PEAK;
	 )
}

function analyze_fs_usage()
{
	df |
	(read; #read the header
	while read line; do
	if [ "`echo $line | awk '{print $6}'`" == "/" ]; then
		echo FS_ROOT_SIZE=`echo $line | awk '{print $2}'`
		echo FS_ROOT_USED=`echo $line | awk '{print $5}'`
	fi
	if [ "`echo $line | awk '{print $6}'`" == "/home" ]; then
		echo FS_HOME_SIZE=`echo $line | awk '{print $2}'`
		echo FS_HOME_USED=`echo $line | awk '{print $5}'`
	fi
	done)
}

function analyze_remote_login_info()
{
	who | 
	(
	LOGGED_IN_USERS=
	while read line; do
		USER=`echo $line | awk '{print $1}'`
		REMOTE_HOST=`echo $line | awk '{print $5}' | sed 's/(//g' | sed 's/)//g'`
		if [ -z "`echo $REMOTE_HOST | grep ^:`" ]; then
			LOGGED_IN_USERS=$LOGGED_IN_USERS$USER@$REMOTE_HOST,
		fi
	done;
	echo REMOTE_LOGINS_CURRENT=$LOGGED_IN_USERS
	)
}

function analyze_network_usage()
{
	NR_TCP_CONN=$((`netstat -t | (read; read; wc -l)`))
	echo NET_NR_TCP_CONN=$NR_TCP_CONN;

	/sbin/ip -s link | 
	(
	while read LINE; do
		IFACE_NAME=`echo $LINE | awk '{print $2}' | cut -d':' -f1`
		read; read; read LINE;
		IFACE_RX=`echo $LINE | awk '{print $1}'`
		read; read LINE;
		IFACE_TX=`echo $LINE | awk '{print $1}'`
		echo ${IFACE_NAME}_RXTX=$IFACE_NAME:$IFACE_RX:$IFACE_TX
	done
	)

	sar -f $LOGFILE -n DEV | grep ^Average |  
	(
	IFACE_LIST=
	while read LINE; do
		IFACE_NAME=`echo $LINE | awk '{print $2}'`
		IFACE_LIST="$IFACE_LIST $IFACE_NAME"
		export IFACE_$IFACE_NAME="$IFACE_NAME:`echo $LINE | awk '{print $5}'`:`echo $LINE | awk '{print $6}'`"
	done
	
	sar -f $LOGFILE -n EDEV | grep ^Average | 
	(
		while read LINE; do
			IFACE_NAME=`echo $LINE | awk '{print $2}'`
			eval export IFACE_$IFACE_NAME=\$IFACE_$IFACE_NAME:`echo $LINE | awk '{print $3}'`:`echo $LINE | awk '{print $4}'`:`echo $LINE | awk '{print $6}'`:`echo $LINE | awk '{print $7}'`
		done
		for iface in $IFACE_LIST; do
			eval echo IFACE_$iface=\$IFACE_$iface
		done
	)
	 )

	#sar -f $LOGFILE -n ICMP |  grep ^Average |
	#(
	#while read LINE; do
	#	#Average line
	#	ICMP_MSG_IN=`echo $LINE | awk '{print $2}'`;
	#	NFS_ECHO_REQ=`echo $LINE | awk '{print $4}'`;
	#	echo ICMP_MSG_IN=$ICMP_MSG_IN
	#	echo NFS_ECHO_REQ=$NFS_ECHO_REQ
	#done;
	# )

}

function analyze_nfs_stats()
{
	sar -f $LOGFILE -n NFS |  grep ^Average |
	(
	while read LINE; do
		#Average line
		NFS_CALLS=`echo $LINE | awk '{print $2}'`;
		NFS_READ_CALLS=`echo $LINE | awk '{print $4}'`;
		NFS_WRITE_CALLS=`echo $LINE | awk '{print $5}'`;
		NFS_RETRANSMISSIONS=`echo $LINE | awk '{print $3}'`;
		echo NFS_CALLS=$NFS_CALLS
		echo NFS_READ_CALLS=$NFS_READ_CALLS
		echo NFS_WRITE_CALLS=$NFS_WRITE_CALLS
		echo NFS_RETRANSMISSIONS=$NFS_RETRANSMISSIONS
	done;
	 )
}

LOGFILE=$1
if [ -z "$LOGFILE" ]; then
	usage;
	exit;
fi

analyze_cpu_usage;
analyze_mem_usage;
analyze_io_usage;
analyze_paging_usage;
analyze_task_stats;
analyze_file_usage;
analyze_fs_usage;
analyze_remote_login_info;
analyze_network_usage;
analyze_nfs_stats;
echo LOG_START
./parse_logs_images.sh
echo LOG_END
echo END

