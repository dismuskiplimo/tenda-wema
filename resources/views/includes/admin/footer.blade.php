                @include('includes.admin.right-sidebar')

            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> {{ date('Y') }} &copy; {{ config('app.name') }} </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ custom_asset('js/admin/tether.min.js') }}"></script>
    <script src="{{ custom_asset('js/admin/bootstrap.min.js') }}"></script>
    <script src="{{ custom_asset('js/admin/bootstrap-extension.min.js') }}"></script>
    <!-- Sidebar menu plugin JavaScript -->
    <script src="{{ custom_asset('js/admin/sidebar-nav.min.js') }}"></script>
    <!--Slimscroll JavaScript For custom scroll-->
    <script src="{{ custom_asset('js/admin/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ custom_asset('js/admin/waves.js') }}"></script>
    <script src="{{ custom_asset('js/admin-chat.js') }}"></script>
    <script src="{{ custom_asset('js/user/moment.js') }}"></script>
    <script src="{{ custom_asset('js/user/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ custom_asset('js/user/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript" src="{{ custom_asset('js/user/jquery.fancybox.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ custom_asset('js/admin/custom.min.js') }}"></script>
    <script src="{{ custom_asset('js/admin/custom.js') }}"></script>
    <script src="{{ custom_asset('js/tenda-wema.js') }}"></script>
</body>

</html>