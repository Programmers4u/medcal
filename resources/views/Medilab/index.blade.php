<!DOCTYPE html>
<html lang="{{ $locale }}">

<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{trans('app.name')}} | {{ trans('app.seo.title') }}</title>
  <meta name="description" content="{{trans('app.seo.description')}}">
  <meta name="keywords" content="{{trans('app.seo.keywords')}}">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">
  <link rel="stylesheet" type="text/css" href="{{ asset('medical/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('medical/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('medical/css/style.css') }}">
  {!! Analytics::render() !!}    
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
  
  <!--banner-->
  <section id="banner" class="banner">
    <div class="bg-color">
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="col-md-12">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
              <a class="navbar-brand" href="#"><img src="medical/img/logo.png" class="img-responsive" style="width: 140px; margin-top: -16px;"></a>
            </div>
            <div class="collapse navbar-collapse navbar-right" id="myNavbar">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#banner">Home</a></li>
              <li class=""><a href="#service">{{ trans('Functions') }}</a></li>
                <!--
                <li class=""><a href="#testimonial">Dlaczego MedCal?</a></li>
                <li class=""><a href="#pricing">Cennik</a></li>
                -->
                <li class=""><a href="#contact">{{ trans('Contact') }}</a></li>
                <li class=""><a href="login">{{ trans('Login') }}</a></li>
                <li class=""><a href="#" onclick="$('#myModal').modal('show');">Język</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <div class="container">
        <div class="row">
          <div class="banner-info">
            <div class="banner-logo text-center">
              <img src="medical/img/logo.png" class="img-responsive">
            </div>
            <div class="banner-text text-center">
              <h1 class="white">{{ trans('welcome.header') }}</h1>
            <p>{{ trans('welcome.subheader') }}</p>
            <a href="register" class="btn btn-appoint">{{ trans('welcome.btn.register') }}</a>
            </div>
            <div class="overlay-detail text-center">
              <a href="#service"><i class="fa fa-angle-down"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ banner-->
  
  @include('Medilab.section.function')
  
  @include('Medilab.section.contact')
  
  <!--footer-->
  <footer id="footer">
    <div class="top-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 marb20">
            <div class="ftr-tle">
              <h4 class="white no-padding">MedCal</h4>
            </div>
            <div class="info-sec">
              <p>Tworzymy unikalne i dedykowane oprogramowanie dla branży medycznej.</p>
            </div>
          </div>
          <!--div class="col-md-4 col-sm-4 marb20">
            <div class="ftr-tle">
              <h4 class="white no-padding">Skróty</h4>
            </div>
            <div class="info-sec">
              <ul class="quick-info">
                <li><a href="index.blade.php.html"><i class="fa fa-circle"></i>Home</a></li>
                <li><a href="#service"><i class="fa fa-circle"></i>Funkcje</a></li>
                <li><a href="#contact"><i class="fa fa-circle"></i>Kontakt</a></li>
              </ul>
            </div>
          </div-->
          <!--div class="col-md-4 col-sm-4 marb20">
            <div class="ftr-tle">
              <h4 class="white no-padding">Follow us</h4>
            </div>
            <div class="info-sec">
              <ul class="social-icon">
                <li class="bglight-blue"><i class="fa fa-facebook"></i></li>
                <li class="bgred"><i class="fa fa-google-plus"></i></li>
                <li class="bgdark-blue"><i class="fa fa-linkedin"></i></li>
                <li class="bglight-blue"><i class="fa fa-twitter"></i></li>
              </ul>
            </div>
          </div-->
        </div>
      </div>
    </div>
    <div class="footer-line">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            © 2020 Copyright MedCal. All Rights Reserved
            <div class="credits">
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--/ footer-->

  <script src="medical/js/jquery.min.js"></script>
  <script src="medical/js/bootstrap.min.js"></script>
  <script src="medical/js/custom.js"></script>
  <script>
  jQuery(document).ready(function($) {
  "use strict";

  //Contact
  $('form.contactForm').submit(function() {
    var f = $(this).find('.form-group'),
      ferror = false,
      emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i;

    f.children('input').each(function() { // run all inputs

      var i = $(this); // current input
      var rule = i.attr('data-rule');

      if (rule !== undefined) {
        var ierror = false; // error flag for current input
        var pos = rule.indexOf(':', 0);
        if (pos >= 0) {
          var exp = rule.substr(pos + 1, rule.length);
          rule = rule.substr(0, pos);
        } else {
          rule = rule.substr(pos + 1, rule.length);
        }

        switch (rule) {
          case 'required':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'minlen':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;

          case 'email':
            if (!emailExp.test(i.val())) {
              ferror = ierror = true;
            }
            break;

          case 'checked':
            if (! i.is(':checked')) {
              ferror = ierror = true;
            }
            break;

          case 'regexp':
            exp = new RegExp(exp);
            if (!exp.test(i.val())) {
              ferror = ierror = true;
            }
            break;
        }
        i.next('.validation').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    f.children('textarea').each(function() { // run all inputs

      var i = $(this); // current input
      var rule = i.attr('data-rule');

      if (rule !== undefined) {
        var ierror = false; // error flag for current input
        var pos = rule.indexOf(':', 0);
        if (pos >= 0) {
          var exp = rule.substr(pos + 1, rule.length);
          rule = rule.substr(0, pos);
        } else {
          rule = rule.substr(pos + 1, rule.length);
        }

        switch (rule) {
          case 'required':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'minlen':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;
        }
        i.next('.validation').html((ierror ? (i.attr('data-msg') != undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    if (ferror) return false;
    else var str = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "contactform",
      data: str,
      headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
      success: function(msg) {
        // alert(msg);
        if (msg == 'OK') {
          $("#sendmessage").addClass("show");
          $("#errormessage").removeClass("show");
          $('.contactForm').find("input, textarea").val("");
        } else {
          $("#sendmessage").removeClass("show");
          $("#errormessage").addClass("show");
          $('#errormessage').html(msg);
        }

      }
    });
    return false;
  });

});

  </script>

</body>



<!-- Scripts -->
<script src="{{ asset('js/app.min.js') }}"></script>
<script>
    $(document).ready(function () {

        $('.lang').on('click', function(){

            localStorage.language = $(this).data('lang');
        });

        if (typeof(Storage) !== "undefined") {
            if (localStorage.language) {
                $('#myModal').modal('hide');
            } else {
                $('#myModal').modal('show');
            }
        } else {
            alert('storage does not work on this browser');
        }
    });

</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/5e270f05daaca76c6fcf2270/default';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Select a Language</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    @foreach (Config::get('languages') as $lang => $language)
                            <div class="col-md-3 text-center">
                                {!! link_to_route('lang.switch', $language, $lang, ['class' => 'lang', 'data-lang' => $lang]) !!}
                            </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>

</html>