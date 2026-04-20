import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import App from './App';

const rootElement = document.getElementById('app');

if (rootElement) {
    createRoot(rootElement).render(
        <StrictMode>
            <App />
        </StrictMode>
    );
}/**
 * @license
 * SPDX-License-Identifier: Apache-2.0
 */

import { useState } from 'react';
import { motion, AnimatePresence } from 'motion/react';
import {
    School,
    Mail,
    Lock,
    Eye,
    ArrowRight,
    LayoutDashboard,
    FileText,
    ClipboardCheck,
    FileDown,
    HelpCircle,
    LogOut,
    Bell,
    Settings,
    ChevronRight,
    Check,
    Upload,
    Info,
    Calendar,
    ShieldCheck,
    Share2,
    Headphones,
    BookOpen,
    Wallet,
    CalendarDays,
    User,
    Camera,
    AlertCircle,
    ArrowLeft,
} from 'lucide-react';
import { cn } from './lib/utils';

// --- Types ---
type View =
    | 'login'
    | 'register'
    | 'dashboard'
    | 'form-step1'
    | 'form-step2'
    | 'form-step3'
    | 'status'
    | 'pdf';

// --- Components ---

const Sidebar = ({
    currentView,
    setView,
}: {
    currentView: View;
    setView: (v: View) => void;
}) => {
    const navItems = [
        { id: 'dashboard', label: 'Beranda', icon: LayoutDashboard },
        { id: 'form-step1', label: 'Formulir Pendaftaran', icon: FileText },
        { id: 'status', label: 'Status Pendaftaran', icon: ClipboardCheck },
        { id: 'pdf', label: 'Unduh Bukti PDF', icon: FileDown },
    ];

    return (
    <aside className="w-65 h-screen bg-primary-container flex flex-col fixed left-0 top-0 py-8 z-50 overflow-y-auto">
            <div className="px-8 mb-10 flex items-center gap-3">
                <div className="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                    <School className="text-primary w-6 h-6" />
                </div>
                <div>
                    <h1 className="text-white font-headline font-extrabold tracking-tight text-lg leading-tight">
                        PMB Gateway
                    </h1>
                    <p className="text-blue-100/60 text-[10px] font-medium uppercase tracking-widest font-headline">
                        Admission Portal
                    </p>
                </div>
            </div>

            <nav className="flex-1 flex flex-col space-y-1">
                {navItems.map((item) => (
                    <button
                        key={item.id}
                        onClick={() => setView(item.id as View)}
                        className={cn(
                            'text-left py-3 px-6 flex items-center gap-3 transition-all relative group',
                            currentView === item.id ||
                                (item.id === 'form-step1' && currentView.startsWith('form-'))
                                ? 'bg-secondary-container text-white border-l-4 border-white font-bold'
                                : 'text-blue-100/70 hover:bg-white/10 hover:text-white'
                        )}
                    >
                        <item.icon
                            className={cn(
                                'w-5 h-5',
                                currentView === item.id ||
                                    (item.id === 'form-step1' && currentView.startsWith('form-'))
                                    ? 'fill-current'
                                    : ''
                            )}
                        />
                        <span className="text-sm tracking-wide">{item.label}</span>
                    </button>
                ))}
            </nav>

            <div className="mt-auto px-6 border-t border-white/10 pt-6 space-y-2">
                <button className="text-blue-100/70 py-3 flex items-center gap-3 hover:text-white transition-all w-full text-left">
                    <HelpCircle className="w-5 h-5" />
                    <span className="text-sm">Help Center</span>
                </button>
                <button
                    onClick={() => setView('login')}
                    className="text-blue-100/70 py-3 flex items-center gap-3 hover:text-red-300 transition-all w-full text-left"
                >
                    <LogOut className="w-5 h-5" />
                    <span className="text-sm">Keluar</span>
                </button>
            </div>
        </aside>
    );
};

const Header = ({ title }: { title: string }) => {
    return (
        <header className="h-16 sticky top-0 z-40 bg-white/90 backdrop-blur-xl flex items-center justify-between px-8 w-full shadow-subtle">
            <div className="flex items-center gap-6">
                <h2 className="text-xl font-bold text-primary font-headline tracking-tight">
                    {title}
                </h2>
                <div className="hidden md:flex items-center gap-6">
                    <a
                        href="#"
                        className="text-slate-600 font-medium hover:text-primary transition-colors text-sm"
                    >
                        Admissions
                    </a>
                    <a
                        href="#"
                        className="text-slate-600 font-medium hover:text-primary transition-colors text-sm"
                    >
                        Academic
                    </a>
                    <a
                        href="#"
                        className="text-slate-600 font-medium hover:text-primary transition-colors text-sm"
                    >
                        Scholarships
                    </a>
                </div>
            </div>
            <div className="flex items-center gap-4">
                <button className="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-50 transition-all text-slate-600">
                    <Bell className="w-5 h-5" />
                </button>
                <button className="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-50 transition-all text-slate-600">
                    <Settings className="w-5 h-5" />
                </button>
                <div className="flex items-center gap-3 ml-2 pl-4 border-l border-slate-100">
                    <div className="text-right hidden sm:block">
                        <p className="text-sm font-bold text-primary">Budi Santoso</p>
                        <p className="text-[10px] font-medium text-slate-500 uppercase tracking-tighter">
                            Student ID: 20240012
                        </p>
                    </div>
                    <img
                        src="https://picsum.photos/seed/student-jerry/100/100"
                        alt="User"
                        className="w-10 h-10 rounded-full border-2 border-white shadow-sm"
                        referrerPolicy="no-referrer"
                    />
                </div>
            </div>
        </header>
    );
};

// --- Views ---

const LoginView = ({ setView }: { setView: (v: View) => void }) => {
    return (
        <div className="bg-primary-container min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
            <div className="absolute inset-0 geometric-pattern opacity-40"></div>
            <div className="absolute top-[-10%] right-[-10%] w-125 h-125 bg-secondary-container/10 rounded-full blur-[120px]"></div>
            <div className="absolute bottom-[-10%] left-[-10%] w-125 h-125 bg-primary/30 rounded-full blur-[120px]"></div>

            <main className="relative w-full max-w-105 z-10">
                <div className="bg-surface-container-lowest rounded-xl shadow-premium p-10 flex flex-col items-center">
                    <div className="mb-8 flex flex-col items-center gap-3">
                        <div className="w-16 h-16 bg-primary-container rounded-lg flex items-center justify-center shadow-lg">
                            <School className="text-secondary-container w-10 h-10" />
                        </div>
                        <div className="text-center">
                            <h1 className="text-2xl font-extrabold text-primary tracking-tight font-headline">
                                PMB Online
                            </h1>
                            <p className="text-sm font-medium text-on-surface-variant tracking-wide mt-1">
                                Sistem Pendaftaran Mahasiswa Baru
                            </p>
                        </div>
                    </div>

                    <form
                        onSubmit={(e) => {
                            e.preventDefault();
                            setView('dashboard');
                        }}
                        className="w-full space-y-6"
                    >
                        <div className="space-y-1.5">
                            <label className="text-xs font-bold text-on-surface-variant uppercase tracking-wider ml-1">
                                Email Address
                            </label>
                            <div className="relative group">
                                <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-on-surface-variant/50 group-focus-within:text-primary transition-colors">
                                    <Mail className="w-5 h-5" />
                                </div>
                                <input
                                    type="email"
                                    className="w-full pl-11 pr-4 py-3.5 bg-surface-container-high border-none rounded-lg focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all text-on-surface placeholder:text-on-surface-variant/40"
                                    placeholder="name@university.edu"
                                    required
                                />
                            </div>
                        </div>

                        <div className="space-y-1.5">
                            <div className="flex justify-between items-center px-1">
                                <label className="text-xs font-bold text-on-surface-variant uppercase tracking-wider">
                                    Password
                                </label>
                                <a
                                    href="#"
                                    className="text-xs font-bold text-primary hover:text-secondary-container transition-colors"
                                >
                                    Forgot Password?
                                </a>
                            </div>
                            <div className="relative group">
                                <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-on-surface-variant/50 group-focus-within:text-primary transition-colors">
                                    <Lock className="w-5 h-5" />
                                </div>
                                <input
                                    type="password"
                                    className="w-full pl-11 pr-12 py-3.5 bg-surface-container-high border-none rounded-lg focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all text-on-surface placeholder:text-on-surface-variant/40"
                                    placeholder="••••••••"
                                    required
                                />
                                <button
                                    type="button"
                                    className="absolute inset-y-0 right-0 pr-4 flex items-center text-on-surface-variant/50 hover:text-primary transition-colors"
                                >
                                    <Eye className="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        <button
                            type="submit"
                            className="w-full py-4 bg-secondary-container text-white font-bold rounded-lg shadow-lg shadow-secondary-container/20 hover:scale-[1.01] active:scale-[0.98] transition-all flex items-center justify-center gap-2 group"
                        >
                            Masuk
                            <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                        </button>
                    </form>

                    <div className="w-full my-8 flex items-center gap-4">
                        <div className="h-px flex-1 bg-surface-container-high"></div>
                        <span className="text-xs font-bold text-on-surface-variant/40 uppercase tracking-widest">
                            New Student?
                        </span>
                        <div className="h-px flex-1 bg-surface-container-high"></div>
                    </div>

                    <button
                        onClick={() => setView('register')}
                        className="w-full py-3 px-4 border-2 border-primary/5 text-primary font-bold rounded-lg hover:bg-primary/5 transition-colors"
                    >
                        Buat Akun Baru
                    </button>
                </div>

                <footer className="mt-8 text-center">
                    <p className="text-blue-100/40 text-xs font-medium tracking-wide">
                        © 2024 Universitas. All rights reserved.
                    </p>
                    <div className="mt-2 flex justify-center gap-4">
                        <a
                            href="#"
                            className="text-[10px] text-blue-100/30 uppercase tracking-widest font-bold hover:text-white transition-colors"
                        >
                            Privacy Policy
                        </a>
                        <a
                            href="#"
                            className="text-[10px] text-blue-100/30 uppercase tracking-widest font-bold hover:text-white transition-colors"
                        >
                            Terms of Service
                        </a>
                    </div>
                </footer>
            </main>
        </div>
    );
};

const RegisterView = ({ setView }: { setView: (v: View) => void }) => {
    return (
        <div className="bg-primary-container min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
            <div className="absolute inset-0 geometric-pattern opacity-40"></div>
            <div className="absolute top-[-10%] right-[-10%] w-125 h-125 bg-secondary-container/10 rounded-full blur-[120px]"></div>
            <div className="absolute bottom-[-10%] left-[-10%] w-125 h-125 bg-primary/30 rounded-full blur-[120px]"></div>

            <main className="relative z-10 w-full max-w-120">
                <div className="bg-surface-container-lowest rounded-xl shadow-premium p-10 flex flex-col">
                    <div className="flex flex-col items-center text-center mb-10">
                        <div className="w-16 h-16 bg-primary-container rounded-lg flex items-center justify-center mb-6 shadow-sm">
                            <School className="text-white w-10 h-10" />
                        </div>
                        <h1 className="font-headline font-bold text-2xl text-primary tracking-tight">
                            PMB Online
                        </h1>
                        <p className="text-on-surface-variant font-medium mt-1">
                            Buat Akun Baru Mahasiswa
                        </p>
                    </div>

                    <form
                        className="space-y-6"
                        onSubmit={(e) => {
                            e.preventDefault();
                            setView('login');
                        }}
                    >
                        <div className="space-y-1.5">
                            <label className="block text-xs font-bold text-on-surface-variant uppercase tracking-wider">
                                Nama Lengkap
                            </label>
                            <div className="relative group">
                                <User className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-on-surface-variant/40 group-focus-within:text-primary transition-colors" />
                                <input
                                    className="block w-full pl-11 pr-4 py-3.5 bg-surface-container-high border-0 rounded-lg text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                                    placeholder="Masukkan nama sesuai ijazah"
                                    required
                                />
                            </div>
                        </div>

                        <div className="space-y-1.5">
                            <label className="block text-xs font-bold text-on-surface-variant uppercase tracking-wider">
                                Alamat Email
                            </label>
                            <div className="relative group">
                                <Mail className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-on-surface-variant/40 group-focus-within:text-primary transition-colors" />
                                <input
                                    type="email"
                                    className="block w-full pl-11 pr-4 py-3.5 bg-surface-container-high border-0 rounded-lg text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                                    placeholder="contoh@domain.com"
                                    required
                                />
                            </div>
                        </div>

                        <div className="space-y-1.5">
                            <label className="block text-xs font-bold text-on-surface-variant uppercase tracking-wider">
                                Kata Sandi
                            </label>
                            <div className="relative group">
                                <Lock className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-on-surface-variant/40 group-focus-within:text-primary transition-colors" />
                                <input
                                    type="password"
                                    className="block w-full pl-11 pr-12 py-3.5 bg-surface-container-high border-0 rounded-lg text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all"
                                    placeholder="Min. 8 karakter"
                                    required
                                />
                                <button
                                    type="button"
                                    className="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant/40 hover:text-primary"
                                >
                                    <Eye className="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        <button
                            type="submit"
                            className="w-full bg-secondary-container text-white font-headline font-bold py-4 rounded-lg shadow-lg hover:shadow-xl hover:bg-secondary-container/90 transition-all transform hover:-translate-y-0.5 active:scale-[0.98] mt-4 flex items-center justify-center gap-2 group"
                        >
                            Daftar Sekarang
                            <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                        </button>
                    </form>

                    <div className="mt-8 pt-6 border-t border-surface-container-high text-center">
                        <p className="text-on-surface-variant text-sm font-medium">
                            Sudah punya akun?{' '}
                            <button
                                onClick={() => setView('login')}
                                className="text-primary font-bold hover:underline"
                            >
                                Masuk di sini
                            </button>
                        </p>
                    </div>
                </div>
            </main>
        </div>
    );
};

const DashboardView = ({ setView }: { setView: (v: View) => void }) => {
    return (
    <div className="ml-65 flex-1 flex flex-col min-h-screen">
            <Header title="Beranda" />

            <div className="p-8 space-y-8 max-w-7xl mx-auto w-full">
                <nav className="flex items-center gap-2 text-sm text-on-surface-variant font-medium">
                    <button className="hover:text-primary transition-colors">Beranda</button>
                    <ChevronRight className="w-4 h-4" />
                    <span className="text-primary font-bold">Dashboard Siswa</span>
                </nav>

                <section className="relative rounded-2xl overflow-hidden bg-primary-container p-10 flex flex-col md:flex-row justify-between items-center gap-8 shadow-lg">
                    <div className="z-10 text-center md:text-left">
                        <div className="inline-flex items-center px-3 py-1 bg-white/10 text-secondary-container rounded-full text-xs font-bold tracking-widest uppercase mb-4">
                            <span className="mr-2">●</span> Calon Mahasiswa
                        </div>
                        <h1 className="text-4xl md:text-5xl font-headline font-extrabold text-white leading-tight mb-3">
                            Selamat Datang, <br />Budi Santoso!
                        </h1>
                        <p className="text-blue-100/70 text-lg max-w-md">
                            Lengkapi administrasi Anda untuk menjadi bagian dari generasi unggul di
                            institusi kami.
                        </p>
                        <button
                            onClick={() => setView('form-step1')}
                            className="mt-8 px-8 py-3 bg-secondary-container text-white rounded-lg font-bold shadow-lg shadow-secondary-container/20 hover:scale-[1.02] active:scale-[0.98] transition-all"
                        >
                            Lengkapi Profil
                        </button>
                    </div>
                    <div className="relative z-10 w-64 h-64 rounded-full border-8 border-white/10 p-4 bg-linear-to-tr from-white/5 to-transparent flex items-center justify-center">
                        <School className="w-32 h-32 text-white/20" />
                    </div>
                </section>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div className="lg:col-span-2 bg-surface-container-lowest p-8 rounded-2xl shadow-subtle">
                        <div className="flex items-center justify-between mb-8">
                            <h3 className="text-lg font-bold text-primary">Tahap Pendaftaran</h3>
                            <span className="text-sm font-medium text-on-surface-variant">
                                25% Selesai
                            </span>
                        </div>
                        <div className="flex items-center justify-between relative px-2">
                            <div className="absolute top-5 left-10 right-10 h-1 bg-surface-container-high z-0">
                                <div className="h-full bg-primary w-1/2 rounded-full"></div>
                            </div>
                            <div className="relative z-10 flex flex-col items-center gap-3">
                                <div className="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center shadow-md">
                                    <Check className="w-5 h-5" />
                                </div>
                                <span className="text-sm font-bold text-primary">Data Pribadi</span>
                            </div>
                            <div className="relative z-10 flex flex-col items-center gap-3">
                                <div className="w-10 h-10 rounded-full bg-secondary-container text-white flex items-center justify-center shadow-md animate-pulse">
                                    <Upload className="w-5 h-5" />
                                </div>
                                <span className="text-sm font-bold text-secondary-container">
                                    Unggah Dokumen
                                </span>
                            </div>
                            <div className="relative z-10 flex flex-col items-center gap-3">
                                <div className="w-10 h-10 rounded-full bg-surface-container-high text-on-surface-variant/40 flex items-center justify-center">
                                    <Check className="w-5 h-5" />
                                </div>
                                <span className="text-sm font-medium text-on-surface-variant">
                                    Selesai
                                </span>
                            </div>
                        </div>
                    </div>
                    <div className="space-y-6">
                        <div className="bg-surface-container-lowest p-6 rounded-2xl shadow-subtle group hover:bg-primary transition-all duration-300">
                            <div className="flex items-center justify-between mb-4">
                                <div className="p-2 bg-primary/5 rounded-lg group-hover:bg-white/20">
                                    <Calendar className="w-5 h-5 text-primary group-hover:text-white" />
                                </div>
                                <span className="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant group-hover:text-white/60">
                                    Tenggat Waktu
                                </span>
                            </div>
                            <p className="text-xs text-on-surface-variant group-hover:text-white/80">
                                Tanggal Pendaftaran
                            </p>
                            <h4 className="text-xl font-headline font-extrabold text-primary group-hover:text-white mt-1">
                                15 Juli 2024
                            </h4>
                        </div>
                        <div className="bg-surface-container-lowest p-6 rounded-2xl shadow-subtle">
                            <div className="flex items-center justify-between mb-4">
                                <div className="p-2 bg-secondary-container/5 rounded-lg">
                                    <ShieldCheck className="w-5 h-5 text-secondary-container" />
                                </div>
                                <span className="px-3 py-1 bg-secondary-container/10 text-secondary-container rounded-full text-[10px] font-bold uppercase">
                                    Pending
                                </span>
                            </div>
                            <p className="text-xs text-on-surface-variant">Status Verifikasi</p>
                            <h4 className="text-xl font-headline font-extrabold text-primary mt-1">
                                Menunggu Review
                            </h4>
                        </div>
                    </div>
                </div>

                <section className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    {[
                        { label: 'Tanya CS', icon: Headphones },
                        { label: 'Panduan Tes', icon: BookOpen },
                        { label: 'Cek Tagihan', icon: Wallet },
                        { label: 'Jadwal', icon: CalendarDays },
                    ].map((action, idx) => (
                        <button
                            key={idx}
                            className="bg-white p-6 rounded-xl shadow-sm flex flex-col items-center justify-center text-center gap-3 border border-transparent hover:border-primary/20 hover:shadow-md transition-all"
                        >
                            <div className="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary group-hover:bg-primary transition-all">
                                <action.icon className="w-6 h-6" />
                            </div>
                            <span className="text-xs font-bold text-primary uppercase tracking-wider">
                                {action.label}
                            </span>
                        </button>
                    ))}
                </section>
            </div>
        </div>
    );
};

const FormStep1View = ({ setView }: { setView: (v: View) => void }) => {
    return (
    <div className="ml-65 flex-1 min-h-screen">
            <Header title="Formulir Pendaftaran" />
            <div className="max-w-5xl mx-auto p-10 pb-24">
                <div className="flex items-center justify-between mb-12 relative px-4">
                    <div className="absolute top-1/2 left-0 w-full h-0.5 bg-surface-container-high -translate-y-1/2 -z-10"></div>
                    <div className="flex flex-col items-center gap-3 bg-[#f7f9fc] px-4">
                        <div className="w-10 h-10 rounded-full bg-secondary-container text-white flex items-center justify-center font-bold shadow-lg">
                            1
                        </div>
                        <span className="text-xs font-bold text-primary uppercase tracking-widest">
                            Data Pribadi
                        </span>
                    </div>
                    <div className="flex flex-col items-center gap-3 bg-[#f7f9fc] px-4">
                        <div className="w-10 h-10 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center font-bold">
                            2
                        </div>
                        <span className="text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                            Akademik
                        </span>
                    </div>
                    <div className="flex flex-col items-center gap-3 bg-[#f7f9fc] px-4">
                        <div className="w-10 h-10 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center font-bold">
                            3
                        </div>
                        <span className="text-xs font-bold text-on-surface-variant uppercase tracking-widest">
                            Konfirmasi
                        </span>
                    </div>
                </div>

                <div className="bg-surface-container-lowest rounded-2xl shadow-subtle overflow-hidden">
                    <div className="p-10">
                        <div className="mb-10">
                            <h1 className="text-2xl font-headline font-bold text-primary">
                                Data Pribadi
                            </h1>
                            <div className="h-1 w-16 bg-primary mt-2 rounded-full"></div>
                        </div>

                        <form className="space-y-8">
                            <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
                                <div className="lg:col-span-1">
                                    <div className="flex flex-col items-center p-6 bg-surface-container-low rounded-xl border-2 border-dashed border-outline-variant/30">
                                        <div className="w-40 h-52 bg-white rounded-lg mb-4 shadow-inner overflow-hidden relative group cursor-pointer">
                                            <div className="absolute inset-0 flex items-center justify-center text-slate-300">
                                                <Camera className="w-12 h-12" />
                                            </div>
                                            <div className="absolute inset-0 bg-primary/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <Upload className="text-white w-8 h-8" />
                                            </div>
                                        </div>
                                        <p className="text-[10px] text-center text-on-surface-variant leading-relaxed mb-4 font-medium uppercase tracking-wider">
                                            Upload Pas Foto Formal (3x4)
                                            <br />
                                            Max size 2MB, format JPG/PNG
                                        </p>
                                        <button
                                            type="button"
                                            className="px-5 py-2.5 bg-surface-container-highest text-primary text-xs font-bold rounded-lg hover:bg-primary hover:text-white transition-all"
                                        >
                                            Pilih Foto
                                        </button>
                                    </div>
                                </div>
                                <div className="lg:col-span-2 space-y-6">
                                    <div className="space-y-2">
                                        <label className="text-xs font-bold text-primary uppercase tracking-wider">
                                            Nama Lengkap
                                        </label>
                                        <input
                                            className="w-full p-4 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary focus:bg-white transition-all font-medium"
                                            defaultValue="Budi Santoso"
                                        />
                                        <span className="text-[10px] text-red-500 font-bold flex items-center gap-1">
                                            <AlertCircle className="w-3 h-3" /> Wajib diisi sesuai identitas
                                            resmi
                                        </span>
                                    </div>
                                    <div className="space-y-2">
                                        <label className="text-xs font-bold text-primary uppercase tracking-wider">
                                            Alamat Sesuai KTP
                                        </label>
                                        <textarea
                                            className="w-full p-4 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary focus:bg-white transition-all font-medium"
                                            rows={3}
                                            defaultValue="Jl. Merdeka No. 45, Jakarta Selatan"
                                        />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div className="bg-surface-container-low p-8 flex items-center justify-between">
                        <button
                            onClick={() => setView('dashboard')}
                            className="flex items-center gap-2 px-8 py-4 bg-white text-primary font-bold rounded-xl shadow-sm hover:bg-slate-50 transition-all border border-primary/10"
                        >
                            <ArrowLeft className="w-5 h-5" /> Kembali
                        </button>
                        <button
                            onClick={() => setView('form-step2')}
                            className="flex items-center gap-2 px-10 py-4 bg-secondary-container text-white font-bold rounded-xl shadow-lg shadow-secondary-container/20 hover:scale-[1.02] transition-all"
                        >
                            Simpan & Lanjut <ArrowRight className="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

const PDFView = () => {
    return (
    <div className="ml-65 flex-1 min-h-screen">
            <Header title="E-Sertifikat & Bukti" />
            <section className="p-10 max-w-6xl mx-auto">
                <div className="mb-12">
                    <h1 className="text-4xl font-extrabold text-primary mb-2 tracking-tight">
                        Bukti Pendaftaran Resmi
                    </h1>
                    <p className="text-on-surface-variant text-lg">
                        Silakan unduh dan simpan kartu bukti pendaftaran Anda sebagai syarat
                        verifikasi dokumen fisik.
                    </p>
                </div>

                <div className="grid grid-cols-12 gap-8">
                    <div className="col-span-12 lg:col-span-5 space-y-6">
                        <div className="bg-surface-container-lowest p-8 rounded-2xl shadow-subtle">
                            <h3 className="text-xl font-bold text-primary mb-6 flex items-center gap-2">
                                <Info className="text-secondary-container w-6 h-6" /> Panduan Penting
                            </h3>
                            <ul className="space-y-6">
                                {[
                                    'Pastikan seluruh data yang tertera pada kartu bukti pendaftaran sudah benar dan valid.',
                                    'Cetak kartu ini menggunakan kertas HVS A4 minimal 80 gram untuk kualitas terbaik.',
                                    'Bawa kartu ini beserta dokumen pendukung saat melakukan verifikasi luring di kampus.',
                                ].map((txt, idx) => (
                                    <li key={idx} className="flex gap-4">
                                        <div className="shrink-0 w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                            {idx + 1}
                                        </div>
                                        <p className="text-on-surface-variant text-sm leading-relaxed">
                                            {txt}
                                        </p>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div className="bg-primary p-8 rounded-2xl text-white shadow-xl flex flex-col items-center text-center">
                            <div className="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mb-6">
                                <FileDown className="w-10 h-10 text-secondary-container" />
                            </div>
                            <h3 className="text-xl font-bold mb-3">Siap untuk diunduh</h3>
                            <p className="text-white/70 text-sm mb-8">
                                Format file PDF (2.4 MB). Dokumen ini telah ditandatangani secara
                                elektronik oleh Bagian Admisi.
                            </p>
                            <button className="w-full py-4 bg-secondary-container hover:bg-secondary-container/90 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-3">
                                <FileDown className="w-6 h-6" /> Unduh Bukti Pendaftaran (PDF)
                            </button>
                        </div>
                    </div>
                    <div className="col-span-12 lg:col-span-7">
                        <div className="bg-surface-container-high p-4 rounded-2xl">
                            <div className="bg-white rounded-xl shadow-lg aspect-[1/1.414] flex flex-col overflow-hidden">
                                <div className="bg-primary p-8 text-white flex justify-between items-center">
                                    <div className="flex items-center gap-4">
                                        <div className="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                                            <School className="text-primary w-8 h-8" />
                                        </div>
                                        <div>
                                            <h4 className="font-bold text-lg leading-tight uppercase">
                                                Kartu Tanda Peserta
                                            </h4>
                                            <p className="text-xs text-white/70">PMB TA 2024/2025</p>
                                        </div>
                                    </div>
                                    <div className="text-right">
                                        <p className="text-[10px] uppercase font-bold text-secondary-container">
                                            No. Pendaftaran
                                        </p>
                                        <p className="text-xl font-mono font-bold">PMB-2024-00128</p>
                                    </div>
                                </div>
                                <div className="p-10 flex-1 flex flex-col">
                                    <div className="flex gap-10 mb-10">
                                        <div className="w-40 h-52 bg-slate-100 rounded border border-slate-200 flex flex-col items-center justify-center">
                                            <User className="w-16 h-16 text-slate-300" />
                                        </div>
                                        <div className="flex-1 space-y-6">
                                            <div className="border-b border-slate-100 pb-2">
                                                <p className="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                                    Nama Lengkap
                                                </p>
                                                <p className="text-lg font-bold text-primary">
                                                    Budi Santoso
                                                </p>
                                            </div>
                                            <div className="border-b border-slate-100 pb-2">
                                                <p className="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                                    Pilihan Prodi
                                                </p>
                                                <p className="text-md font-semibold text-primary">
                                                    Teknik Informatika (S1)
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="mt-auto flex justify-between items-end border-t border-slate-100 pt-8">
                                        <div className="flex flex-col items-center">
                                            <div className="w-20 h-20 bg-slate-50 flex items-center justify-center rounded">
                                                <Share2 className="text-slate-200 w-12 h-12" />
                                            </div>
                                            <p className="text-[8px] text-slate-400 mt-2 uppercase">
                                                Official Verification QR
                                            </p>
                                        </div>
                                        <div className="text-center">
                                            <p className="text-[10px] text-slate-400 mb-8 italic">
                                                Jakarta, 15 April 2024
                                            </p>
                                            <p className="text-xs font-bold text-primary underline">
                                                Panitia Admisi PMB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};

// --- Main App ---

export default function App() {
    const [view, setView] = useState<View>('login');

    return (
        <div className="min-h-screen text-on-surface">
            <AnimatePresence mode="wait">
                <motion.div
                    key={view}
                    initial={{ opacity: 0, x: view === 'login' || view === 'register' ? 0 : 20 }}
                    animate={{ opacity: 1, x: 0 }}
                    exit={{ opacity: 0, x: view === 'login' || view === 'register' ? 0 : -20 }}
                    transition={{ duration: 0.3 }}
                    className="min-h-screen"
                >
                    {view === 'login' && <LoginView setView={setView} />}
                    {view === 'register' && <RegisterView setView={setView} />}

                    {view !== 'login' && view !== 'register' && (
                        <div className="flex">
                            <Sidebar currentView={view} setView={setView} />
                            {view === 'dashboard' && <DashboardView setView={setView} />}
                            {view === 'form-step1' && <FormStep1View setView={setView} />}
                            {view === 'form-step2' && (
                                <div className="ml-65 flex-1 flex flex-col min-h-screen">
                                    <Header title="Unggah Dokumen" />
                                    <div className="p-10 text-center">
                                        <h2 className="text-2xl font-bold">
                                            Layar Unggah Dokumen (Step 2)
                                        </h2>
                                        <p className="mt-4 text-slate-500">
                                            Fitur ini sedang dikembangkan untuk demo ini.
                                        </p>
                                        <button
                                            onClick={() => setView('form-step1')}
                                            className="mt-6 text-primary font-bold"
                                        >
                                            Kembali
                                        </button>
                                    </div>
                                </div>
                            )}
                            {view === 'status' && (
                                <div className="ml-65 flex-1 flex flex-col min-h-screen">
                                    <Header title="Status Pendaftaran" />
                                    <div className="p-10 text-center">
                                        <h2 className="text-2xl font-bold">Layar Status</h2>
                                        <p className="mt-4 text-slate-500">
                                            Menampilkan timeline pendaftaran.
                                        </p>
                                    </div>
                                </div>
                            )}
                            {view === 'pdf' && <PDFView />}
                        </div>
                    )}
                </motion.div>
            </AnimatePresence>
        </div>
    );
}
