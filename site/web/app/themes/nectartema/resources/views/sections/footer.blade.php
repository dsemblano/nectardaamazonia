<footer id="footer" class="content-info bg-footer">
    <div
        class="container max-w-none text-p prose:a:text-p py-6">
        @php(dynamic_sidebar('sidebar-footer'))
        <div class="text-sm mt-4 flex flex-col items-center copyright border-gray-500 border-t border-solid pt-8 gap-2 text-white">
            <span class="z-10 font-bold text-p">© 2009 - {{ date('Y') }} 
                <a class="hover:underline text-p" href="{{ home_url('/') }}">Néctar da Amazônia</a>
                <span id="trademark" class="sup align-text-bottom">&reg;</span>
            </span>
        </div>
    </div>

</footer>
