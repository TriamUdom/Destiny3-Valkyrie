<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <link rel="stylesheet" href="/assets/css/destinyui3.css" />
        @yield('additional_styles')
    </head>
    <body>

        @include('components.navbar')

        <div class="container mainContainer">
            @yield('content')
            <div id="plsWaitModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-body">
                    <i class="fa fa-spinner fa-spin"></i> กรุณารอสักครู่
                  </div>
                </div>
              </div>
            </div>

        </div>

        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/js/destinyui3.js"></script>
        <script src="/assets/js/jsCheckers.js"></script>
        <script src="/assets/js/bootbox.min.js"></script>
        <script src="/assets/js/pace.min.js"></script>
        <script>
          var csrfToken = "<?php echo csrf_token(); ?>";
          $('#plsWaitModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
          });

          $(function(){
              $(':checkbox').radiocheck();
              $("select").select2({dropdownCssClass: 'dropdown-inverse'});
          })

          function notify(message, severity){
              $("#formAlertMessage").html(message);
              $("#formAlertMessage").removeClass();
              $("#formAlertMessage").addClass('text-' + severity);
              $("#formAlertMessage").fadeIn(300);
          }

          function clearNotifications(){
              $("#formAlertMessage").fadeOut(300);
          }

        </script>
        @yield('additional_scripts')
    </body>
</html>
