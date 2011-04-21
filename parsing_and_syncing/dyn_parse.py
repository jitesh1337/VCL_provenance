#!/usr/bin/python
import sys
import math
import MySQLdb

# Usage: ./dyn_prase.py <mn_id> <logfile> > /dev/null

if len(sys.argv) != 3:
	sys.exit("Provide the mn_id and logfile as command line argument!")

set_mn = int(sys.argv[1])
logfile = sys.argv[2]

#Connection to the required Database (Provenance Image)
conn = MySQLdb.connect (host = "localhost",
                           user = "root",
                           passwd = "sm3",
                           db = "provenance")
#Start a connection
cursor = conn.cursor ()

fp = open(logfile, "r")

IMAGE_ID=0
RESERVATION_ID=0
CPU_NUM_CORES=0
CPU_IDLE=0
CPU_PEAK=0
CPU_LOADAVG=0
MEM_SIZE=0
MEM_FREE=0
MEM_USED=0
IO_BLOCK_READS=0
IO_BLOCK_WRITES=0
eth0_rx=0
eth0_tx=0
wlan0_rx=0
wlan0_tx=0

while True:
	line = fp.readline()
	
	if len(line) == 0:
		break

	line = line.split("=")
	if line[0] == "IMAGE_ID":
		IMAGE_ID = int(line[1])
		# print IMAGE_ID
	if line[0] == "RESERVATION_ID":
		RESERVATION_ID = int(line[1])
		# print RESERVATION_ID
	
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

	if line[0] == "wlan0_RXTX":
		line_1 = line[1].split(":")
		wlan0_rx = line_1[1]
		line_2 = line_1[2].split("\n")
		wlan0_tx = line_2[0]
		sql = "insert into mn_dyn_info values (%d,%d,%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)" % (set_mn, IMAGE_ID, RESERVATION_ID, CPU_NUM_CORES,CPU_IDLE,CPU_PEAK,CPU_LOADAVG,MEM_SIZE,MEM_FREE,MEM_USED,IO_BLOCK_READS,IO_BLOCK_WRITES,eth0_rx,eth0_tx,wlan0_rx,wlan0_tx)
		cursor.execute(sql)
		print sql

cursor.close()
conn.close()

