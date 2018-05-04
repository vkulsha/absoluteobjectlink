import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

def sendmail(address_book, body):
	#address_book = ['kulshavi@guov.ru', 'kulshavi@guov.ru']
	msg = MIMEMultipart()    
	sender = 'AnaliticInformationSystem@guov.ru (don`t reply)'
	subject = "Аналитическая Информационная Система - Календарь - Напоминание..."
	#body = "Сдать отчетность НВОС 123..."

	msg['From'] = sender
	msg['To'] = ','.join(address_book)
	msg['Subject'] = subject
	msg.attach(MIMEText(body, 'plain'))
	text=msg.as_string()

	s = smtplib.SMTP('mail.guov.ru')
	s.sendmail(sender,address_book, text)
	s.quit() 
	return 1    