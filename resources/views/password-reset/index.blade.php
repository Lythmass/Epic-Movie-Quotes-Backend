<div class = 'layout'>
  <div class = 'header'>
    <img src = '{{asset('images/email-logo.png')}}'/>
    <h1>@lang('password-reset.title')</h1>
  </div>
  <p>@lang('password-reset.greeting') {{$notifiable->name}}!</p>
  <p>@lang('password-reset.ice-breaker')<p>
  <a class='button' href="{{$frontURL}}">@lang('password-reset.button')</a>
  <p>@lang('password-reset.help')</p>
  <a class='link' href="{{$frontURL}}">{{$frontURL}}</a>
  <p>@lang('email.contact')</p>
  <p>@lang('email.crew')</p>
</div>