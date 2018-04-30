
<nav class="navbar navbar-expand-lg navbar-light bg-light main-header">

  <a class="navbar-brand branded" href="#">
    <img src="{{ asset('images/logos/company.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

    <ul class="navbar-nav justify-content-end">

      <li class="nav-item">
        <a class="nav-link special-button" href="#">Login</a>
      </li>

      <li class="nav-item">
        <a class="nav-link special-button" href="#">Register</a>
      </li>

      <li class="nav-item">
        <a class="nav-link basket" href="/cart"><i class="cart arrow down green icon"></i><span class="badge badge-danger">{{CartUtil::getCartCount()}}</span></a>
      </li>

    </ul>

  </div>

</nav>
