<div class = 'layout'>
  <div class = 'header'>
    <img src = '{{asset('images/email-logo.png')}}'/>
    <h1>MOVIE QUOTES</h1>
  </div>
  <p>Hola {{$notifiable->name}}!</p>
  <p>Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your account:<p>
  <a class='button' href="{{$frontURL}}">Verify account</a>
  <p>If clicking doesn't work, you can try copying and pasting it to your browser:</p>
  <a class='link' href="{{$frontURL}}">{{$frontURL}}</a>
  <p>If you have any problems, please contact us: support@moviequotes.ge</p>
  <p>MovieQuotes Crew</p>
</div>