<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>@yield("title")</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="/css/all.min.css" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand logo col-md-3 col-lg-2 me-0 px-3" href="#">Ship Admin</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">

          @if(auth("admin")->user()->type == "company")
            <li class="nav-item">
              <a class="nav-link  {{ acitveLink('_company/drivers') }} " aria-current="page" href="/_company/drivers">
                <span><i class="fas fa-users"></i></span>
                Drivers
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_company/addDriver')}}" href="/_company/addDriver"><i class="fas fa-user-plus"></i> Add Driver</a></li>
                <li><a class="{{acitveLink('_company/activedDrivers')}}" href="/_company/activedDrivers"><i class="fas fa-eye"></i></i> Actived Drivers</a></li>
                <li><a class="{{acitveLink('_company/inActivedDrivers')}}" href="/_company/inActivedDrivers"><i class="fas fa-eye-slash"></i> Inactived Drivers</a></li>
              </ul>
            </li>
          @endif

          @if(auth("admin")->user()->type == "admin")

            <li class="nav-item">
              <a class="nav-link  {{ acitveLink('_admin/statistics') }} " aria-current="page" href="/_admin/statistics">
                <span><i class="fas fa-chart-bar"></i></span>
                Statistics
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link  {{ acitveLink('_admin/drivers') }} " aria-current="page" href="/_admin/drivers">
                <span><i class="fas fa-users"></i></span>
                Drivers
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/addDriver')}}" href="/_admin/addDriver"><i class="fas fa-user-plus"></i> Add Driver</a></li>
                <li><a class="{{acitveLink('_admin/activedDrivers')}}" href="/_admin/activedDrivers"><i class="fas fa-eye"></i></i> Actived Drivers</a></li>
                <li><a class="{{acitveLink('_admin/inActivedDrivers')}}" href="/_admin/inActivedDrivers"><i class="fas fa-eye-slash"></i> Inactived Drivers</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link  {{ acitveLink('_admin/users') }} " aria-current="page" href="/_admin/users">
                <span><i class="fas fa-users"></i></span>
                Users
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/activedUsers')}}" href="/_admin/activedUsers"><i class="fas fa-eye"></i></i> Actived Users</a></li>
                <li><a class="{{acitveLink('_admin/inActivedUsers')}}" href="/_admin/inActivedUsers"><i class="fas fa-eye-slash"></i> Inactived Users</a></li>
              </ul>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link  {{ acitveLink('_admin/goodsTypes') }} " aria-current="page" href="/_admin/goodsTypes">
                <span><i class="fas fa-truck-loading"></i></span>
                Goods Types
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/addGoodType')}}" href="/_admin/addGoodType"><i class="fas fa-plus-square"></i> Add Good Type</a></li>
              </ul>
            </li>-->

            <li class="nav-item">
              <a class="nav-link  {{ acitveLink('_admin/truckTypes') }} " aria-current="page" href="/_admin/truckTypes">
                <span><i class="fas fa-truck-moving"></i></span>
                Trucks Types
              </a>
               <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/addTruckType')}}" href="/_admin/addTruckType"><i class="fas fa-plus-square"></i> Add Truck Type</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/orders')}} " href="/_admin/orders">
                <span><i class="fas fa-shopping-cart"></i></span>
                Orders 
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/billsPayRequests')}} " href="/_admin/billsPayRequests">
                <span><i class="fas fa-money-check-alt"></i></span>
                Bills Pay Requests 
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/priceList')}} " href="/_admin/priceList">
                <span><i class="fas fa-money-bill-wave"></i></span>
                Price List   
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/addPrice')}}" href="/_admin/addPrice"><i class="fas fa-plus-square"></i> Add Price</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/contacts')}} " href="/_admin/contacts">
                <span><i class="fas fa-envelope"></i></span>
                New Contacts   
              </a>
              <ul class="sublist-slide-bar">
                

                <li><a class="{{acitveLink('_admin/usersContacts')}}" href="/_admin/usersContacts"><i class="fas fa-user-tag"></i> Users Contacts</a></li>

                <li><a class="{{acitveLink('_admin/driversContacts')}}" href="/_admin/driversContacts"><i class="fas fa-user-tag"></i> Drivers Contacts</a></li>

                <li><a class="{{acitveLink('_admin/guestsContacts')}}" href="/_admin/guestsContacts"><i class="fas fa-question-circle"></i> Guests Contacts</a></li>

                <li><a class="{{acitveLink('_admin/closedContacts')}}" href="/_admin/closedContacts"><i class="fas fa-envelope-open"></i> Closed Contacts</a></li>

              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/contactTypes')}} " href="/_admin/contactTypes">
                <span><i class="fas fa-file-contract"></i></span>
                Contact Types   
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/addContactType')}}" href="/_admin/addContactType"><i class="fas fa-plus-square"></i> Add Contact Type</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/phones')}} " href="/_admin/phones">
                <span><i class="fas fa-phone-square-alt"></i></span>
                Phones  
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/addPhone')}}" href="/_admin/addPhone"><i class="fas fa-plus-square"></i> Add Phone</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/emails')}} " href="/_admin/emails">
                <span><i class="fas fa-at"></i></span>
                Emails   
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/addEmail')}}" href="/_admin/addEmail"><i class="fas fa-plus-square"></i> Add Email</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/discountCodes')}} " href="/_admin/discountCodes">
                <span><i class="fas fa-percent"></i></span>
                Discount Codes   
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/addDiscountCode')}}" href="/_admin/addDiscountCode"><i class="fas fa-plus-square"></i> Add Discount Code</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link {{acitveLink('_admin/admins')}} " href="/_admin/admins">
                <span><i class="fas fa-users-cog"></i></span>
                Admins   
              </a>
              <ul class="sublist-slide-bar">
                <li><a class="{{acitveLink('_admin/companies')}}" href="/_admin/companies"><i class="fas fa-users-cog"></i> Companies</a></li>
                <li><a class="{{acitveLink('_admin/addAdmin')}}" href="/_admin/addAdmin"><i class="fas fa-user-plus"></i> Add Admin</a></li>
              </ul>
            </li>
          @endif
          
          @if(auth("admin")->user()->type == "company")
            <li class="nav-item">
                <a class="nav-link" href="/_company/logout"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    Logout <i class="fas fa-sign-out-alt"></i>
                </a>
              <form id="logout-form" action="/_company/logout" method="POST" class="d-none">
                  @csrf
              </form>
            </li>
          @else
            <li class="nav-item">
                <a class="nav-link" href="/_admin/logout"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    Logout <i class="fas fa-sign-out-alt"></i>
                </a>
              <form id="logout-form" action="/_admin/logout" method="POST" class="d-none">
                  @csrf
              </form>
            </li>
          @endif
          
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="dashboard-content">
        @yield("page_content")
      </div>
    </main>
  </div>
</div>


      <script src="/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="/js/jquery-3.5.1.min.js" ></script>
      <script type="text/javascript" src="/js/all.min.js" ></script>
      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
      <script src="/js/script.js"></script>
      <script src="/js/dashboard.js"></script>
      @stack('scripts') 
  </body>
</html>
