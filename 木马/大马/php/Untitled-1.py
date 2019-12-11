#!/usr/bin/env python
 
import socket
port_list = [80,21,22,23,3306,3389,1433,8080,800,11211,873,1522,1521,443]
socket.setdefaulttimeout(5)
def get_ip_status(ip,port):
    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    try:
        server.connect((ip,port))
        print('{0} port {1} is open'.format(ip, port))
    except Exception as err:
        pass
    finally:
        server.close()
 
if __name__ == '__main__':
    for i in range(1,254):
        for j in range(1,254):
            host = '10.5.%s.%s' % (i,j)
            for port in port_list:
                get_ip_status(host,port)