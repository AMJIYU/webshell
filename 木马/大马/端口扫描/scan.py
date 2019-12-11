
import threading
import socket
 
 
def scan(ip, port):
    """
    """
    global portList   #建立了一个list,将目的主机开放的端口号加入portlist中（使用append函数）
    try:
        sk = socket.socket()
        sk.settimeout(0.1)#设定连接时的超时限制，这里是100ms
        address = (ip, port)
        if sk.connect_ex(address) == 0:
            print port
            portList.append(port)
    except Exception, e:
        print "error %s" %e   #如果出错，打印错误信息
        
    sk.close()
 
class sniff(threading.Thread):
    """
    """
    
    def __init__(self, ip):
        """
        """
        threading.Thread.__init__(self)
        self.ip = ip
 
    def run(self): #重写run函数
        """
        """
        global portBegin, portEnd, mutex
        while True:
            mutex.acquire()   #使用锁来实现线程同步
            portBegin += 1
            if portBegin > portEnd:
                mutex.release()
                break
            mutex.release()
            scan(self.ip, portBegin)
 
def main():  #主函数
    """
    """
    url = str(raw_input("please input a host name or a ip address\n--->"))
    ip = str(socket.gethostbyname(url))
 
    threads = []           #创建list,存储线程
    global mutex, portBegin, portEnd, portList
    portList = []
    portBegin = 0          #设置起始的扫描端口
    portEnd = 1023         #设置终止的扫描端口
    mutex = threading.Lock()
    for i in range(10):    #开了十个线程
        thread = sniff(ip)
        thread.start()
        threads.append(thread)
 
    for thread in threads:
        thread.join()       #等段子线程退出
 
    portList.sort()
    print "on host \"",url,"\" port:[",
    for port in portList:
        print port,
    print "]is open"
 
main()    
