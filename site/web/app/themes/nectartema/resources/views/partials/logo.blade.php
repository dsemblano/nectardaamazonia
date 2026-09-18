<a class="brand max-w-[200px] w-full flex items-center" href="{{ home_url('/') }}">
  {{-- O grid força as duas imagens a ocuparem exatamente o mesmo espaço --}}
  <div class="grid grid-cols-1 grid-rows-1 aspect-[200/56] w-full">
    
    {{-- Logo Completa --}}
    <img id="logocompleta" width="200" height="56" 
         class="col-start-1 row-start-1 w-full h-full object-contain object-left opacity-100 transition-opacity duration-300 ease-in-out hover:scale-105" 
         alt="Logo da Néctar da Amazônia" 
         src="{{ Vite::asset('resources/images/logonectarnovo.webp') }}" />
    
    {{-- Logo Menor --}}
    <img id="logoonly" width="200" height="56" 
         class="col-start-1 row-start-1 w-full h-full object-contain object-left opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out hover:scale-105" 
         alt="Logo da Néctar da Amazônia" 
         src="{{ Vite::asset('resources/images/logoonly.webp') }}" />
         
  </div>
</a>