<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="{{ __('headings.meta_data') }}">
        <meta name="keywords" content="codewithus,coding,classes, coding classes">
        <meta name="author" content="Themesbox">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('title') </title>
        <!-- Fevicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- Start CSS -->   
        @yield('style')
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
   
        <!-- Intercom livechat -->
		<script>

         var userName = "";
		  window.intercomSettings = {
		    app_id: "sbzhkeux",
            name: this.userName // Full name
		  };
		</script>
		<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/sbzhkeux';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
		<!-- /Intercom livechat -->
		<!-- /mouseflow -->
		<script type="text/javascript">
			var _mfq = _mfq || [];
			(function() {
				var mf = document.createElement("script");
				mf.type = "text/javascript"; mf.async = true;
				mf.src = "//cdn.mouseflow.com/projects/6ae58feb-eb35-4c41-867c-913a3dace62a.js";
				document.getElementsByTagName("head")[0].appendChild(mf);
			})();
		</script>


        <!-- End CSS -->
        <!-- Vue Cal Scripts -->
        <script src="https://unpkg.com/vue"></script>
        <script src="https://unpkg.com/vue-cal"></script>
        <link href="https://unpkg.com/vue-cal/dist/vuecal.css" rel="stylesheet">
        <script src="https://js.stripe.com/v3/"></script>

   <!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '2317008721748422');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=2317008721748422&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
    </head>
    <body class="xp-vertical">
        <!-- Search Modal -->
        <div class="modal search-modal fade" id="xpSearchModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="xp-searchbar">
                            <form>
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit" id="button-addon2">GO</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start XP Container -->
        <div id="xp-container">     
            <!-- Start XP Leftbar -->
            @yield('leftbar')
           
            <!-- End XP Leftbar -->
            <!-- Start XP Rightbar -->
            @include('layouts.rightbar')  
            @yield('content')
            <!-- End XP Rightbar -->  
        </div>
        <!-- End XP Container -->
        <!-- Start JS -->        
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/detect.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script> 
        @yield('script')
        <!-- Main JS -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <!-- End JS -->
    </body>
</html>    