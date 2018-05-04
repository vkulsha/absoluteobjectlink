from datetime import date
from urllib.request import urlopen
import urllib.parse
import json
import ais_mail

base_url = 'http://localhost/php/olp.php?'
today = str(date.today().strftime('%d.%m.%Y'))
params = urllib.parse.urlencode({'f':'gT2' ,'p':'[["Календарь","Дата","Дата напоминания","Описание","Email"],[],[],false,null,"and (`Дата напоминания` =\''+today+'\' or `Дата` =\''+today+'\') "]', 'u':1577})

url = base_url + params

data = urlopen(url).read().decode("utf-8")
jsdata = json.loads(data)

for row in jsdata:
	email = row[9]
	body = row[3] + " - " + row[7]
	ais_mail.sendmail([email], body)

