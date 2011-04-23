#!/bin/bash

$PIPE=parse_sar_output

if [ -z "`rpm -q systat`" ]; then
        sudo yum install sysstat -y
fi

rm -f $PIPE
mkfifo $PIPE

killall image_to_mgmt_client.py 2>&1 > /dev/null
./image_to_mgmt_client.py &
rm -f log

while true; do
        sar -o log 2 6 > /dev/null
        ./parse_sar.sh log > $PIPE
        rm -f log
done
