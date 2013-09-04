from django.contrib import admin
from young.models import Event, Player, Log, GEO, Image, EventTodo, Session

admin.site.register(Event)
admin.site.register(EventTodo)
admin.site.register(Player)
admin.site.register(Log)
admin.site.register(GEO)
admin.site.register(Image)
admin.site.register(Session)
