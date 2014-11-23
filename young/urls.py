from django.conf.urls import patterns, url

from young import views

urlpatterns = patterns('',
    url(r'^$', views.index, name='index'),
    url(r'^(?P<event_id>\d+)/$', views.JSON, name='JSON'),
    # ex: /polls/5/results/
    url(r'^(?P<event_id>\d+)/detail/$', views.detail, name='detail'),
    url(r'^GPS/(?P<X>\d+\.\d{6})/(?P<Y>\d+\.\d{6})/(?P<user>\w+)/$',views.GPSA),
    url(r'^Image/(?P<Url>.+)/(?P<user>\w+)/$',views.ImageA),
    url(r'^MyGPS/(?P<user>\w+)/$',views.MyGPS),
    url(r'^MyPic/(?P<user>\w+)/$',views.MyPic),
    url(r'^RegEvent/(?P<user>\w+)/$',views.RegEvent),
    url(r'^Reg/$',views.Reg),
    url(r'^Session/(?P<user>\w+)/(?P<movement>.+)/$',views.GetSession),
    url(r'^RES/(?P<path>.*)$','django.views.static.serve',{'document_root':settings.RES_PATH}),
    # ex: /polls/5/vote/
#    url(r'^(?P<poll_id>\d+)/vote/$', views.vote, name='vote'),

)

