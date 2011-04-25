#!/usr/bin/python

import sys
import MySQLdb
import os
import commands

try:
     conn = MySQLdb.connect (host = "localhost",
                             user = "root",
                             passwd = "sm3")
     cursor = conn.cursor()
     cursor.execute("create database provenance")
     cursor.close()

except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

conn.commit()
conn.close()

try:
     conn = MySQLdb.connect (host = "localhost",
                             user = "root",
                             passwd = "sm3", 
			     db = "provenance" )

     cursor = conn.cursor()

     query_str_1 = "create table mn_info ( mn_id int NOT NULL primary key, mn_gre varchar(10), mn_public_ip varchar(50), my_tunn_addr varchar(50), mn_tunn_addr varchar(50) ) engine=innodb " 
 
     cursor.execute(query_str_1)

     query_str_2 = "create table mn_image ( mn_id int, image_id int, name varchar(100), prettyname varchar(100), lastupdate datetime, datecreated datetime, primary key (mn_id, image_id), foreign key (mn_id) references mn_info(mn_id) ) engine=innodb "
 
     cursor.execute(query_str_2)

     query_str_8 = "create table mn_user ( mn_id int, user_id int, unityid varchar(80), firstname varchar(50), lastname varchar(50), primary key (mn_id, user_id), foreign key(mn_id) references mn_info(mn_id) ) engine=innodb "
 
     cursor.execute(query_str_8)

     query_str_6 = "create table mn_computer ( mn_id int, computer_id int, eth0macaddress varchar(20), lastcheck datetime, ip_address varchar(15), private_ip_address varchar(15), primary key (mn_id, computer_id), foreign key (mn_id) references mn_info(mn_id) ) engine=innodb "
 
     cursor.execute(query_str_6)


     query_str_5 = "create table mn_log ( mn_id int, log_id int, image_id int, request_id int, user_id int, computer_id int, start datetime, initialend datetime, finalend datetime, primary key (mn_id, log_id), foreign key (mn_id, image_id) references mn_image(mn_id, image_id), foreign key (mn_id, user_id) references mn_user(mn_id, user_id) ) engine=innodb "
 
     cursor.execute(query_str_5)

     query_str_4 = "create table mn_request ( mn_id int, request_id int, logid int, user_id int, start datetime, end datetime, daterequested datetime, primary key (mn_id, request_id), foreign key (mn_id) references mn_info(mn_id), foreign key (mn_id, user_id) references mn_user(mn_id, user_id) ) engine=innodb "
 
     cursor.execute(query_str_4)

     query_str_3 = "create table mn_reservation ( mn_id int, log_id int, image_id int, request_id int, reservation_id int, computer_id int, mnnode int, lastcheck datetime, primary key (mn_id, log_id), foreign key (mn_id, image_id) references mn_image(mn_id, image_id), foreign key (mn_id, request_id) references mn_request(mn_id, request_id), foreign key (mn_id, log_id) references mn_log(mn_id,log_id) ) engine=innodb "
 
     cursor.execute(query_str_3)

     query_str_7 = "create table mn_dyn_info ( mn_id int, log_id int, image_id int, reservation_id int, cpu_num_cores int, cpu_idle float, cpu_peak float, cpu_loadavg float, mem_size float, mem_free float, mem_used float, mem_peak_used float, io_block_reads float, io_block_writes float, eth0_rx float, eth0_tx float, eth1_rx float, eth1_tx float, row_count int, paging_faults float, peak_num_TCP_conn float, fs_root_used float, primary key (mn_id, image_id, log_id), foreign key (mn_id, image_id) references mn_image(mn_id, image_id), foreign key (mn_id, log_id) references mn_log(mn_id, log_id) ) engine=innodb"

     cursor.execute(query_str_7)

     query_str_9 = "create table mn_sec_log ( mn_id int, log_id int, log_line varchar(500), severity int, daemon_name varchar(50), sec_log_id int auto_increment primary key, foreign key (mn_id) references mn_info(mn_id) ) engine=innodb "
 
     cursor.execute(query_str_9)

     cursor.close()
     conn.commit()
     conn.close()

     conn = MySQLdb.connect (host = "localhost",
                             user = "root",
                             passwd = "sm3", 
			     db = "provenance" )

     cursor = conn.cursor()

     fp = open("/tmp/tab_mn_info","r")

     while True:

        data = fp.readline()

        if len(data) == 0:
                break
        # print "%s" % (data)
	
	data = data.split("#")
        mn_id = data[0]
	mn_gre = data[2]
	mn_public_ip = data[1]
        my_tunn_addr = data[3]
        tunn_addr = data[4].split("\n")
	mn_tunn_addr = tunn_addr[0]

        query_str = "insert into mn_info values ( %d, '%s', '%s', '%s', '%s' )" % (int(mn_id), mn_gre, mn_public_ip, my_tunn_addr, mn_tunn_addr)
   
	# print "%s" % (query_str)
	
	cursor.execute(query_str)
        
     cursor.close()

except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

conn.commit()
conn.close()
