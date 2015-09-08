import smtpd, email
import asyncore

class CustomSMTPServer(smtpd.SMTPServer):
    
    def process_message(self, peer, mailfrom, rcpttos, data):
        print 'Receiving message from:', peer
        print 'Message addressed from:', mailfrom
        print 'Message addressed to  :', rcpttos
        print 'Message length        :', len(data)
	POLLPATH = '/var/www/jobswa/'
	f=open(u'{0}msgSMTP.txt'.format(POLLPATH), 'w+')
	dmsg = email.message_from_string(data)
	if dmsg.is_multipart():
		for payload in dmsg.get_payload():
		# if payload.is_multipart(): ...
			print 'Handling multipart payload'
			print payload.get_payload()
	else:
		print dmsg.get_payload()
		f.write(dmsg.get_payload())
	f.close()
        return

server = CustomSMTPServer(('0.0.0.0', 8196), None)

asyncore.loop()
