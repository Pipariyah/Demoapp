@component('mail::message')
# Introduction



<h3>Hello,<i>{{$data["name"]}}</i></h3>
{{$data["name"]}}
Your performed action is successfully done
<br>
Your details are as belowe: <br>
Name: {{$data["name"]}},

@component('mail::button', ['url' => 'http://localhost/demoapp/public/datatables', 'color' => 'green'])
View Datatables
@endcomponent
Thanks,<br>
{{ config('app.name') }}    
@endcomponent
