<footer class="footer footer-center p-4 bg-base-100 text-base-content border-t border-base-200 mt-auto">
    <aside>
        <p>Copyright © {{ date('Y') }} - All right reserved by <span
                class="font-bold">{{ $appSetting->app_name ?? config('app.name') }}</span></p>
    </aside>
</footer>
