<section class="sidebar">
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header dark-bg">
            {{__('site')}}
        </li>
        <li>
            <a href="{{ route('shop') }}" target="_blank">
                <i class="fa fa-share-square">
                </i>
                <span>
                    {{__('goToSite')}}
                </span>
            </a>
        </li>






                <li class="treeview">
		            <a href="#">
		                <i class="fa fa-photo">
		                </i>
		                <span>
		                    {{__('appearanceSite')}}
		                </span>
		                <span class="pull-right-container">
		                    <i class="fa fa-angle-left pull-right">
		                    </i>
		                </span>
		            </a>
		            <ul class="treeview-menu ">
				        <li>
				            <a href="{{ route('admin.site.parameters.index') }}">
				                <i class="fa fa-cog">
				                </i>
				                <span>
				                    {{__('siteParameters')}}
				                </span>
				            </a>
				        </li>

		    	        <li>
				            <a class="nav-link"  href="{{ route('admin.shop.sliders.index') }}">
				                <i class="fa fa-sliders">
				                </i>
				                <span>
				                    {{__('shopSliders')}}
				                </span>
				            </a>
				        </li>

						<li>
						    <a href="{{ route('admin.pages.index') }}">
						        <i class="fa fa-file">
						        </i>
						        <span>
						            {{__('staticPages')}}
						        </span>
						    </a>
						</li>
		            </ul>
		        </li>


						<li>
						    <a href="{{ route('admin.shop.reviews.index') }}">
						        <i class="fa fa-quote-left">
						        </i>
						        <span>
						            {{__('reviews')}}
						        </span>
						    </a>
						</li>
						<li>
						    <a href="{{ route('admin.shop.carts.index') }}">
						        <i class="fa fa-shopping-cart">
						        </i>
						        <span>
						            {{__('cart')}}
						        </span>
						    </a>
						</li>



        <li class="treeview">
            <a href="#">
                <i class="fa fa-gift">
                </i>
                <span>
                    {{__('products')}}
                </span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right">
                    </i>
                </span>
            </a>
            <ul class="treeview-menu ">
                <li class="active">
                    <a class="nav-link" href="{{ route('admin.shop.categories.show') }}">
                        <i class="fa fa-angle-right">
                        </i>
                        {{__('categories')}}
                    </a>
                </li>
                <li class="active">
                    <a class="nav-link" href="{{ route('admin.shop.parameters.index') }}">
                        <i class="fa fa-angle-right">
                        </i>
                        {{__('shopParameters')}}
                    </a>
                </li>
            </ul>
        </li>
<li class="header dark-bg">
    {{__('systemAccess')}}
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-user">
        </i>
        <span>
            {{__('users')}}
        </span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right">
            </i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a class="nav-link" href="{{ route('admin.profiles.index') }}">
                <i class="fa fa-angle-right">
                </i>
                {{__('allUsers')}}
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('admin.roles.index') }}">
                <i class="fa fa-angle-right">
                </i>
                {{__('roles')}}
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                <i class="fa fa-angle-right">
                </i>
                {{__('permissions')}}
            </a>
        </li>
    </ul>
</li>
    </ul>
</section>


    {{--
    <li class="header dark-bg">
        Работа с клиентами
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users">
            </i>
            <span>
                {{__('Клиенты')}}
            </span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right">
                </i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Физ лица
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Организации
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('admin.profile.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Поставщики
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-money">
            </i>
            <span>
                {{__('Акты')}}
            </span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right">
                </i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Неоплаченные
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Не оформленные
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-text-o">
            </i>
            <span>
                {{__('Контракты')}}
            </span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right">
                </i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Оплаченные
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Не оплаченные
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-newspaper-o">
            </i>
            <span>
                {{__('Шаблоны')}}
            </span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right">
                </i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Неактивные
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <i class="fa fa-angle-right">
                    </i>
                    Активные
                </a>
            </li>
        </ul>
    </li>
    --}}
</li>
<!-- sidebar-menu -->
