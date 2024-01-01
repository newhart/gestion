<!--begin::Head-->
<head>
	<base href="">
	<meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Lyan cosmetics</title>
	<meta name="application-name" content="{{ config('app.name') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description"
		content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="canonical" href="https://keenthemes.com/metronic" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Vendors Styles(used by this page)-->
	<link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<link href="{{asset('assets/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />
<!--end::Layout Themes-->
	<link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
	@filamentStyles
	@vite('resources/css/app.css')
	@livewireStyles
	<style>
        @media print {
            #footer-pdf, footer , .offcanvas-content , #header-header , #top-bar {
                display: none;
            }

            #test {
                padding-left: 0!important ;
                padding-right: 0!important;
            }
            #right {
                float: right;
            }

            #text-ajout {
                display: none;
            }

            #kt_header_mobile {
                display: none;
            }

            #left {
                float: left;
            }
            #container {
                display: block;
            }
        }
        .ms-auto.flex.items-center.gap-x-4,.ms-auto.flex.items-center.gap-x-4 .fi-ta-search-field{
            width:100%
        }
	</style>
	<style>
		[x-cloak] {
			display: none !important;
		}
	</style>
	@yield('style')
</head>
<!--end::Head-->
