<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
  <div class="leftside-menu">

    <div class="h-100" id="leftside-menu-container" data-simplebar>

      <!--- Sidemenu -->
      <ul class="side-nav">

        <li class="side-nav-title side-nav-item">Navigation</li>

        <li class="side-nav-item">
          <a  class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span class="badge bg-success float-end">4</span>
            <span> Dashboards </span>
          </a>
        </li>

        <li class="side-nav-title side-nav-item">Catalogue</li>

        <li class="side-nav-item">
          <a href="{{route('index.admin.product')}}" class="side-nav-link">
            <i class="uil-calender"></i>
            <span> Produit </span>
          </a>
        </li>

        <li class="side-nav-item">
          <a href="{{route('index.admin.categories')}}" class="side-nav-link">
            <i class="uil-comments-alt"></i>
            <span> Categories </span>
          </a>
        </li>

        <li class="side-nav-item">
          <a href="{{route('index.product.attribute')}}" class="side-nav-link">
            <i class="uil-comments-alt"></i>
            <span> Attributes et caractéristiques </span>
          </a>
        </li>

        <li class="side-nav-item">
          <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
            <i class="uil-store"></i>
            <span> Ecommerce </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarEcommerce">
            <ul class="side-nav-second-level">
              <li>
                <a href="apps-ecommerce-products.html">Products</a>
              </li>
              <li>
                <a href="apps-ecommerce-products-details.html">Products Details</a>
              </li>
              <li>
                <a href="apps-ecommerce-orders.html">Orders</a>
              </li>
              <li>
                <a href="apps-ecommerce-orders-details.html">Order Details</a>
              </li>
              <li>
                <a href="apps-ecommerce-customers.html">Customers</a>
              </li>
              <li>
                <a href="apps-ecommerce-shopping-cart.html">Shopping Cart</a>
              </li>
              <li>
                <a href="apps-ecommerce-checkout.html">Checkout</a>
              </li>
              <li>
                <a href="apps-ecommerce-sellers.html">Sellers</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>

      <!-- End Sidebar -->

      <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

  </div>
  <!-- Left Sidebar End -->
</div>
