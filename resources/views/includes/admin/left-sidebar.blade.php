<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> 
                    
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                    </span> 
                </div>
                <!-- /input-group -->
            </li>
            
            <li class="user-pro">
                <a href="" class="waves-effect">
                    <img src="{{ auth()->user()->thumbnail() }}" alt="user-img" class="img-circle"> 
                    <span class="hide-menu">{{ auth()->user()->fname }}
                        <span class="fa arrow"></span>
                    </span>
                </a>

                <ul class="nav nav-second-level">

                    <li>
                        <a href="{{ route('admin.account.settings') }}">
                            <i class="ti-settings"></i> Account Settings
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('auth.logout') }}"  id = "logout-button">
                            <i class="fa fa-power-off"></i> Logout

                            
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="nav-small-cap m-t-10">-- Main Menu</li>

            <li>
                <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                    <i class="ti-dashboard fa-fw"></i> 
                    <span class="hide-menu">Dashboard</span>
                </a> 
            </li>

            

            <li> 
                <a href="#" class="waves-effect">
                    <i class="fa fa-smile-o fa-fw"></i> 
                    <span class="hide-menu">Good Deeds
                        <span class="fa arrow"></span>
                    </span>
                </a>

                <ul class="nav nav-second-level">
                    

                    
                    <li>
                        <a href="{{ route('admin.deeds', ['type' => 'pending-approval']) }}">Pending Approval
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $active_events_count }} --}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.deeds', ['type' => 'approved']) }}">Approved
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $featured_events_count }} --}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.deeds', ['type' => 'disapproved']) }}">Disapproved
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $closed_events_count }} --}}</span>
                        </a>
                    </li>                    

                    <li>
                        <a href="{{ route('admin.deeds', ['type' => 'all']) }}">All
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $past_events_count }} --}}</span>
                        </a>
                    </li>

                    
                </ul>
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="ti-microphone fa-fw"></i> 
                    <span class="hide-menu">Donated Items
                        <span class="fa arrow"></span>
                    </span>
                </a>

                <ul class="nav nav-second-level">
                                        
                    <li>
                        <a href="{{ route('admin.donated-items', ['type' => 'pending-approval']) }}">Pending Approval
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $active_events_count }} --}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.donated-items', ['type' => 'community-shop']) }}">Community Shop
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $featured_events_count }} --}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.donated-items', ['type' => 'approved']) }}">Approved
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $closed_events_count }} --}}</span>
                        </a>
                    </li>                    

                    <li>
                        <a href="{{ route('admin.donated-items', ['type' => 'delivered']) }}">Delivered
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $closed_events_count }} --}}</span>
                        </a>
                    </li> 

                    <li>
                        <a href="{{ route('admin.donated-items', ['type' => 'disapproved']) }}">Disapproved
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $past_events_count }} --}}</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('admin.donated-items', ['type' => 'disputed']) }}">Disputed
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $past_events_count }} --}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.donated-items', ['type' => 'trashed']) }}">Trashed
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $past_events_count }} --}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.donated-items', ['type' => 'all']) }}">All
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $past_events_count }} --}}</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.order-cancellations', ['type' => 'all']) }}" class="waves-effect">
                    <i class="ti-bag fa-fw"></i> 
                    <span class="hide-menu">Order Cancelations</span>
                </a> 
            </li>

            <li>
                <a href="{{ route('admin.support-causes') }}" class="waves-effect">
                    <i class="ti-bag fa-fw"></i> 
                    <span class="hide-menu">Donation Requests</span>
                </a> 
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="ti-user fa-fw"></i> 
                    <span class="hide-menu">Users
                        <span class="fa arrow"></span>
                    </span>
                </a>
                
                <ul class="nav nav-second-level">
                   

                    <li> 
                        <a href="{{ route('admin.users', ['type' => 'active']) }}">Active 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $active_users }} --}}</span>
                        </a> 
                    </li>

                    <li> 
                        <a href="{{ route('admin.users', ['type' => 'inactive']) }}">Closed Accounts 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $suspended_users }} --}}</span>
                        </a> 

                    </li>

                    <li> 
                        <a href="{{ route('admin.users', ['type' => 'all']) }}">All 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $adm }} --}}</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="ti-user fa-fw"></i> 
                    <span class="hide-menu">Admins
                        <span class="fa arrow"></span>
                    </span>
                </a>
                
                <ul class="nav nav-second-level">
                    
                    <li> 
                        <a href="{{ route('admin.admins', ['type' => 'active']) }}">Active 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $active_users }} --}}</span>
                        </a> 
                    </li>

                    <li> 
                        <a href="{{ route('admin.admins', ['type' => 'inactive']) }}">Closed Accounts 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $suspended_users }} --}}</span>
                        </a> 

                    </li>

                    <li> 
                        <a href="{{ route('admin.admins', ['type' => 'all']) }}">All 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $adm }} --}}</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="ti-money fa-fw"></i> 
                    <span class="hide-menu">Transactions
                        <span class="fa arrow"></span>
                    </span>
                </a>
                
                <ul class="nav nav-second-level">
                    
                    <li> 
                        <a href="{{ route('admin.transactions', ['type' => 'mpesa']) }}">MPESA 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $active_users }} --}}</span>
                        </a> 

                        <a href="{{ route('admin.transactions', ['type' => 'paypal']) }}">Paypal 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $active_users }} --}}</span>
                        </a> 
                    </li>

                    
                    
                </ul>
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="fa fa-building fa-fw"></i> 
                    <span class="hide-menu">Escrow
                        <span class="fa arrow"></span>
                    </span>
                </a>
                
                <ul class="nav nav-second-level">
                   

                    <li> 
                        <a href="{{ route('admin.escrow', ['type' => 'pending']) }}">Pending 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $suspended_users }} --}}</span>
                        </a> 

                    </li>

                    <li> 
                        <a href="{{ route('admin.escrow', ['type' => 'settled']) }}">Settled 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $adm }} --}}</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="fa fa-envelope fa-fw"></i> 
                    <span class="hide-menu">Messages
                        <span class="fa arrow"></span>
                    </span>
                </a>
                
                <ul class="nav nav-second-level">
                   

                    <li> 
                        <a href="{{ route('admin.message.compose') }}">Compose 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $suspended_users }} --}}</span>
                        </a> 

                    </li>

                    <li> 
                        <a href="{{ route('admin.messages', ['type' => 'all']) }}">Conversations 
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $adm }} --}}</span>
                        </a>
                    </li>

                    
                    
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.contact-forms') }}" class="waves-effect">
                    <i class="ti-envelope fa-fw"></i> 
                    <span class="hide-menu">Contact Forms</span>
                </a> 
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="fa fa-bullhorn fa-fw"></i> 
                    <span class="hide-menu">Misconduct Reported
                        <span class="fa arrow"></span>
                    </span>
                </a>

                <ul class="nav nav-second-level">
                    

                    
                    <li>
                        <a href="{{ route('admin.users.reported', ['type' => 'pending']) }}">Pending Approval
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $active_events_count }} --}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.reported', ['type' => 'approved']) }}">Approved
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $featured_events_count }} --}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.reported', ['type' => 'dismissed']) }}">Dismissed
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $closed_events_count }} --}}</span>
                        </a>
                    </li>                    

                    <li>
                        <a href="{{ route('admin.users.reported', ['type' => 'all']) }}">All
                            <span class="label label-rouded label-purple pull-right">{{-- {{ $past_events_count }} --}}</span>
                        </a>
                    </li>

                    
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.site-settings') }}" class="waves-effect">
                    <i class="ti-settings fa-fw"></i> 
                    <span class="hide-menu">Site Settings</span>
                </a> 
            </li>

            <li>
                <a href="{{ route('auth.logout') }}" class="waves-effect">
                    <i class="fa fa-power-off fa-fw"></i> 
                    <span class="hide-menu">Logout</span>
                </a> 
            </li>
        </ul>
    </div>
</div>
<!-- Left navbar-header end -->