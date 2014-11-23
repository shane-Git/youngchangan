from django.db import models
import datetime

# Create your models here.
class Event(models.Model):
    title = models.CharField(max_length=20)
    pub_date = models.DateTimeField("data published")
    adapt_url = models.CharField(max_length=100)
    participant_count = models.IntegerField(default=0)
    image_lmobile = models.CharField(max_length=100)
    adddress = models.CharField(max_length=100)
    begin_time = models.DateTimeField("When the event start")
    end_time = models.DateTimeField("When the event end")
    geo = models.CharField(max_length=30)
    description = models.CharField(max_length=100)
    owner = models.CharField(max_length=30)
    def __unicode__(self):
        return self.title
    def printJSON(self):
        print self.begin_time
        time = self.begin_time + datetime.timedelta(hours = +8)
        return '{"adapt_url":"'+self.adapt_url+'","image_lmobile":"'+self.image_lmobile+'","content":"'+self.description+'"'+',"begin_time":"'+time.__str__()[0:19]+'","title":"'+self.title+'","owner":"'+self.owner+'"}'
    def printTime(self):
        Beg_time = self.begin_time + datetime.timedelta(hours = +8)
        End_time = self.end_time + datetime.timedelta( hours = +8)
        return Beg_time.__str__()[0:19]+"~"+End_time.__str__()[0:19]
    def printCalTime(self):
        return self.begin_time.strftime('%Y%m%dT%H%M%SZ')+'/'+self.end_time.strftime('%Y%m%dT%H%M%SZ')
    def reGEO(self):
        re = self.geo.split(",")
        return re[1]+","+re[0]
    def GEO(self):
        return self.geo
    def printTitle(self):
        return self.title
    def printAdd(self):
        return self.adddress
    @classmethod
    def GetCount(cls):
        i = '{"count":20,"start":0,"total":'+str(cls.objects.count())+',"events":['
        for e in cls.objects.all():
            i = i +  e.printJSON() + ','
        return i[0:-1] +']}'

class Player(models.Model):
    name = models.CharField(max_length=30)

    def __unicode__(self):
        return self.name

class Log(models.Model):
    game = models.ForeignKey(Event)
    person = models.ForeignKey(Player)
    desc = models.CharField(max_length=100)    
    def __unicode__(self):
        return self.desc

class GEO(models.Model):
    Location_X = models.FloatField()
    Location_Y = models.FloatField()
    User = models.CharField(max_length=32)
    def __unicode__(self):
        return self.User

class Image(models.Model):
    Url = models.CharField(max_length=200)
    User = models.CharField(max_length=32)
    def __unicode__(self):
        return self.User
class EventTodo(models.Model):
    title = models.CharField(max_length=30)
    pub_date = models.DateTimeField("data published")
    adapt_url = models.CharField(max_length=100)
    participant_count = models.IntegerField(default=0)
    image_lmobile = models.CharField(max_length=100)
    adddress = models.CharField(max_length=100)
    begin_time = models.DateTimeField("When the event start")
    end_time = models.DateTimeField("When the event end")
    geo = models.CharField(max_length=30)
    description = models.CharField(max_length=200)
    owner = models.CharField(max_length=30)
    def __unicode__(self):
        return self.title
    def printJSON(self):
        print self.begin_time
        time = self.begin_time + datetime.timedelta(hours = +8)
        return '{"adapt_url":"'+self.adapt_url+'","image_lmobile":"'+self.image_lmobile+'","content":"'+self.description+'"'+',"begin_time":"'+time.__str__()[0:19]+'","title":"'+self.title+'","owner":"'+self.owner+'"}'
    def printTime(self):
        Beg_time = self.begin_time + datetime.timedelta(hours = +8)
        End_time = self.end_time + datetime.timedelta( hours = +8)
        return Beg_time.__str__()[0:19]+"~"+End_time.__str__()[0:19]
    def printCalTime(self):
        return self.begin_time.strftime('%Y%m%dT%H%M%SZ')+'/'+self.end_time.strftime('%Y%m%dT%H%M%SZ')

    def GEO(self):
        return self.geo
    def reGEO(self):
        re = self.geo.split(",")
        return re[1]+","+re[0]
    def printTitle(self):
        return self.title
    def printAdd(self):
        return self.adddress
    @classmethod
    def GetCount(cls):
        i = '{"count":20,"start":0,"total":'+str(cls.objects.count())+',"events":['
        for e in cls.objects.all():
            i = i +  e.printJSON() + ','
        return i[0:-1] +']}'
class Session(models.Model):
    User = models.CharField(max_length=32)
    Category = models.CharField(max_length = 200)
    Page = models.IntegerField()
    def __unicode__(self):
        return self.User+'|'+self.Category.__str__()
    def printJSON(self):
        return '{"Category":"'+self.Category.__str__()+'","Page":'+ self.Page.__str__()  +'}'
