<nav class="main-nav--bg">
    <div class="container-fluid main-nav">
        <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
            <span class="sr-only">Toggle menu</span>
            <span class="icon menu-toggle--gray" aria-hidden="true"></span>
          </button>
        <p class="text-uppercase">hai, {{ auth()->user()->name }}</p>
    </div>
  </nav>
