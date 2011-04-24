#!/bin/bash

PIPE=parse_sar_output

if [ -z "`rpm -q MySQL-python | grep -v "not installed"`" ]; then
	yum install -y MySQL-python
fi

rm -f $PIPE
mkfifo $PIPE

killall image_to_mgmt_client.py
./image_to_mgmt_client.py &


while true; do
	./parse_logs.sh > $PIPE
	sleep 6
done
