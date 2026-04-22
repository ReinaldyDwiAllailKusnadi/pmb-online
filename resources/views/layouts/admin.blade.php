<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>PMB Gateway - Admin</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#1E3A5F',
                            'primary-dark': '#1A2744',
                            secondary: '#F0A500',
                            background: '#F1F5F9',
                            'on-surface-variant': '#64748B',
                        },
                    },
                },
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <style>
            * { font-family: 'Inter', sans-serif; }
            body {
                background-color: #F1F5F9;
                margin: 0;
                padding: 0;
                color: #1E3A5F;
            }
            input, textarea, button { font: inherit; }
            button:not(:disabled), a[href], label[for], select { cursor: pointer; }
            button:disabled, [aria-disabled="true"] { cursor: not-allowed; opacity: 0.5; transform: none !important; }
            a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
                outline: 2px solid rgba(240, 165, 0, 0.65);
                outline-offset: 2px;
            }
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
            tbody tr:hover { background-color: rgba(241,245,249,0.5); }
            a, button { transition: all 0.2s ease; }
            .card-shadow { box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06); }
            .lift-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
            .lift-hover:hover { transform: translateY(-4px); box-shadow: 0 18px 36px rgba(15, 23, 42, 0.12); }
            .fade-up {
                animation: fadeUp 0.55s ease both;
            }
            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(18px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @media (max-width: 1023px) {
                body { overflow-x: hidden; }
                .admin-sidebar { display: none !important; }
                .admin-topbar {
                    left: 0 !important;
                    right: 0 !important;
                    width: 100% !important;
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }
                main {
                    margin-left: 0 !important;
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                    padding-bottom: 6rem !important;
                }
            }
        </style>

        @stack('styles')
    </head>
    <body>
        @yield('content')
        <script>
            document.addEventListener('submit', function (event) {
                const form = event.target;

                if (!(form instanceof HTMLFormElement) || form.dataset.allowResubmit === 'true') {
                    return;
                }

                if (form.dataset.submitted === 'true') {
                    event.preventDefault();
                    return;
                }

                form.dataset.submitted = 'true';

                requestAnimationFrame(function () {
                    form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (button) {
                        button.setAttribute('aria-disabled', 'true');
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                        button.disabled = true;
                    });
                });
            });
        </script>
        @stack('scripts')
    </body>
</html>
