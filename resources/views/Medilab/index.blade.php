<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{trans('app.name')}}</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

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
                <li class=""><a href="#service">Funkcje</a></li>
                <li class=""><a href="#testimonial">Dlaczego MediCal?</a></li>
                <li class=""><a href="#pricing">Cennik</a></li>
                <li class=""><a href="#contact">Kontakt</a></li>
                <li class=""><a href="login">Logowanie</a></li>
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
              <h1 class="white">Kalendarz i dokumentacja medyczna</h1>
              <p>Wszystko czego potrzebujesz w jednym prostym programie dla każdego lekarza</p>
              <a href="register" class="btn btn-appoint">Przetestuj za darmo</a>
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
  <!--service-->
  <section id="service" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4">
          <h2 class="ser-title">Funkcje programu</h2>
          <hr class="botm-line">
          <p>Kalendarz i dokumentacja medyczna</p>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <div class="icon-info">
              <h4>Baza pacjentów</h4>
              <p>Katalog pacjentów, dane kontaktowe, wyszukiwarka</p>
            </div>
          </div>
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-file"></i>
            </div>
            <div class="icon-info">
              <h4>Pliki</h4>
              <p>Załączanie i przechowywanie dowolnych plików.</p>
            </div>
          </div>
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="icon-info">
              <h4>Kalendarz spotkań</h4>
              <p>Kalendarz wizyt, </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <div class="icon-info">
              <h4>Dokumentacja medyczna</h4>
              <p>Dokumentacja medyczna, zgody, zdjęcia</p>
            </div>
          </div>
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-table"></i>
            </div>
            <div class="icon-info">
              <h4>własne szablony opisów</h4>
              <p>własne szablony opisów</p>
            </div>
          </div>
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-phone"></i>
            </div>
            <div class="icon-info">
              <h4>Powiadomienia sms oraz e-mail</h4>
              <p>Powiadomienia o rezerwacjach, przypomnienia umówionych spotkań.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ service-->
  
  <!--testimonial-->
  <section id="testimonial" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="ser-title">Jakie problemy rozwiąże za Ciebie nasz program?</h2>
          <hr class="botm-line">
        </div>
        <div class="col-md-4">
          <div class="testi-details">
            <!-- Paragraph -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js" integrity="sha256-CfcERD4Ov4+lKbWbYqXD6aFM9M51gN4GUEtDhkWABMo=" crossorigin="anonymous"></script>            
<b style="font-size: 20px;">Powiadomienia</b><hr>
<canvas id="myChart" width="300" height="300"></canvas>
<b style="font-size: 40px;">40%</b>
<hr class="botm-line">
rezerwacji nie dochodzi do skutku z powodu przegapienia terminu
<hr class="botm-line">
forma przypominającego sms-a to najprostszy sposob na wyeliminowanie takich zdarzeń

<script>
data = {
    datasets: [{
        data: [40, 60],
        backgroundColor: [
            '#ff6384',
            '#36a2eb',
            '#cc65fe',
            '#ffce56',
        ],        
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'strata',
        'klienci',
    ],
    
};
var options = {
        title: {
            display: true,
            text: 'Straty z powodu braku powiadomień'
        }
    };
var ctx = document.getElementById("myChart").getContext('2d');
// For a pie chart
var myPieChart = new Chart(ctx,{
    type: 'pie',
    data: data,
    options: options
});
/*
// And for a doughnut chart
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
*/
</script>            
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ testimonial-->
  
  <!--cta 2-->
  <section id="cta-2" class="section-padding">
    <div class="container">
      <div class=" row">
        <div class="col-md-2"></div>
        <div class="text-right-md col-md-4 col-sm-4">
          <h2 class="section-title white lg-line">« kilka słów<br> o nas »</h2>
        </div>
        <div class="col-md-4 col-sm-5">
           Program przygotowaliśmy wspólnie z lekarzami którzy  
          <p class="text-right text-primary"><i>— MediCal Healthcare</i></p>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
  </section>
  <!--cta-->
  
  
  
  <!--==========================
      Pricing Section
    ============================-->
    <section id="pricing" class="section-padding">
      <div class="container">

        <div class="section-header">
          <h3 class="ser-title">Cennik</h3>
          <span class="section-divider"></span>
          <p class="section-description">Nasza propozycja dla Ciebie</p>
        </div>

        <div class="row">

          <div class="col-lg-6 col-md-6">
            <div class="box wow fadeInLeft">
              <h3>Free</h3>
              <h4><sup>$</sup>0<span> miesiąc</span></h4>
              <ul>
                <li><i class="fa fa-check"></i> Baza pacjentów</li>
                <li><i class="fa fa-check"></i> Baza lekarzy</li>
                <li><i class="fa fa-check"></i> Usługi</li>
                <li><i class="fa fa-check"></i> Kalendarz</li>
                <li><i class="fa fa-check"></i> Historia wizyt</li>
                <li><i class="fa fa-check"></i> Dokumentacja medyczna</li>
                <li><i class="fa fa-check"></i> Pliki</li>
                <li><i class="fa fa-check"></i> Reklamy</li>
              </ul>
              <a href="register" class="get-started-btn">Na start</a>
            </div>
          </div>

          <div class="col-lg-6 col-md-6">
            <div class="box featured wow fadeInUp">
              <h3>Business</h3>
              <h4><sup>$</sup>15<span> miesiąc</span></h4>
              <ul>
                <li><i class="fa fa-check"></i> Baza pacjentów</li>
                <li><i class="fa fa-check"></i> Baza lekarzy</li>
                <li><i class="fa fa-check"></i> Usługi</li>
                <li><i class="fa fa-check"></i> Kalendarz</li>
                <li><i class="fa fa-check"></i> Historia wizyt</li>
                <li><i class="fa fa-check"></i> Dokumentacja medyczna</li>
                <li><i class="fa fa-check"></i> Pliki</li>
                <li><i class="fa fa-check"></i> Brak reklam</li>
                
              </ul>
              <a href="register" class="get-started-btn">Rejestracja</a>
            </div>
          </div>


        </div>
      </div>
    </section><!-- #pricing -->
  
  
  <!--contact-->
  <section id="contact" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="ser-title">Kontakt z nami</h2>
          <hr class="botm-line">
        </div>
        <div class="col-md-4 col-sm-4">
          <h3>Kontat</h3>
          <div class="space"></div>
          <p><i class="fa fa-map-marker fa-fw pull-left fa-2x"></i>Al. Zjednoczenia 3/9<br> Warszawa</p>
          <div class="space"></div>
          <p><i class="fa fa-envelope-o fa-fw pull-left fa-2x"></i>info@medical.net</p>
          <div class="space"></div>
          <p><i class="fa fa-phone fa-fw pull-left fa-2x"></i>+48 532 882 592</p>
        </div>
        <div class="col-md-8 col-sm-8 marb20">
          <div class="contact-info">
            <h3 class="cnt-ttl">Napisz do nas jeśli masz jakieś pytania</h3>
            <div class="space"></div>
            <div id="sendmessage">Twoja wiadomość została wysłana. Dziękujęmy!</div>
            <div id="errormessage"></div>
            <form action="" method="post" role="form" class="contactForm">
              <div class="form-group">
                <input type="text" name="name" class="form-control br-radius-zero" id="name" placeholder="Twoje imię" data-rule="minlen:4" data-msg="Minimum 4 znaki" />
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <input type="email" class="form-control br-radius-zero" name="email" id="email" placeholder="Twój e-mail" data-rule="email" data-msg="Wpisz poprawny adres e-mail" />
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control br-radius-zero" name="subject" id="subject" placeholder="Temat" data-rule="minlen:4" data-msg="Minimum 4 znaki" />
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control br-radius-zero" name="message" rows="5" data-rule="required" data-msg="Prosze napisać coś do nas ;-)" placeholder="Wiadomość"></textarea>
                <div class="validation"></div>
              </div>

              <div class="form-action">
                <button type="submit" class="btn btn-form">Wyślij wiadomość</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ contact-->
  <!--footer-->
  <footer id="footer">
    <div class="top-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 marb20">
            <div class="ftr-tle">
              <h4 class="white no-padding">MediCal</h4>
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
            © Copyright MediCal. All Rights Reserved
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