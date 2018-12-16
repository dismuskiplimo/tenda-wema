

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="{{ custom_asset('js/jquery-2.1.4.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/user/plugins.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/user/jquery.fancybox.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/user/bootstrap-datepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/user/remodal.min.js') }}"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="{{ custom_asset('js/user/functions.js') }}"></script>
	<script type="text/javascript" src="{{ custom_asset('js/tenda-wema.js') }}"></script>

	<script type="text/javascript" src="{{ custom_asset('js/tenda-wema.js') }}"></script>
	@if(auth()->check())
		<input type="hidden" id="message_count_url" value="{{ route('messages.count') }}">
		<input type="hidden" id="notification_count_url" value="{{ route('notifications.count') }}">
		<input type="hidden" id="all_count_url" value="{{ route('all.count') }}">

		<script type="text/javascript" src="{{ custom_asset('js/chat.js') }}"></script>
	@endif

</body>
</html>