<!doctype html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Ratu Komputer</title>
  
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: { "50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a" }
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans">

  <div class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden dark:bg-gray-800 dark:border-gray-700">
      
      <div class="hidden md:block relative h-full min-h-[500px]">
        <img class="absolute inset-0 w-full h-full object-cover" 
             src="{{ asset('assets/images/SuperAdminRK.png') }}" 
             alt="Welcome Image">
      </div>

      <div class="p-8 md:p-10 flex flex-col justify-center"> <div class="mb-8"> <h5 class="text-4xl font-bold text-slate-700 dark:text-white mb-2">Welcome Back!</h5>
            <p class="text-base text-gray-500 dark:text-gray-400">Sign In To Your Account</p>
        </div>

        <form class="space-y-5" method="POST" action="{{ route('login') }}">
          @csrf

          @if ($errors->any())
            <div class="p-3 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-800" role="alert">
                @if ($errors->has('session'))
                    <span class="font-bold">Sesi Habis!</span> {{ $errors->first('session') }}
                @else
                    <span class="font-bold">Gagal Masuk!</span> Email atau password salah.
                @endif
            </div>
          @endif

          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
              placeholder="name@company.com" required autofocus />
          </div>

          <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password" placeholder="••••••••"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
              required />
          </div>

          <!-- <div class="flex items-center justify-end">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline dark:text-blue-400 font-medium">Lupa Password?</a>
            @endif
          </div> -->

          <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">LOGIN</button>
          
          <div class="pt-4 border-t border-gray-200 dark:border-gray-700 text-center">
             <p class="text-sm text-gray-500 dark:text-gray-400">
                 Belum Punya Akun? <span class="text-gray-300">Kontak Pimpinan Terkait!</span>
             </p>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>