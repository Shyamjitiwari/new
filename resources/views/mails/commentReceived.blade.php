Hi,<br><br>
<p>{{$blog->name}} has received a new comment : </p>

<b>Comment details:-</b>
<br> <br>
User Name: {{$comment->name}}<br>
Description: {{$comment->description}}<br>

@if($comment->parent)

Parent Comment Id: {{$comment->parent->id}} <br>
Parent Comment Description: <p>{{$comment->parent->description}}</p><br>
Parent Comment user name: {{$comment->parent->name}}<br>
@endif
<br>
<hr>
<b>Total comments to this blog : {{$blog->comments->count()}}</b><br>

<b>Total approved comments to this blog : {{$blog->activeComments->count()}}</b><br>



Thanks<br>
Site Admin
