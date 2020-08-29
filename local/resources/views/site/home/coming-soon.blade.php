<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ URL::to('logo/favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ URL::to('site/coming-soon/compiled/flipclock.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="{{ URL::to('site/coming-soon/compiled/moment.js') }}"></script>
    <script src="{{ URL::to('site/coming-soon/compiled/flipclock.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::to('site/coming-soon/css/coming-soon.css') }}">
</head>


<body>
    <div class="main-box">
        <div class="container">
            <div class="row">
                <div class="logo-box">
                    <a href=""><img width="100" src="{{ URL::to('logo/logo.png') }}"></a>
                </div>
                <div class="content-box">
                    <h1 class="heading">Welcome!</h1>
                    <p class="info">We are happy to see you, our site is almost ready.</p>
                    <p class="gray-color info">Please come back later and we'll surprise you!</p>
                    <div class="development-box">
                      <h1 class="middle-section " style="font-size:90px; color:#699e50;">Coming Soon & Maintenance Mode</h1>
                    </div>
                    <p class="font-24">Time Left Until <span class="red-text">Launching...</span>
                        <div class="clock" style="margin:2em auto;"></div>
                        <div class="message"></div>
                </div>
            </div>
        </div>

        <footer class="footer-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="social-icons">
                            <li>
                                <a href=""><img src="{{ URL::to('site/coming-soon/images/facebook.png') }}"></a>
                            </li>
                            <li>
                                <a href=""><img src="{{ URL::to('site/coming-soon/images/instagram.png') }}"></a>
                            </li>
                            <li>
                                <a href=""><img src="{{ URL::to('site/coming-soon/images/link.png') }}"></a>
                            </li>
                            <li>
                                <a href=""><img src="{{ URL::to('site/coming-soon/images/twitter.png') }}"></a>
                            </li>
                        </ul>
                    </div>
                    <div class="cok-md-7">
                        <p class="copy-right">© 2020 - Laravel All Right Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
    <script type="text/javascript">
        var clock;
        $(document).ready(function() {
            var deadline_date = moment("2020-12-31")
            deadline_date = deadline_date.diff(moment(), 'second');
            var clock = $('.clock').FlipClock(3600 * 24 * 3, {
                clockFace: 'DailyCounter',
                countdown: true
            });
            clock.setTime(deadline_date);
            clock.setCountdown(true);
            clock.start();

        });

        // var socket = io('http://localhost:3001',{'query': {user_id : 1, token : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2tpZHpvb25cL2FwaVwvdjFcL3JlZnJlc2hcL3Rva2VuIiwiaWF0IjoxNTk0MjA3MjMzLCJleHAiOjE1OTQ1NzI2NjAsIm5iZiI6MTU5NDIxMjY2MCwianRpIjoiNWZ0NE05QU5ZTGc3TDlRVSIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.u82EFzT_IqDk2oWdjmXLXj33yYBkPA4b5VAPFkTV-DI"}});
        var socket = io('http://www.development.htf.sa:3001',{'query': {user_id : 1, token : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2tpZHpvb25cL2FwaVwvdjFcL3JlZnJlc2hcL3Rva2VuIiwiaWF0IjoxNTk0MjA3MjMzLCJleHAiOjE1OTQ1NzI2NjAsIm5iZiI6MTU5NDIxMjY2MCwianRpIjoiNWZ0NE05QU5ZTGc3TDlRVSIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.u82EFzT_IqDk2oWdjmXLXj33yYBkPA4b5VAPFkTV-DI"}});
        socket.on('connect', function(){
            console.log("Connection established");
        });
        socket.on('reconnect_attempt', () => {
            socket.io.opts.transports = ['polling', 'websocket'];
            console.log("reconnect_attempt");
        });
        socket.on('connect_error', (error) => {
            console.log("connect_error", error);
        });
        socket.on('connect_timeout', (timeout) => {
            console.log("connect_timeout", timeout)
        });
        socket.on('error', (error) => {
            console.log("error", error);
        });
        socket.on('disconnect', (reason) => {
            console.log("reason", reason);
            if (reason === 'io server disconnect') {
                socket.connect();
            }
        });
        socket.on('reconnect', (attemptNumber) => {
            console.log("reconnect", attemptNumber)
        });
        socket.on('reconnect_attempt', (attemptNumber) => {
            console.log("reconnect_attempt", attemptNumber)
        });
        socket.on('reconnecting', (attemptNumber) => {
            console.log("reconnecting", attemptNumber)
        });
        socket.on('reconnect_error', (error) => {
            console.log("reconnect_error", error)
        });
        socket.on('reconnect_failed', () => {
            console.log("reconnect_failed")
        });
        socket.on('ping', () => {
            console.log(`ping`);
        });
        socket.on('pong', (latency) => {
            console.log(`pong- ${latency}`);
        });
    </script>
</body>

</html>
