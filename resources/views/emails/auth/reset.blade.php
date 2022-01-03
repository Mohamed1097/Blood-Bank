@component('mail::message')
# Introduction
<h1>Welcome {{$client->name}} from {{config('app.name')}}</h1>
<p>blood Bank Rest Password</p>
<p>your Rest Code:{{$client->pin_code}}</p>

@component('mail::button', ['url' => 'google.com'])
Button Reset
@endcomponent

Thanks,{{config('app.name')}}<br>
{{ config('app.name') }}
@endcomponent
