#!/usr/bin/python

import sys
import MySQLdb
import os
import commands

try:
     conn = MySQLdb.connect (host = "localhost",
                             user = "root",
                             passwd = "slashs")
     cursor = conn.cursor()
     cursor.execute("create database provenance")
     cursor.close()

except MySQLdb.Error, e:
     print "Error %d: %s" % (e.args[0], e.args[1])
     sys.exit (1)

conn.close()

try:
     conn = MySQLdb.connect (host = "localhost",
                             user = "root",
                             passwd = "slashs", 
			     db = "provenance" )

     cursor = conn.cursor()

     query_str_1 = "create table mn_info ( mn_id int NOT NULL primary key, mn_gre varchar(10), mn_public_ip varchar(20), my_tunn_addr varchar(20), mn_tunn_addr varchar(20) )" 
 
     cursor.execute(query_str_1)

     query_str_2 = "create table mn_images ( mn_id int, image_id int, name varchar(20), prettyname varchar(50), lastupdate datetime, datecreated datetime, primary key (mn_id, image_id)  )" 
 
     cursor.execute(query_str_2)

     query_str_3 = "create table mn_reservation ( mn_id int, image_id int, request_id int, reservation_id int, mnnode int, lastcheck datetime, primary key (mn_id, image_id, request_id, reservation_id)  )" 
 
     cursor.execute(query_str_3)

     query_str_4 = "create table mn_request ( mn_id int, request_id int, logid int, start datetime, end datetime, daterequested datetime, primary key (mn_id, request_id)  )" 
 
     cursor.execute(query_str_4)

     query_str_5 = "create table mn_log ( mn_id int, logid int, image_id int, request_id int, start datetime, initialend datetime, finalend datetime, primary key (mn_id, logid)  )" 
 
     cursor.execute(query_str_5)

     query_str_6 = "create table mn_computer ( mn_id int, computer_id int, eth0macaddress varchar(20), lastcheck datetime, reservation_id int, timestamp datetime, additionalinfo varchar(20), primary key (mn_id, computer_id)  )" 
 
     cursor.execute(query_str_6)


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

conn.close()
