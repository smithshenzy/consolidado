
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión Informática</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background:
                radial-gradient(circle at 20% 20%, rgba(0, 212, 255, 0.15), transparent 30%),
                radial-gradient(circle at 80% 80%, rgba(37, 99, 235, 0.20), transparent 30%),
                linear-gradient(135deg, #020617, #0f172a, #111827);
        }

        .tech-card {
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(56, 189, 248, 0.25);
            box-shadow:
                0 0 30px rgba(0, 212, 255, 0.08),
                0 25px 50px rgba(0, 0, 0, 0.45);
        }

        .tech-input {
            background: rgba(2, 6, 23, 0.75);
            border: 1px solid #334155;
            color: white;
        }

        .tech-input:focus {
            border-color: #22d3ee;
            box-shadow: 0 0 0 2px rgba(34, 211, 238, 0.15);
        }

        .tech-input::placeholder {
            color: #64748b;
        }

        .tech-button {
            background: linear-gradient(90deg, #2563eb, #0891b2);
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.20);
        }

        .tech-button:hover {
            background: linear-gradient(90deg, #1d4ed8, #0e7490);
            box-shadow: 0 0 25px rgba(34, 211, 238, 0.35);
        }

        .tech-line {
            background: linear-gradient(
                90deg,
                transparent,
                #22d3ee,
                transparent
            );
        }

        .tech-grid {
            background-image:
                linear-gradient(rgba(56, 189, 248, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56, 189, 248, 0.035) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 tech-grid bg-gray-400">

<div class="w-full max-w-md">

    {{-- CONTENEDOR DEL LOGIN --}}
    <div class="tech-card rounded-2xl p-8">

        {{-- ENCABEZADO --}}
        <div class="text-center mb-8">

            {{-- ICONO --}}
            <div class="flex justify-center mb-5">
                <div
                    class="w-20 h-20 rounded-2xl
                               bg-cyan-400/10
                               border border-cyan-400/30
                               flex items-center justify-center
                               shadow-lg shadow-cyan-500/10"
                >
                    <i class="fa-solid fa-microchip text-4xl text-cyan-400"></i>
                </div>
            </div>

            {{-- TITULO --}}
            <h1 class="text-2xl font-bold text-white font-orbitron tracking-wide">
                GESTIÓN INFORMÁTICA
            </h1>

            <p class="text-sm text-slate-400 mt-3">
                Estadística, Informática y Telecomunicaciones
            </p>

            {{-- LINEA --}}
            <div class="tech-line h-px w-32 mx-auto mt-5"></div>

        </div>


        {{-- FORMULARIO --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">

            @csrf

            {{-- USUARIO --}}
            <div>

                <label
                    for="username"
                    class="block text-sm font-medium text-slate-300 mb-2"
                >
                    Usuario
                </label>

                <div class="relative">

                    <i
                        class="fa-solid fa-user absolute left-4 top-1/2
                                   -translate-y-1/2 text-cyan-400"
                    ></i>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Ingrese su usuario"
                        autocomplete="username"
                        autofocus
                        required
                        class="tech-input w-full pl-11 pr-4 py-3 rounded-lg
                                   focus:outline-none transition"
                    >

                </div>

            </div>


            {{-- CONTRASEÑA --}}
            <div>

                <label
                    for="password"
                    class="block text-sm font-medium text-slate-300 mb-2"
                >
                    Contraseña
                </label>

                <div class="relative">

                    <i
                        class="fa-solid fa-lock absolute left-4 top-1/2
                                   -translate-y-1/2 text-cyan-400"
                    ></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingrese su contraseña"
                        autocomplete="current-password"
                        required
                        class="tech-input w-full pl-11 pr-4 py-3 rounded-lg
                                   focus:outline-none transition"
                    >

                </div>

            </div>


            {{-- ERROR --}}
            @error('username')

            <div
                class="flex items-center gap-2
                               bg-red-500/10
                               text-red-400
                               border border-red-500/30
                               rounded-lg p-3"
            >

                <i class="fa-solid fa-circle-exclamation"></i>

                <span class="text-sm">
                            {{ $message }}
                        </span>

            </div>

            @enderror


            {{-- BOTÓN --}}
            <button
                type="submit"
                class="tech-button w-full
                           text-white font-semibold
                           py-3 px-4 rounded-lg
                           transition duration-200
                           focus:outline-none
                           focus:ring-2
                           focus:ring-cyan-400
                           focus:ring-offset-2
                           focus:ring-offset-slate-900"
            >
                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                Iniciar sesión
            </button>

        </form>


        {{-- PIE --}}
        <div class="mt-8 pt-5 border-t border-slate-700/60 text-center">

            <p class="text-xs text-cyan-400/70 mt-3 font-medium tracking-wider">
                <span class="text-sm">©</span> Ing. Smith Salazar
            </p>

        </div>

    </div>

</div>

</body>
</html>

