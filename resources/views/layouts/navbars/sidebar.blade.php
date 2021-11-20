<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="https://www.creative-tim.com" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('images/icono.png') }}">
            </div>
            <!-- <p>CT</p> -->
        </a>
        <a href="https://www.creative-tim.com" class="simple-text logo-normal">
            COSTS
            <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li id="dashboard">
                <a href="{{ route('home') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if (auth()->user()->rol_id == 1)
            <li id="categories">
                <a href="{{ route('categories') }}">
                    <i class="nc-icon nc-tag-content"></i>
                    <p>Categorías</p>
                </a>
            </li>
            @endif
            @if (auth()->user()->rol_id == 1)
            <li id="products">
                <a href="{{ route('products') }}">
                    <i class="nc-icon nc-box-2"></i>
                    <p>Productos</p>
                </a>
            </li>
            @endif
            
            <li id="vents">
                <a href="{{ route('ventas') }}">
                    <i class="nc-icon nc-money-coins"></i>
                    <p>Ventas</p>
                </a>
            </li>
            @if (auth()->user()->rol_id == 1)
            <li id="users">
                <a href="/users">
                    <i class="nc-icon nc-badge"></i>
                    <p>Usuarios</p>
                </a>
            </li>
            {{-- <li id="repors">
                <a href="{{ route('reports') }}">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>Reportes</p>
                </a>
            </li> --}}
            @endif
            
        </ul>
    </div>
</div>