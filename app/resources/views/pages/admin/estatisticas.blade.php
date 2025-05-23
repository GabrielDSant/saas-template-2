<!doctype html>
<html>

@include('components.head')


<body>
    @include('components.header')
    <div class="flex">
        <!-- Main Content -->
        <main class="w-full bg-gray-200 min-h-screen transition-all main">
            <!-- Content -->
            <div class="p-6">
                <div>
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>

                    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div
                            class="relative overflow-hidden rounded-lg bg-gray-600 px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                            <dt>
                                <div class="absolute rounded-md bg-red-600 p-3">
                                    <svg class="h-6 w-6 text-gray-900" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </div>
                                <p class="ml-16 truncate text-sm font-medium text-gray-300">Total Subscribers</p>
                            </dt>
                            <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-100">71,897</p>
                                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                    <svg class="h-5 w-5 flex-shrink-0 self-center text-green-500" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only"> Increased by </span>
                                    122
                                </p>
                                <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-orange-400 hover:text-red-500">View
                                            all<span class="sr-only"> Total Subscribers stats</span></a>
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div
                            class="relative overflow-hidden rounded-lg bg-gray-600 px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                            <dt>
                                <div class="absolute rounded-md bg-orange-500 p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.98l7.5-4.04a2.25 2.25 0 012.134 0l7.5 4.04a2.25 2.25 0 011.183 1.98V19.5z" />
                                    </svg>
                                </div>
                                <p class="ml-16 truncate text-sm font-medium text-gray-300">Avg. Open Rate</p>
                            </dt>
                            <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-100">58.16%</p>
                                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                    <svg class="h-5 w-5 flex-shrink-0 self-center text-green-500" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only"> Increased by </span>
                                    5.4%
                                </p>
                                <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-yellow-600 hover:text-orange-500">View
                                            all<span class="sr-only"> Avg. Open Rate stats</span></a>
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div
                            class="relative overflow-hidden rounded-lg bg-gray-600 px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                            <dt>
                                <div class="absolute rounded-md bg-blue-500 p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                                    </svg>
                                </div>
                                <p class="ml-16 truncate text-sm font-medium text-gray-300">Avg. Click Rate</p>
                            </dt>
                            <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-100">24.57%</p>
                                <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
                                    <svg class="h-5 w-5 flex-shrink-0 self-center text-red-500" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only"> Decreased by </span>
                                    3.2%
                                </p>
                                <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-cyan-600 hover:text-green-500">View
                                            all<span class="sr-only"> Avg. Click Rate stats</span></a>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 mt-6">
                    <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                        <div class="flex justify-between mb-6">
                            <div>
                                <div class="flex items-center mb-1">
                                    <div class="text-2xl font-semibold">2</div>
                                </div>
                                <div class="text-sm font-medium text-gray-400">Users</div>
                            </div>
                            <div class="dropdown">
                                <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i
                                        class="ri-more-fill"></i></button>
                                <ul
                                    class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <a href="/dashboard/admin/users"
                            class="text-[#f84525] font-medium text-sm hover:text-red-800">View</a>
                    </div>
                    <!-- Add other content here -->
                </div>
            </div>
            <!-- End Content -->
        </main>
    </div>

</body>

</html>
