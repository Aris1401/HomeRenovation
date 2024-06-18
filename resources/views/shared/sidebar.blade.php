<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" width="168" height="56"
            src="{{ asset('images/logo/logo-renovation-removebg-preview.png') }}" alt="Home Renovation Logo">
        {{-- <svg class="sidebar-brand-full" width="118" height="46" alt="Home Renovation Logo">
            <use xlink:href="{{ asset('assets/brand/logo-renovation.svg') }}"></use>
        </svg> --}}

        <img class="sidebar-brand-narrow" width="46" height="46"
            src="{{ asset('images/logo/logo-renovation-removebg-preview.png') }}" alt="Home Renovation Logo">
        {{-- <svg class="sidebar-brand-narrow" width="46" height="46" alt="Home Renovation Logo">
            <use xlink:href="{{ asset('assets/brand/logo-renovation.svg') }}"></use>
        </svg> --}}
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        {{-- Admin --}}
        @if (Auth::user()->hasRole('BTP'))
            <li class="nav-item"><a class="nav-link" href="{{ route('realisations.admin') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Devis clients</a></li>
        @endif

        {{-- Client --}}
        <li class="nav-title">Realisations</li>
        <li class="nav-item"><a class="nav-link" href="{{ route('realiser') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                </svg> Realiser</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('realisaiton') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                </svg> Mes realisations</a></li>


        @if (Auth::user()->hasRole('BTP'))
            <li class="nav-title">Donnees</li>
            <li class="nav-item"><a class="nav-link" href="{{ route('devis.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Liste des devis</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('unites.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Unite</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('type-maison.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Type de maison</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('type-de-finition.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                        </svg> Type de finitions</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('details-devis.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Details devis</a></li>
            
            <li class="nav-title">Importations</li>
            <li class="nav-item"><a class="nav-link" href="{{ route('import.maison-travaux') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Importer maison travaux</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('import.paiement') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Importer paiements</a></li>

            <li class="nav-title">Reinitialisation</li>
            <li class="nav-item"><a class="nav-link" href="{{ route('reset-index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Reinitialiser les donnees</a></li>
        @endif
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
