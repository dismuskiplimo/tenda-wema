<!-- Top Navigation -->
<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <!-- Toggle icon for mobile view --><a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
        <div class="top-left-part">
            <a class="logo" href="{{ route('admin.dashboard') }}">
                <b>
                    <img src="{{ simba_coin() }}" class = "size-30" alt="home" />
                </b>

                <span class="hidden-xs">{{ config('app.name') }}</span>
            </a>
        </div>

        <!-- /Logo -->
        <!-- Search input and Toggle icon -->

        <ul class="nav navbar-top-links navbar-left hidden-xs">
            <li>
                <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light">
                    <i class="icon-arrow-left-circle ti-menu"></i>
                </a>
            </li>

            <li>
                <form role="search" class="app-search hidden-xs" action="{{ route('admin.search') }}" method="GET">
                    <input type="text" name = "q" placeholder="Search..." class="form-control"> 
                    <a href="">
                        <i class="fa fa-search"></i>
                    </a> 
                </form>
            </li>
        </ul>

        <ul class="nav navbar-top-links navbar-right pull-right">
            <li class="dropdown"> 
                <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" aria-expanded="false"><i class="icon-envelope"></i>
                    @if(\App\Message::where('support', 1)->where('from_admin', 0)->where('read', 0)->count())
                         <div class="notify">
                            <span class="heartbit"></span>
                            <span class="point"></span>
                        </div>     
                    @endif
                </a>
        <ul class="dropdown-menu mailbox animated bounceInDown">
            <li>
                <div class="drop-title">You have <span class="admin-message-count">{{ \App\Message::where('support', 1)->where('from_admin', 0)->where('read', 0)->count() }}</span> new messages</div>
            </li>

            <li>
                <div class="message-center">
                    @php
                        $nav_conversations = \App\Conversation::where('support',1)->orWhere('from_admin',1)->orderBy('updated_at', 'DESC')->limit(5)->get();
                    @endphp
                    
                    @foreach($nav_conversations as $nav_conversation)
                        @php
                            if($nav_conversation->from_admin){
                                $nav_recepient = $nav_conversation->to;
                            }else{
                                $nav_recepient = $nav_conversation->from;
                            }

                            $last_message = $nav_conversation->last_message;

                            if(!$last_message){
                                $msg = 'No Message';
                            }else{
                                $msg = $last_message->message;
                            }

                        @endphp

                        <div class="nav-messages">
                            <a href="{{ route('admin.message.view', ['id' => $nav_conversation->id]) }}">
                                <div class="user-img"> <img src="{{ $nav_recepient->thumbnail() }}" alt="user" class="img-circle"> <span class="profile-status pull-right"></span> </div>
                                <div class="mail-contnet">
                                    <h5>{{ $nav_recepient->name }}</h5> <span class="mail-desc">{{ characters($msg, '50') }}</span> <span class="time">{{ $nav_conversation->updated_at->diffForHumans() }}</span> </div>
                            </a>    
                        </div>
                        
                    @endforeach
                    
                </div>
            </li>
            <li>
                <a class="text-center" href="{{ route('admin.messages', ['type' => 'all']) }}"> <strong>See all messages</strong> <i class="fa fa-angle-right"></i> </a>
            </li>
        </ul>
        <!-- /.dropdown-messages -->
    </li>
    
    <!-- /.dropdown -->
    <li class="dropdown"> 
        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="fa fa-globe"></i>
            @if(\App\Notification::where('to_id', 1)->where('read', 0)->count())

                <div class="notify">
                    <span class="heartbit"></span>
                    <span class="point"></span>
                </div>

            @endif
        </a>
        
        

        <ul class="dropdown-menu dropdown-tasks animated slideInUp">
            <li>
                <div class="drop-title">You have <span class="admin-notification-count">{{ \App\Notification::where('to_id', 1)->where('read', 0)->count() }}</span> new notifications</div>
            </li>


            <li>
                @if(\App\Notification::where('to_id', 1)->where('read', 0)->count())
                    @foreach(\App\Notification::where('to_id', 1)->where('read', 0)->orderBy('created_at', 'DESC')->limit(5)->get() as $noti)
                        <a href="#">
                            <div>
                                <p>{{ $notification->message }} <br> <span class="text-right text-muted">{{ simple_datetime($notification->created_at) }}</span></p>


                            </div>
                        </a>
                    @endforeach
                @endif

                
            </li>
           
            <li class="divider"></li>
            <li>
                <a class="text-center" href="{{ route('admin.notifications') }}"> <strong>See All Notifications</strong> <i class="fa fa-angle-right"></i> </a>
            </li>
        </ul>
        <!-- /.dropdown-tasks -->
    </li>
    <!-- /.dropdown -->
    
</ul>
        
    </div>
</nav>
<!-- End Top Navigation -->