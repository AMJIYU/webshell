#!/bin/bash
for ((i=1; i<=65535; i ++))
do
	nc 10.0.5.235.185 $i
    echo"port $i is open"
dones
