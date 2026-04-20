<x-app-layout title="Login">
    <div class="bg-primary-container min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
        <div class="absolute inset-0 geometric-pattern opacity-40"></div>
        <div class="absolute top-[-10%] right-[-10%] w-125 h-125 bg-secondary-container/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-125 h-125 bg-primary/30 rounded-full blur-[120px]"></div>

        <main class="relative w-full max-w-105 z-10">
            <div class="bg-surface-container-lowest rounded-xl shadow-premium p-10 flex flex-col items-center">
                <div class="mb-8 flex flex-col items-center gap-3">
                    <div class="w-16 h-16 bg-primary-container rounded-lg flex items-center justify-center shadow-lg">
                        <x-lucide-icon name="school" class="text-secondary-container w-10 h-10" />
                    </div>
                    <div class="text-center">
                        <h1 class="text-2xl font-extrabold text-primary tracking-tight font-headline">PMB Online</h1>
                        <p class="text-sm font-medium text-on-surface-variant tracking-wide mt-1">Sistem Pendaftaran Mahasiswa Baru</p>
                    </div>
                </div>

                <form action="{{ route('login.store') }}" method="POST" class="w-full space-y-6">
                    @csrf
                    @if ($errors->any())
                        <div class="p-4 rounded-lg bg-error/10 text-error text-sm font-semibold">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <x-forms.input name="email" label="Email Address" type="email" placeholder="name@university.edu" icon="mail" required />

                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Password</label>
                            <a href="#" class="text-xs font-bold text-primary hover:text-secondary-container transition-colors">Forgot Password?</a>
                        </div>
                        <div class="relative">
                            <x-forms.input name="password" label="" type="password" placeholder="••••••••" icon="lock" required class="pl-11 pr-12" />
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant/50 hover:text-primary">
                                <x-lucide-icon name="eye" class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <x-forms.button class="w-full py-4">
                        Masuk
                        <x-lucide-icon name="arrow-right" class="w-5 h-5" />
                    </x-forms.button>
                </form>

                <div class="w-full my-8 flex items-center gap-4">
                    <div class="h-px flex-1 bg-surface-container-high"></div>
                    <span class="text-xs font-bold text-on-surface-variant/40 uppercase tracking-widest">New Student?</span>
                    <div class="h-px flex-1 bg-surface-container-high"></div>
                </div>

                <a href="{{ route('register') }}" class="w-full py-3 px-4 border-2 border-primary/5 text-primary font-bold rounded-lg hover:bg-primary/5 transition-colors text-center">
                    Buat Akun Baru
                </a>
            </div>

            <footer class="mt-8 text-center">
                <p class="text-blue-100/40 text-xs font-medium tracking-wide">© 2024 Universitas. All rights reserved.</p>
                <div class="mt-2 flex justify-center gap-4">
                    <a href="#" class="text-[10px] text-blue-100/30 uppercase tracking-widest font-bold hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-[10px] text-blue-100/30 uppercase tracking-widest font-bold hover:text-white transition-colors">Terms of Service</a>
                </div>
            </footer>
        </main>
    </div>
</x-app-layout>