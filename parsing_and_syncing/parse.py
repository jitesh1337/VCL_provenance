#!/usr/bin/python
import sys
import math
import MySQLdb

# Usage: ./prase.py <mn_id> > /dev/null

if len(sys.argv) != 2:
	sys.exit("Provide the mn_id as command line argument!")

set_mn = int(sys.argv[1])

#Connection to the required Database (Provenance Image)
conn = MySQLdb.connect (host = "localhost",
                           user = "root",
                           passwd = "sm3",
                           db = "provenance")
#Start a connection
cursor = conn.cursor ()
               

#Open the Dump File
fp = open("/tmp/output","r")

while True:
        data = fp.readline()

        if len(data) == 0:
                break
        #Process the header and stuff.
        if data.startswith( 'Table' ):
                data = data.split("#")
                #print data
                Table = data[1]
                ip = data[2]
                cols = int(data[3])
		#cols = 5
		Table = "mn_"+Table

                print "Table:",Table,"IP:",ip,"Rows:",cols
		#set_mn = "select mn_id from mn_info where mn_gre=%s" % (ip)

		
	else:
                str1 = data.split('#')
		newData = str1[(cols-1)].split("\n")
		str1[(cols-1)] = newData[0]
		i = 0

                sql = "insert into %s values(" % (Table)
                
		str_f = "%s," % (set_mn)

                while i<cols:
                        str_f = str_f + "\"%s\"" % (str1[i])
                        if i < (cols-1):
                                str_f = str_f + ","
                        i=i+1

                str_f = str_f + ")"

                sql = sql + str_f
		
		if Table == "mn_reservation":
			sql_1 = "delete from mn_reservation"
			cursor.execute(sql_1)

		cursor.execute(sql)	
	
		print "Inserting : ", sql




#cursor.execute ("SELECT name from image")

#while(1):
#       row = cursor.fetchone ()
#        if row == None:
#          break
#        print "Image Name:", row[0]

cursor.close ()
conn.commit()
conn.close ()
