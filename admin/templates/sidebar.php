<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebarbg">
  <!-- Brand Logo -->
  <a href="dashboard" class="brand-link">
    Penacle Publishing House<span class="brand-text font-weight-light"></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar  sidebarbg">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item smenu">
          <a href="dashboard" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'dashboard' ) ? 'active': ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <!-----order managemnet------------------->

        <li class="nav-item has-treeview <?php echo (isset($active_tab) && trim($active_tab) == 'orders' ) ? 'menu-open': ''; ?>">
          <a href="#" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'orders' ) ? 'active': ''; ?>">
            <i class="nav-icon fas fa-shopping-basket"></i>
            <p>
              Order Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="new-orders" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'new orders' ) ? 'active': ''; ?>">
                <i class="fas fa-cart-plus nav-icon"></i>
                <p>New Orders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pending-orders" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'pending orders' ) ? 'active': ''; ?>">
                <i class="fas fa-cart-arrow-down nav-icon"></i>
                <p>Pending Orders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="delivered-orders" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'delivered orders' ) ? 'active': ''; ?>">
                <i class="fas fa-luggage-cart nav-icon"></i>
                <p>Delivered Orders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="orders" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'orders' ) ? 'active': ''; ?>">
                <i class="fas fa-shopping-cart nav-icon"></i>
                <p>All Orders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="export-orders" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'export orders' ) ? 'active': ''; ?>">
                <i class="fas fa-file-export nav-icon"></i>
                <p>Export Orders</p>
              </a>
            </li>
          </ul>
        </li>
         <!---- end order managemnet------------------->
             
       <!----- books managemnet------------------->
        <li class="nav-item has-treeview <?php echo (isset($active_tab) && trim($active_tab) == 'Books Management' ) ? 'menu-open': ''; ?>">
          <a href="#" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'books' ) ? 'active': ''; ?>">
            <i class="fa fa-book" aria-hidden="true"></i>
            <p>
            Books Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="book-category" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'Books Category' ) ? 'active': ''; ?>">
               <i class="fa fa-book" aria-hidden="true"></i>
                <p>Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="book-sub-category" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'Books' ) ? 'active': ''; ?>">
               <i class="fa fa-book" aria-hidden="true"></i>
                <p>Sub Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="books" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'Books' ) ? 'active': ''; ?>">
               <i class="fa fa-book" aria-hidden="true"></i>
                <p>Books</p>
              </a>
            </li>
            
          </ul>
            
 <!-----end books managemnet------------------->
  <!-----Journals managemnet------------------->
        <li class="nav-item has-treeview <?php echo (isset($active_tab) && trim($active_tab) == 'gallery' ) ? 'menu-open': ''; ?>">
          <a href="#" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'Journal Management' ) ? 'active': ''; ?>">
            <i class="fa fa-book" aria-hidden="true"></i>
              Journal Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="journals" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'Journals' ) ? 'active': ''; ?>">
               <i class="fa fa-book" aria-hidden="true"></i>
                <p>Journals</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="j-category" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'Journal Types' ) ? 'active': ''; ?>">
                <i class="fa fa-book" aria-hidden="true"></i>
                <p>Category</p>
              </a>
            </li>
        <li class="nav-item">
              <a href="j-domain" class="nav-link <?php echo (isset($active_sub_tab) && trim($active_sub_tab) == 'Journal Types' ) ? 'active': ''; ?>">
                <i class="fa fa-book" aria-hidden="true"></i>
                <p>Domain</p>
              </a>
            </li>
          </ul>
        </li>
       
<!----- end Journals managemnet------------------->
<!-----Journals managemnet------------------->

         <li class="nav-item has-treeview <?php echo (isset($active_tab) && trim($active_tab) == 'gallery' ) ? 'menu-open': ''; ?>">
          <a href="chapter" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'Chapter Management' ) ? 'active': ''; ?>">
           <i class="fa fa-list-alt" aria-hidden="true"></i>
            <p>Chapter 
              
            </p>
          </a>
         
        
        </li>
  
        <li class="nav-item">
          <a href="users" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'users' ) ? 'active': ''; ?>">
            <i class="fas fa-users nav-icon"></i>
            <p>
              Users
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="about-us" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'about us' ) ? 'active': ''; ?>">
            <i class="far fa-address-card nav-icon"></i>
            <p>
              About Us
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="privacy-policy" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'privacy policy' ) ? 'active': ''; ?>">
            <i class="fas fa-user-lock nav-icon"></i>
            <p>
              Privacy Policy
            </p>
          </a>
        </li>
   
   <li class="nav-item">
          <a href="terms-and-conditions" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'terms and conditions' ) ? 'active': ''; ?>">
            <i class="fas fa-gavel nav-icon"></i>
            <p>
              Terms & Condition
            </p>
          </a>
        </li>
  
      
        <li class="nav-item">
          <a href="offer-and-discounts" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'special offers' ) ? 'active': ''; ?>">
            <i class="fas fa-percent nav-icon"></i>
            <p>
              Offers & Discounts
            </p>
          </a>
        </li>
      
        <li class="nav-item">
          <a href="contact-request" class="nav-link <?php echo (isset($active_tab) && trim($active_tab) == 'contact request' ) ? 'active': ''; ?>">
            <i class="fas fa-phone-volume nav-icon"></i>
            <p>
              Contact Request
            </p>
          </a>
        </li>
  
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<div class="content-wrapper">