# Create your views here.
from django.template import loader, Context
from django.shortcuts import get_object_or_404, render, render_to_response, RequestContext
from django.http import HttpResponseRedirect, HttpResponse
from young.models import Event, Player, Log, GEO, Image, EventTodo, Session

import base64
from datetime import datetime

def index(request):
    EventList = Event.objects.filter( begin_time__gte = datetime.now() ).order_by('begin_time')
    LastEvent = EventList.reverse()[0]
    template = loader.get_template('young/index.html')
    context = Context({
        'object':EventList,
        'last':LastEvent,
    })
    return HttpResponse(template.render(context))

def detail(request, event_id):
    event = get_object_or_404(Event, pk=event_id)
    template = loader.get_template('young/detail.html')
    context = Context({
      'object' : event,
    })
    return HttpResponse(template.render(context))

def JSON(request, event_id):
    event = get_object_or_404(Event, pk=event_id)
    template = loader.get_template('young/JSON.html')
    context = Context({
      'object' : event,
    })
    return HttpResponse(template.render(context))
def GPSA(request, X, Y, user):
    print float(X)
    print float(Y)
    print user
    temp = GEO()
    temp.Location_X = float(X)
    temp.Location_Y = float(Y)
    temp.User = user
    temp.save()
    template = loader.get_template('young/ReturnID.html')
    context = Context({
        'object':temp,
    })
    return HttpResponse(template.render(context))
def ImageA(request, Url, user):
    print Url 
    print user
    temp = Image()
    temp.Url = base64.urlsafe_b64decode(Url.__str__()) 
    temp.User = user
    temp.save()
    template = loader.get_template('young/ReturnID.html')
    context = Context({
        'object':temp,
    })
    return HttpResponse(template.render(context))
def MyGPS(request, user):
    MyGPSList = GEO.objects.filter(User = user)
    print MyGPSList
    template = loader.get_template('young/MyGPS.html')
    context = Context({
        'object': MyGPSList  ,
    })
    return HttpResponse(template.render(context))
def MyPic(request, user):
    MyPicList = Image.objects.filter(User = user)
    print MyPicList
    template = loader.get_template('young/MyPic.html')
    context = Context({
        'object': MyPicList  ,
    })
    return HttpResponse(template.render(context))
def RegEvent(request, user):
    MyPicList = Image.objects.filter(User = user)
    MyGPSList = GEO.objects.filter(User = user)
    template = loader.get_template('young/RegEvent.html')
    context = Context({
        'PicList': MyPicList  ,
        'GPSList': MyGPSList  ,
        'user' : user,
    })
    return render_to_response('young/RegEvent.html',{'PicList':MyPicList,'GPSList':MyGPSList,'user':user},context_instance=RequestContext(request)) 
def Reg(request):
#    print request.POST['begin_time']
#    print request.POST['end_time']
    temp = EventTodo()
    temp.title = request.POST['title'].encode('utf-8') 
    temp.description = request.POST['description'].encode('utf-8')
    temp.geo = request.POST['GPS'].__str__()
    temp.image_lmobile = request.POST['Pic'].__str__()
    temp.pub_date = datetime.now()
    temp.begin_time = datetime.strptime(request.POST['begin_time'],'%Y-%m-%d %H:%M:%S')
    temp.end_time = datetime.strptime(request.POST['end_time'],'%Y-%m-%d %H:%M:%S')
    temp.save()
    temp.adapt_url = "http://nanyang.xjtu.edu.cn:8080/young/"+temp.id.__str__()+"/detail/"
    temp.adddress = request.POST['address']
    temp.owner = request.POST['owner']
    temp.save()
    template = loader.get_template('young/RegDone.html')
    context = Context({
        'object':temp,
    })
    return HttpResponse(template.render(context))
def GetSession(request, user, movement):
    if movement == 'a':
        MySession = get_object_or_404(Session, User = user)
        MySession.Page += 1
        MySession.save()
    elif movement == 's':
        MySession = get_object_or_404(Session, User = user)
        MySession.Page -= 1
        MySession.save()
    elif movement == 'g':
        MySession = get_object_or_404(Session, User = user)
    else:
        try:
            MySession = Session.objects.get(User = user)
        except Session.DoesNotExist:
            MySession = Session()

        MySession.User = user
        MySession.Page = 0
        MySession.Category = base64.urlsafe_b64decode(movement.__str__()) 
        MySession.save()
    
    template = loader.get_template('young/JSON.html')
    context = Context({
        'object': MySession  ,
    })
    return HttpResponse(template.render(context))
