<div class = 'layout'>
  <div class = 'header'>
    <img src = '{{asset('images/email-logo.png')}}'/>
    <h1>@lang('email.title')</h1>
  </div>
  <p>@lang('email.greeting') {{$notifiable->name}}!</p>
  <p>@lang('email.ice-breaker')<p>
  <a class='button' href="{{$frontURL}}">@lang('email.button')</a>
  <p>@lang('email.help')</p>
  <a class='link' href="{{$frontURL}}">{{$frontURL}}</a>
  <p>@lang('email.contact')</p>
  <p>@lang('email.crew')</p>
</div>