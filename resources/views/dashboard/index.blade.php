<x-layout title="Dashboard">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <h1 class="text-xl font-bold">Business Overview</h1>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a>{{ $appSetting->app_name ?? config('app.name') }}</a></li>
                <li><a>Dashboards</a></li>
                <li><span class="text-base-content">Ecommerce</span></li>
            </ul>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Revenue -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-sm text-base-content/60 font-medium">Revenue</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-bold">$587.54</span>
                            <div class="badge badge-success badge-sm gap-1 bg-green-100 text-green-700 border-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-3 h-3">
                                    <path fill-rule="evenodd"
                                        d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                        clip-rule="evenodd" />
                                </svg>
                                10.8%
                            </div>
                        </div>
                        <p class="text-xs text-base-content/50 mt-1">vs. $494.16 last period</p>
                    </div>
                    <div class="p-2 bg-base-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-sm text-base-content/60 font-medium">Sales</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-bold">4500</span>
                            <div class="badge badge-success badge-sm gap-1 bg-green-100 text-green-700 border-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-3 h-3">
                                    <path fill-rule="evenodd"
                                        d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                        clip-rule="evenodd" />
                                </svg>
                                21.2%
                            </div>
                        </div>
                        <p class="text-xs text-base-content/50 mt-1">vs. 3845 last period</p>
                    </div>
                    <div class="p-2 bg-base-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-sm text-base-content/60 font-medium">Customers</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-bold">2242</span>
                            <div class="badge badge-error badge-sm gap-1 bg-red-100 text-red-700 border-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-3 h-3">
                                    <path fill-rule="evenodd"
                                        d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z"
                                        clip-rule="evenodd" />
                                </svg>
                                6.8%
                            </div>
                        </div>
                        <p class="text-xs text-base-content/50 mt-1">vs. 2448 last period</p>
                    </div>
                    <div class="p-2 bg-base-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Spending -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-sm text-base-content/60 font-medium">Spending</h2>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-2xl font-bold">$112.54</span>
                            <div class="badge badge-success badge-sm gap-1 bg-green-100 text-green-700 border-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-3 h-3">
                                    <path fill-rule="evenodd"
                                        d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                        clip-rule="evenodd" />
                                </svg>
                                8.5%
                            </div>
                        </div>
                        <p class="text-xs text-base-content/50 mt-1">vs. $98.14 last period</p>
                    </div>
                    <div class="p-2 bg-base-200 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a22.53 22.53 0 005.293-6.388c.392-.71.185-1.583-.433-2.115l-6.38-6.381A2.25 2.25 0 0012.75 3h-3.182zM6.75 6a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <!-- Revenue Statistics (Bar Chart) -->
        <div class="card bg-base-100 shadow-sm col-span-1 lg:col-span-2">
            <div class="card-body p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h3 class="font-bold text-lg">Revenue Statistics</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-3xl font-bold">$184.78K</span>
                            <div class="badge badge-success badge-sm bg-green-100 text-green-700 border-none">
                                +3.24%</div>
                        </div>
                        <p class="text-xs text-base-content/50">Total income in this year</p>
                    </div>
                    <div class="join">
                        <button class="join-item btn btn-sm">Day</button>
                        <button class="join-item btn btn-sm">Month</button>
                        <button class="join-item btn btn-sm btn-active">Year</button>
                    </div>
                </div>

                <!-- Placeholder Bar Chart -->
                <div class="h-64 flex items-end justify-between gap-2 sm:gap-4 px-2">
                    <!-- Bars (Loop specific heights to mimic image) -->
                    @foreach ([30, 40, 35, 50, 45, 60, 75, 55, 65, 80] as $h)
                        <div class="w-full flex flex-col gap-1 items-center" style="height: {{ $h }}%">
                            <div class="w-full bg-secondary rounded-t-sm" style="height: 40%"></div>
                            <div class="w-full bg-base-300 rounded-t-sm" style="height: 60%"></div>
                        </div>
                    @endforeach
                </div>
                <!-- X Axis Labels -->
                <div class="flex justify-between text-xs text-base-content/50 mt-2 px-2">
                    <span>2016</span>
                    <span>2017</span>
                    <span>2018</span>
                    <span>2019</span>
                    <span>2020</span>
                    <span>2021</span>
                    <span>2022</span>
                    <span>2023</span>
                    <span>2024</span>
                    <span>2025</span>
                </div>
                <div class="flex justify-center gap-4 mt-4 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-secondary"></span> Orders
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-base-300"></span> Revenue
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Acquisition (Line Chart approximation) -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg">Customer Acquisition</h3>
                    <button class="btn btn-xs btn-ghost">••• Prediction</button>
                </div>

                <div class="flex gap-6 mb-6">
                    <div>
                        <p class="text-xs text-base-content/60">Advertise</p>
                        <p class="font-bold text-lg">$148</p>
                        <span class="text-xs text-green-500">↑ 4.78%</span>
                    </div>
                    <div>
                        <p class="text-xs text-base-content/60">Customers</p>
                        <p class="font-bold text-lg">36.5k</p>
                        <span class="text-xs text-green-500">↑ 5.23%</span>
                    </div>
                </div>

                <!-- Line Chart SVG -->
                <div class="h-40 relative flex items-end">
                    <svg viewBox="0 0 300 100" class="w-full h-full overflow-visible">
                        <!-- Background Grid -->
                        <line x1="0" y1="25" x2="300" y2="25" stroke="#f0f0f0"
                            stroke-width="1" />
                        <line x1="0" y1="50" x2="300" y2="50" stroke="#f0f0f0"
                            stroke-width="1" />
                        <line x1="0" y1="75" x2="300" y2="75" stroke="#f0f0f0"
                            stroke-width="1" />

                        <!-- Path 1 (Primary/Indigo) -->
                        <path d="M0,80 Q30,70 60,60 T120,40 T180,50 T240,30 T300,20" fill="none"
                            stroke="currentColor" class="text-primary" stroke-width="3" />
                        <!-- Path 2 (Secondary/Orange - dashed) -->
                        <path d="M0,90 Q30,85 60,75 T120,60 T180,70 T240,50 T300,40" fill="none"
                            stroke="currentColor" class="text-secondary" stroke-width="3" stroke-dasharray="5,5" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Quick Chat -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="card bg-base-100 shadow-sm col-span-1 lg:col-span-2">
            <div class="card-body p-0">
                <div class="p-6 flex justify-between items-center border-b border-base-200">
                    <h3 class="font-bold text-lg">Recent Orders</h3>
                    <div class="tabs tabs-boxed bg-transparent p-0">
                        <a class="tab tab-active bg-base-300 text-base-content rounded-btn btn-sm">All</a>
                        <a class="tab btn-sm">Pending</a>
                        <a class="tab btn-sm">Paid</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead class="bg-base-200/50">
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-xs" />
                                    </label>
                                </th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row 1 -->
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-xs" />
                                    </label>
                                </th>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-10 h-10 bg-base-300">
                                                <!-- Placeholder img -->
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">Macbook Pro 16</div>
                                            <div class="text-xs opacity-50">Laptop</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral-focus text-neutral-content rounded-full w-6">
                                                <span class="text-xs">J</span>
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium">Jane Doe</span>
                                    </div>
                                </td>
                                <td class="text-primary font-medium">#8569</td>
                                <td>01.02.2023</td>
                                <td class="font-bold">$2450.00</td>
                                <td><span class="badge badge-success badge-xs gap-1">Paid</span></td>
                            </tr>
                            <!-- Row 2 -->
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-xs" />
                                    </label>
                                </th>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-10 h-10 bg-base-300"></div>
                                        </div>
                                        <div>
                                            <div class="font-bold">iPhone 14 Pro</div>
                                            <div class="text-xs opacity-50">Mobile</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral-focus text-neutral-content rounded-full w-6">
                                                <span class="text-xs">A</span>
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium">Alex Smith</span>
                                    </div>
                                </td>
                                <td class="text-primary font-medium">#8570</td>
                                <td>02.02.2023</td>
                                <td class="font-bold">$1299.00</td>
                                <td><span class="badge badge-warning badge-xs gap-1">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Chat -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-0 flex flex-col h-full">
                <div class="p-6 border-b border-base-200 flex justify-between items-center">
                    <h3 class="font-bold text-lg">Quick Chat</h3>
                    <button class="btn btn-xs btn-ghost">•••</button>
                </div>
                <!-- Chat Content -->
                <div class="flex-1 p-4 overflow-y-auto space-y-4 max-h-80">
                    <div class="chat chat-start">
                        <div class="chat-image avatar">
                            <div class="w-8 rounded-full">
                                <img
                                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                            </div>
                        </div>
                        <div class="chat-bubble chat-bubble-primary text-sm">Hi, I need help with my order.</div>
                    </div>
                    <div class="chat chat-end">
                        <div class="chat-image avatar">
                            <div class="w-8 rounded-full">
                                <img
                                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                            </div>
                        </div>
                        <div class="chat-bubble chat-bubble-secondary text-sm">Sure, what seems to be the issue?</div>
                    </div>
                </div>
                <!-- Input -->
                <div class="p-4 border-t border-base-200">
                    <div class="join w-full">
                        <input class="input input-bordered input-sm join-item w-full"
                            placeholder="Type a message..." />
                        <button class="btn btn-primary btn-sm join-item">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
