<x-app-layout title="Register">
    <div class="bg-primary-container min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
        <div class="absolute inset-0 geometric-pattern opacity-40"></div>
        <div class="absolute top-[-10%] right-[-10%] w-125 h-125 bg-secondary-container/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-125 h-125 bg-primary/30 rounded-full blur-[120px]"></div>

        <main class="relative z-10 w-full max-w-120">
            <div class="bg-surface-container-lowest rounded-xl shadow-premium p-10 flex flex-col">
                <div class="flex flex-col items-center text-center mb-10">
                    <div class="w-16 h-16 bg-primary-container rounded-lg flex items-center justify-center mb-6 shadow-sm">
                        <x-lucide-icon name="school" class="text-white w-10 h-10" />
                    </div>
                    <h1 class="font-headline font-bold text-2xl text-primary tracking-tight">PMB Online</h1>
                    <p class="text-on-surface-variant font-medium mt-1">Buat Akun Baru Mahasiswa</p>
                </div>

                <form class="space-y-6" action="{{ route('register.store') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="p-4 rounded-lg bg-error/10 text-error text-sm font-semibold">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <x-forms.input name="full_name" label="Nama Lengkap" placeholder="Masukkan nama sesuai ijazah" icon="user" required />
                    <x-forms.input name="email" label="Alamat Email" type="email" placeholder="contoh@domain.com" icon="mail" required />
                    <div class="relative">
                        <x-forms.input name="password" label="Kata Sandi" type="password" placeholder="Min. 8 karakter" icon="lock" required class="pl-11 pr-12" />
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant/40 hover:text-primary">
                            <x-lucide-icon name="eye" class="w-5 h-5" />
                        </button>
                    </div>
                    <x-forms.button class="w-full py-4">
                        Daftar Sekarang
                        <x-lucide-icon name="arrow-right" class="w-5 h-5" />
                    </x-forms.button>
                </form>

                <div class="mt-8 pt-6 border-t border-surface-container-high text-center">
                    <p class="text-on-surface-variant text-sm font-medium">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>