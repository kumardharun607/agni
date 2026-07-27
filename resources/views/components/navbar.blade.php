<nav class="sticky top-0 z-40 bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6">

    <!-- Left -->
    <div class="flex items-center gap-4">

        <button
            id="openSidebar"
            class="lg:hidden text-gray-700 text-2xl">

            ☰

        </button>

        <div>

            <h1 class="text-xl font-bold text-gray-900">

                AGNI Dealer Management System

            </h1>

            <p class="text-sm text-gray-500">

                Dealer Management System

            </p>

        </div>

    </div>

    <!-- Right -->
    <div class="flex items-center gap-5">

        <!-- Search -->
        <div class="hidden md:block">

            <input
                type="text"
                placeholder="Search..."
                class="w-72 rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-600 focus:outline-none">

        </div>

        <!-- Notification -->
        <button class="relative">

            <i class="fa-solid fa-bell text-xl text-gray-600"></i>

            <span
                class="absolute -top-1 -right-1 bg-red-600 text-white rounded-full text-[10px] w-5 h-5 flex items-center justify-center">

                3

            </span>

        </button>

        <!-- Profile -->
        <div class="relative">

            <button
                id="profileButton"
                class="flex items-center gap-3">

                <div
                    class="w-10 h-10 rounded-full bg-red-700 text-white flex items-center justify-center font-bold">

                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name,0,1)) : 'A' }}

                </div>

                <div class="hidden md:block text-left">

                    <p class="font-semibold text-sm">

                        {{ auth()->check() ? auth()->user()->name : 'Super Admin' }}

                    </p>

                    <p class="text-xs text-gray-500">

                        @if(auth()->check() && method_exists(auth()->user(),'getRoleNames'))

                            {{ auth()->user()->getRoleNames()->first() }}

                        @else

                            Super Admin

                        @endif

                    </p>

                </div>

                <i class="fa-solid fa-angle-down text-gray-500"></i>

            </button>

            <!-- Profile Dropdown -->
            <div
                id="profileDropdown"
                class="hidden absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">

                <div class="px-5 py-4 bg-gray-50 border-b">

                    <p class="font-semibold text-gray-900">

                        {{ auth()->check() ? auth()->user()->name : 'Super Admin' }}

                    </p>

                    <p class="text-sm text-gray-500">

                        {{ auth()->check() ? auth()->user()->email : 'admin@agni.com' }}

                    </p>

                </div>

                <!-- My Profile -->
                <a
                    href="{{ route('profile.index') }}"
                    data-load="ajax"
                    data-tab="profile"
                    class="flex items-center gap-3 px-5 py-3 hover:bg-red-50 transition">

                    <i class="fa-solid fa-user text-red-600 w-5"></i>

                    <span>My Profile</span>

                </a>

                <!-- Change Password -->
               

                <div class="border-t"></div>

                                <!-- Logout -->

                <form action="{{ route('logout') }}" method="POST" data-ajax-skip>

                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-5 py-3 text-red-700 hover:bg-red-50 transition">

                        <i class="fa-solid fa-right-from-bracket w-5"></i>

                        <span>Logout</span>

                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const profileButton = document.getElementById("profileButton");
    const profileDropdown = document.getElementById("profileDropdown");

    if (profileButton) {

        profileButton.addEventListener("click", function (e) {

            e.stopPropagation();

            profileDropdown.classList.toggle("hidden");

        });

    }

    document.addEventListener("click", function () {

        if (profileDropdown) {

            profileDropdown.classList.add("hidden");

        }

    });

    if (profileDropdown) {

        profileDropdown.addEventListener("click", function (e) {

            e.stopPropagation();

        });

    }

    $(document).on("click", "a[data-load='ajax']", function () {

        if (profileDropdown) {

            profileDropdown.classList.add("hidden");

        }

    });

});

</script>