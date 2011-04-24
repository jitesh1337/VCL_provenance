#!/usr/bin/python
import sys
import math
import MySQLdb
import os

# Usage: ./dyn_prase.py <mn_id> <logfile> > /dev/null

if len(sys.argv) != 3:
	sys.exit("Provide the mn_id and logfile as command line argument!")

set_mn = int(sys.argv[1])
logfile = sys.argv[2]


def check_if_exists(image_id, log_id):

	f_conn = MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	f_cursor = f_conn.cursor()

	sql = "select mn_id, log_id, image_id from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	f_cursor.execute(sql)

	if f_cursor.rowcount == 0:
		f_cursor.close()
		f_conn.close()
		return 1
	else:
		f_cursor.close()
		f_conn.close()
		return 0

def get_row_count(image_id, log_id):

	g_conn	= MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	g_cursor = g_conn.cursor()

	sql = "select * from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	g_cursor.execute(sql)

	rows = g_cursor.fetchone();
	count = rows[17]

	g_cursor.close()
	g_conn.close()
	print "count is : %s" % (count)
	return count

def get_cpu_idle(image_id, log_id):

	g_conn	= MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	g_cursor = g_conn.cursor()

	sql = "select  * from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	g_cursor.execute(sql)

	row = g_cursor.fetchone()
	c_idle = int(row[5])

	g_cursor.close()
	g_conn.close()
	print "cpu_idle is : %d" % (c_idle)
	return c_idle

def get_cpu_peak(image_id, log_id):

	g_conn	= MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	g_cursor = g_conn.cursor()

	sql = "select  * from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	g_cursor.execute(sql)

	row = g_cursor.fetchone()
	c_peak = int(row[6])

	g_cursor.close()
	g_conn.close()
	print "cpu_peak is : %d" % (c_peak)
	return c_peak

def get_mem_size(image_id, log_id):

	g_conn	= MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	g_cursor = g_conn.cursor()

	sql = "select  * from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	g_cursor.execute(sql)

	row = g_cursor.fetchone()
	m_size = int(row[8])

	print "mem_size is : %d" % (m_size)
	return m_size

def get_mem_free(image_id, log_id):

	g_conn	= MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	g_cursor = g_conn.cursor()

	sql = "select  * from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	g_cursor.execute(sql)

	row = g_cursor.fetchone()
	m_free = int(row[9])

	print "mem_free is : %d" % (m_free)
	return m_free

def get_mem_used(image_id, log_id):

	g_conn	= MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	g_cursor = g_conn.cursor()

	sql = "select  * from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	g_cursor.execute(sql)

	row = g_cursor.fetchone()
	m_used = int(row[10])

	print "mem_used is : %d" % (m_used)
	return m_used

def get_io_block_reads(image_id, log_id):

	g_conn	= MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	g_cursor = g_conn.cursor()

	sql = "select  * from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	g_cursor.execute(sql)

	row = g_cursor.fetchone()
	io_b_reads = int(row[12])

	print "io_b_reads is : %d" % (io_b_reads)
	return io_b_reads

def get_io_block_writes(image_id, log_id):

	g_conn	= MySQLdb.connect ( host = "localhost",
					user = "root",
					passwd = "sm3",
					db = "provenance")
	g_cursor = g_conn.cursor()

	sql = "select  * from mn_dyn_info where mn_id = %d and image_id = %d and log_id = %d" % (set_mn,image_id,log_id)
	g_cursor.execute(sql)

	row = g_cursor.fetchone()
	io_b_writes = int(row[13])

	print "io_b_reads is : %d" % (io_b_writes)
	return io_b_writes


#Connection to the required Database (Provenance Image)
conn = MySQLdb.connect (host = "localhost",
                           user = "root",
                           passwd = "sm3",
                           db = "provenance")
#Start a connection
cursor = conn.cursor ()

fp = open(logfile, "r")

IMAGE_ID=0
LOG_ID=0
RESERVATION_ID=0
CPU_NUM_CORES=0
CPU_IDLE=0
CPU_PEAK=0
CPU_LOADAVG=0
MEM_SIZE=0
MEM_FREE=0
MEM_USED=0
MEM_PEAK_USED=0
IO_BLOCK_READS=0
IO_BLOCK_WRITES=0
eth0_rx=0
eth0_tx=0
eth1_rx=0
eth1_tx=0

flag=0

while True:
	line = fp.readline()
	
	if len(line) == 0:
		break
	line_2 = line
	line_3 = line_2.split("\n")
	line = line_3[0]

	if line == "LOG_START":

		if IMAGE_ID == 0 and LOG_ID == 0:
			continue

		conn = MySQLdb.connect (host = "localhost",
                           user = "root",
                           passwd = "sm3",
                           db = "provenance")
		cursor = conn.cursor()

		count = get_row_count(IMAGE_ID, LOG_ID)

		c_idle = get_cpu_idle(IMAGE_ID, LOG_ID)
		CPU_IDLE = ( float(CPU_IDLE) + (count*c_idle) ) / (count+1)

		c_peak = get_cpu_peak(IMAGE_ID, LOG_ID)
		if CPU_PEAK < c_peak:
			CPU_PEAK = c_peak

		m_size = get_mem_size(IMAGE_ID, LOG_ID)
		MEM_SIZE = ( float(MEM_SIZE) + (count*m_size) ) / (count+1)

		m_free = get_mem_free(IMAGE_ID, LOG_ID)
		MEM_FREE = ( float(MEM_FREE) + (count*m_free) ) / (count+1)

		m_used = get_mem_used(IMAGE_ID, LOG_ID)
		MEM_USED = ( float(MEM_USED) + (count*m_used) ) / (count+1)

		io_b_reads = get_io_block_reads(IMAGE_ID, LOG_ID)
		IO_BLOCK_READS = ( float(IO_BLOCK_READS) + io_b_reads )

		io_b_writes = get_io_block_writes(IMAGE_ID, LOG_ID)
		IO_BLOCK_WRITES = ( float(IO_BLOCK_WRITES) + io_b_writes )

		count = count + 1;
		sql = "update mn_dyn_info set cpu_num_cores=%s, cpu_idle=%s, cpu_peak=%s, cpu_loadavg=%s, mem_size=%s, mem_free=%s, mem_used=%s, mem_peak_used=%s, io_block_reads=%s, io_block_writes=%s, eth0_rx=%s, eth0_tx=%s, eth1_rx=%s, eth1_tx=%s, row_count=%d where mn_id=%d and image_id=%d and log_id=%d " % (CPU_NUM_CORES,CPU_IDLE,CPU_PEAK,CPU_LOADAVG,MEM_SIZE,MEM_FREE,MEM_USED,MEM_PEAK_USED, IO_BLOCK_READS,IO_BLOCK_WRITES,eth0_rx,eth0_tx,eth1_rx,eth1_tx, count, set_mn, IMAGE_ID, LOG_ID)	
		print sql
		cursor.execute(sql)

	if line == "DAEMON_END":
		flag = 0
		
	if flag == 0:
		line = line.split("=")

	if flag == 1:
		line = line.split("#")
		LOG_SEVERITY = line[0]
		line_1 = line[1].split("\n")
		LOG_LINE = line_1[0]
		i_conn =  MySQLdb.connect (host = "localhost",
                           user = "root",
                           passwd = "sm3",
                           db = "provenance")
		i_cursor = i_conn.cursor()
		sql = "insert into mn_sec_log values ( %d, %d, \"%s\", %d, \"%s\" )" % (set_mn,LOG_ID,LOG_LINE,int(LOG_SEVERITY),DAEMON_NAME)
		print sql
		i_cursor.execute(sql)
		i_cursor.close()
		i_conn.commit()
		i_conn.close()

	if line[0] == "IMAGE_ID":
		IMAGE_ID = int(line[1])
		# print IMAGE_ID
	if line[0] == "LOG_ID":
		LOG_ID = int(line[1])
		# print LOG_ID
	if line[0] == "RESERVATION_ID":
		RESERVATION_ID = int(line[1])
		if IMAGE_ID == 0 and LOG_ID == 0:
			continue
		# print RESERVATION_ID
		ret = check_if_exists(IMAGE_ID, LOG_ID)
		print ret
		if ret == 1:
			mn_id = sys.argv[1]
			str = "python /root/VCL_provenance/parsing_and_syncing/e_client.py " + mn_id
			os.system(str)
			sql = "insert into mn_dyn_info values (%d,%d,%d,%d, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)" % (set_mn, LOG_ID, IMAGE_ID, RESERVATION_ID)
			print sql
			cursor.execute(sql)
			cursor.close()
			conn.commit()
			conn.close()
	
	if line[0] == "CPU_NUM_CORES":
		CPU_NUM_CORES = int(line[1])

	if line[0] == "CPU_IDLE":
		line_1 = line[1].split("\n")
		CPU_IDLE = line_1[0]

	if line[0] == "CPU_PEAK":
		line_1 = line[1].split("\n")
		CPU_PEAK = line_1[0]

	if line[0] == "CPU_LOADAVG_1":
		line_1 = line[1].split("\n")
		CPU_LOADAVG = line_1[0]

	if line[0] == "MEM_SIZE":
		line_1 = line[1].split("\n")
		MEM_SIZE = line_1[0]

	if line[0] == "MEM_FREE":
		line_1 = line[1].split("\n");
		MEM_FREE = line_1[0]

	if line[0] == "MEM_USED":
		line_1 = line[1].split("\n")
		MEM_USED = line_1[0]

	if line[0] == "MEM_PEAK_USED":
		line_1 = line[1].split("\n")
		MEM_PEAK_USED = line_1[0]


	if line[0] == "IO_BLOCK_READS":
		line_1 = line[1].split("\n")
		IO_BLOCK_READS = line_1[0]

	if line[0] == "IO_BLOCK_WRITES":
		line_1 = line[1].split("\n")
		IO_BLOCK_WRITES = line_1[0]

	if line[0] == "eth0_RXTX":
		line_1 = line[1].split(":")
		eth0_rx = line_1[1]
		line_2 = line_1[2].split("\n")
		eth0_tx = line_2[0]

	if line[0] == "eth1_RXTX":
		line_1 = line[1].split(":")
		eth1_rx = line_1[1]
		line_2 = line_1[2].split("\n")
		eth1_tx = line_2[0]

	if line[0] == "DAEMON_NAME":
		line_1 = line[1].split("\n")
		DAEMON_NAME = line_1[0]
		flag = 1


cursor.close()
conn.commit()
conn.close()

