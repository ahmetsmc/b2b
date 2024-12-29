</div>
</div>


<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script>
                © Velzon.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>


<!-- JAVASCRIPT -->
<script src="{{ asset('assets/dashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/plugins.js') }}"></script>


<!-- Dashboard init -->
<script src="{{ asset('assets/dashboard/js/pages/dashboard-ecommerce.init.js') }}"></script>

<!-- swiper init -->
<script src="{{ asset('assets/dashboard/libs/swiper/swiper.min.js') }}"></script>

<!-- toastify js -->
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<!-- choices -->
<script src="{{ asset('assets/dashboard/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

<!-- editor -->
<script src="{{ asset('assets/dashboard/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

<!-- input masks -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

<!-- fancybox -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<!-- sweetalert -->
<script src="{{ asset('assets/dashboard/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- sortable js-->
<script src="http://SortableJS.github.io/Sortable/Sortable.js"></script>

<!-- App js -->
<script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
<script src="{{ asset('assets/dashboard/generic.js') }}"></script>

@if(session()->has('toast_success'))
    <script>
        $(document).ready(function () {
            notify("success", "{{ session()->get('toast_success') }}");
        });
    </script>
@endif

@if(session()->has('error_success'))
    <script>
        $(document).ready(function () {
            notify("error", "{{ session()->get('error_success') }}");
        });
    </script>
    @endif

    @stack('javascript')

    </body>

    </html>
