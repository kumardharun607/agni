<aside
    id="sidebar"
    class="fixed lg:static inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-all duration-300">

    <!-- Logo -->
    <div class="h-16 border-b border-gray-200 flex items-center justify-between px-6">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/agni-logo.png') }}" alt="AGNI" class="w-11 h-11 rounded-full object-cover">
            <div>
                <h2 class="text-lg font-bold text-red-700">AGNI</h2>
                <p class="text-xs text-gray-500">Dealer Management</p>
            </div>
        </div>
        <button id="closeSidebar" class="lg:hidden text-xl">&times;</button>
    </div>

    <!-- Menu -->
    <div class="flex flex-col justify-between h-[calc(100vh-64px)] overflow-y-auto sidebar-scroll">
        <div>
            <ul class="py-2">

                <!-- Dashboard -->
                <li class="px-2 mb-1">
                    <a href="{{ route('dashboard') }}" data-load="ajax"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                        {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                        <i class="fa-solid fa-house w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Masters -->
                @userCan('Countries','view') @php($showMasters = true) @enduserCan
                <li class="px-2">
                    <button id="masterMenu" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-folder-tree w-5 text-center"></i>
                            <span>Masters</span>
                        </div>
                        <i id="masterArrow" class="fa-solid fa-chevron-down text-xs"></i>
                    </button>

                    <ul id="masterSub" class="hidden mt-1">

                        @userCan('Countries','view')
                        <li>
                            <a href="{{ route('countries.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('countries.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Countries
                            </a>
                        </li>
                        @enduserCan

                        @userCan('States','view')
                        <li>
                            <a href="{{ route('states.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('states.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                States
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Cities','view')
                        <li>
                            <a href="{{ route('cities.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('cities.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Cities
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Pincodes','view')
                        <li>
                            <a href="{{ route('pincodes.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('pincodes.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Pincode
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Dealer','view')
                        <li>
                            <a href="{{ route('dealers.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('dealers.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Dealers
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Mapping','view')
                        <li>
                            <a href="{{ route('dealer-mapping.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('dealer-mapping.index') || request()->routeIs('dealer-mapping.create') || request()->routeIs('dealer-mapping.edit') || request()->routeIs('dealer-mapping.show') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Dealer Mapping
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('dealer-mapping.hierarchy') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('dealer-mapping.hierarchy') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                View Hierarchy
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Users','view')
                        <li>
                            <a href="{{ route('users.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('users.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Users
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Permission Dropdown','view')
                        <li>
                            <a href="{{ route('permission-dropdown.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('permission-dropdown.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Permission Dropdown
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Sales Stage','view')
                        <li>
                            <a href="{{ route('sales-stage.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('sales-stage.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Sales Stage
                            </a>
                        </li>
                        @enduserCan

                        @userCan('ScrapDistributor','view')
                        <li>
                            <a href="{{ route('scrap-distributors.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('scrap-distributors.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Scrap Distributor
                            </a>
                        </li>
                        @enduserCan

                        @userCan('ScrapSeller','view')
                        <li>
                            <a href="{{ route('scrap-sellers.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('scrap-sellers.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Scrap Seller
                            </a>
                        </li>
                        @enduserCan

                        @userCan('BdeHomeLocation','view')
                        <li>
                            <a href="{{ route('bde-home-locations.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('bde-home-locations.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                BDE Home Location
                            </a>
                        </li>
                        @enduserCan

                        @userCan('SoHomeLocation','view')
                        <li>
                            <a href="{{ route('so-home-locations.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('so-home-locations.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                SO Home Location
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Brands','view')
                        <li>
                            <a href="{{ route('brands.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('brands.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Brands
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Floor Stage','view')
                        <li>
                            <a href="{{ route('floor-stages.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('floor-stages.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Floor Stage
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Building Stage','view')
                        <li>
                            <a href="{{ route('building-stages.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('building-stages.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Building Stage
                            </a>
                        </li>
                        @enduserCan

                        @userCan('Dealer Registration','view')
                        <li>
                            <a href="{{ route('dealer-registrations.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('dealer-registrations.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Dealer Registration
                            </a>
                        </li>
                        @enduserCan

                    </ul>
                </li>
               

                <!-- Settings -->
                @userCan('Roles','view')
                <li class="px-2 mt-1">
                    <button id="settingMenu" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-gear w-5 text-center"></i>
                            <span>Settings</span>
                        </div>
                        <i id="settingArrow" class="fa-solid fa-chevron-down text-xs"></i>
                    </button>

                    <ul id="settingSub" class="hidden mt-1">

                        <li>
                            <a href="{{ route('roles.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('roles.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Roles
                            </a>
                        </li>

                        @userCan('Permissions','view')
                        <li>
                            <a href="{{ route('permissions.index') }}" data-load="ajax"
                                class="block ml-10 mr-2 px-3 py-2 rounded-lg text-sm transition
                                {{ request()->routeIs('permissions.*') ? 'bg-red-50 text-red-700 font-semibold' : 'hover:bg-red-50 hover:text-red-700' }}">
                                Permissions
                            </a>
                        </li>
                        @enduserCan

                    </ul>
                </li>
                @enduserCan

            </ul>
        </div>

        <!-- Logout -->
        <div class="border-t p-4 bg-white">
            <form action="{{ route('logout') }}" method="POST" data-ajax-skip>
                @csrf
                <button type="submit"
                    class="w-full bg-red-700 hover:bg-red-800 text-white rounded-lg py-2.5 flex items-center justify-center gap-2 transition-all duration-200">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
document.addEventListener("DOMContentLoaded",function(){

    const masterMenu = document.getElementById("masterMenu");
    const masterSub = document.getElementById("masterSub");
    const masterArrow = document.getElementById("masterArrow");

    if(masterMenu){
        masterMenu.addEventListener("click",function(){
            masterSub.classList.toggle("hidden");
            masterArrow.classList.toggle("rotate-180");
            localStorage.setItem("masterOpen", masterSub.classList.contains("hidden") ? "false" : "true");
        });
    }

    const settingMenu = document.getElementById("settingMenu");
    const settingSub = document.getElementById("settingSub");
    const settingArrow = document.getElementById("settingArrow");

    if(settingMenu){
        settingMenu.addEventListener("click",function(){
            settingSub.classList.toggle("hidden");
            settingArrow.classList.toggle("rotate-180");
            localStorage.setItem("settingOpen", settingSub.classList.contains("hidden") ? "false" : "true");
        });
    }

    let path = window.location.pathname;

    let masterPages = [
        "countries","states","cities","pincodes",
        "dealers","dealer-mapping","users","permission-dropdown","sales-stage",
        "scrap-distributors","scrap-sellers","bde-home-locations","so-home-locations","brands","floor-stages","building-stages","dealer-registrations"
    ];

    if(masterPages.some(page=>path.includes(page))){
        if(masterSub){
            masterSub.classList.remove("hidden");
            masterArrow.classList.add("rotate-180");
        }
    }

    let settingPages = ["roles","permissions"];

    if(settingPages.some(page=>path.includes(page))){
        if(settingSub){
            settingSub.classList.remove("hidden");
            settingArrow.classList.add("rotate-180");
        }
    }

    window.onpopstate=function(){
        loadPage(location.href);
    };

});
</script>
