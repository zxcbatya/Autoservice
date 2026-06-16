@php use App\Support\SiteImages; @endphp
<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Автосервис в Югорске — диагностика, ТО, ремонт двигателя и ходовой. Профессиональное оборудование, гарантия на работы."/>
    <title>СТО мастер — автосервис в Югорске</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Manrope', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: { 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 900: '#7f1d1d' },
                        surface: { 800: '#1a1d24', 900: '#12151a', 950: '#0c0e12' }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --brand-glow: rgba(239, 68, 68, 0.35);
        }

        .text-gradient {
            background: linear-gradient(135deg, #fca5a5 0%, #ef4444 50%, #b91c1c 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-bg {
            background-image: url('{{ $images['hero'] }}');
            background-size: cover;
            background-position: center 35%;
            animation: heroKenBurns 24s ease-in-out infinite alternate;
        }

        @keyframes heroKenBurns {
            from { transform: scale(1); }
            to { transform: scale(1.06); }
        }

        .img-cover { object-fit: cover; width: 100%; height: 100%; }

        .card-image-wrap {
            position: relative;
            overflow: hidden;
        }

        .card-image-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(12, 14, 18, 0.92) 0%, rgba(12, 14, 18, 0.2) 55%, transparent 100%);
            pointer-events: none;
        }

        .card-image-wrap img {
            transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .service-card:hover .card-image-wrap img {
            transform: scale(1.06);
        }

        .section-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(239, 68, 68, 0.06) 1px, transparent 0);
            background-size: 28px 28px;
        }

        .glass {
            background: rgba(18, 21, 26, 0.72);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .swiper-button-next, .swiper-button-prev {
            color: #ef4444;
            width: 48px;
            height: 48px;
            background: rgba(18, 21, 26, 0.85);
            border-radius: 50%;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 20px;
            font-weight: bold;
        }

        .swiper-pagination-bullet-active { background: #ef4444; }

        .services-slider-wrap .swiper-button-prev { left: 0; }
        .services-slider-wrap .swiper-button-next { right: 0; }
        .services-slider-wrap .swiper-button-prev,
        .services-slider-wrap .swiper-button-next { top: 42%; }

        .toast-container {
            position: fixed;
            top: 88px;
            right: 20px;
            z-index: 1050;
        }

        .toast {
            background: linear-gradient(135deg, #166534, #15803d);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .advantage-card {
            background: linear-gradient(160deg, rgba(26, 29, 36, 0.95) 0%, rgba(18, 21, 26, 0.98) 100%);
        }
    </style>
</head>
<body class="bg-surface-950 text-gray-200 font-sans antialiased">

<nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-white/5">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-[72px]">
            <a href="#home" class="flex items-center gap-3 shrink-0 group">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-700/20 border border-brand-600/40 text-brand-500 group-hover:bg-brand-700/30 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <span class="text-xl font-extrabold tracking-tight text-white">СТО <span class="text-gradient">мастер</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8 text-[15px] font-medium">
                <a href="#about" class="text-gray-400 hover:text-white transition-colors">О нас</a>
                <a href="#services" class="text-gray-400 hover:text-white transition-colors">Услуги</a>
                <a href="#advantages" class="text-gray-400 hover:text-white transition-colors">Преимущества</a>
                <a href="#reviews" class="text-gray-400 hover:text-white transition-colors">Отзывы</a>
                <a href="#contacts" class="text-gray-400 hover:text-white transition-colors">Контакты</a>
            </div>

            <div class="hidden lg:flex items-center gap-5">
                <a href="tel:+79323317777" class="font-semibold text-white hover:text-red-400 transition-colors whitespace-nowrap">+7 (932) 331-77-77</a>
                <a href="#contact-form" class="inline-flex items-center justify-center bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-brand-900/40 transition-all hover:scale-[1.02]">
                    Записаться
                </a>
            </div>

            <button id="menuToggle" class="lg:hidden text-white p-2 rounded-lg hover:bg-white/5" aria-label="Меню">
                <svg id="menuIconOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="menuIconClose" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    <div id="mobileMenu" class="hidden lg:hidden border-t border-white/5 bg-surface-950/98">
        <div class="container mx-auto px-4 py-4 space-y-1">
            <a href="#about" class="block py-2.5 text-gray-300 hover:text-white">О нас</a>
            <a href="#services" class="block py-2.5 text-gray-300 hover:text-white">Услуги</a>
            <a href="#advantages" class="block py-2.5 text-gray-300 hover:text-white">Преимущества</a>
            <a href="#reviews" class="block py-2.5 text-gray-300 hover:text-white">Отзывы</a>
            <a href="#contacts" class="block py-2.5 text-gray-300 hover:text-white">Контакты</a>
            <a href="#contact-form" class="mt-3 block text-center bg-brand-600 text-white py-3 rounded-xl font-bold">Записаться на сервис</a>
        </div>
    </div>
</nav>

<main class="pt-[72px]">

    {{-- Hero --}}
    <section id="home" class="relative min-h-[92vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 hero-bg will-change-transform"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-surface-950 via-surface-950/85 to-surface-950/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-surface-950 via-transparent to-surface-950/30"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-600/50 to-transparent"></div>

        <div class="container mx-auto px-4 relative z-10 py-16 lg:py-24">
            <div class="max-w-3xl">
                <p class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-widest text-red-400 mb-6">
                    <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Автосервис в Югорске
                </p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-[1.1] tracking-tight mb-6">
                    Надёжный ремонт<br class="hidden sm:block"/> и обслуживание авто
                </h1>
                <p class="text-lg sm:text-xl text-gray-300/90 leading-relaxed mb-10 max-w-xl">
                    Диагностика, плановое ТО, ремонт двигателя, ходовой и электрики. Профессиональное оборудование и прозрачные цены.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#contact-form" class="inline-flex justify-center items-center bg-brand-600 hover:bg-brand-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl shadow-brand-900/50 transition-all hover:scale-[1.02]">
                        Рассчитать стоимость
                    </a>
                    <a href="#services" class="inline-flex justify-center items-center border border-white/20 hover:border-white/40 text-white px-8 py-4 rounded-xl font-semibold transition-colors bg-white/5 hover:bg-white/10">
                        Смотреть услуги
                    </a>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-2 lg:grid-cols-4 gap-4 max-w-4xl">
                @foreach([
                    ['10+', 'лет опыта мастеров'],
                    ['2 года', 'гарантия на работы'],
                    ['7/7', 'без выходных'],
                    ['100%', 'согласование цены'],
                ] as [$value, $label])
                    <div class="glass rounded-2xl px-5 py-4 border border-white/5">
                        <div class="text-2xl lg:text-3xl font-extrabold text-white">{{ $value }}</div>
                        <div class="text-sm text-gray-400 mt-1">{{ $label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- О мастерской --}}
    <section id="about" class="py-24 bg-surface-900 section-pattern relative">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <p class="text-brand-500 font-semibold text-sm uppercase tracking-widest mb-3">О нас</p>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-6 leading-tight">
                        Современная мастерская<br/> с вниманием к деталям
                    </h2>
                    <p class="text-gray-400 leading-relaxed mb-4">
                        «СТО мастер» — полноценный автосервис в Югорске. Работаем с легковыми автомобилями всех марок: от планового ТО до сложного ремонта узлов.
                    </p>
                    <p class="text-gray-400 leading-relaxed mb-8">
                        В работе используем диагностическое оборудование, качественные расходники и оригинальные запчасти по согласованию с клиентом.
                    </p>
                    <ul class="space-y-3">
                        @foreach(['Компьютерная диагностика', 'Прозрачная смета до начала работ', 'Удобная запись по телефону'] as $item)
                            <li class="flex items-center gap-3 text-gray-300">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-700/30 text-brand-500 text-xs">✓</span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="grid grid-cols-12 gap-3 sm:gap-4">
                    <div class="col-span-7 row-span-2 min-h-[280px] sm:min-h-[360px] rounded-2xl overflow-hidden shadow-2xl ring-1 ring-white/10">
                        <img src="{{ $images['workshop'] }}" alt="Автосервис — рабочая зона" class="img-cover" loading="lazy" width="600" height="400"/>
                    </div>
                    <div class="col-span-5 min-h-[130px] sm:min-h-[170px] rounded-2xl overflow-hidden shadow-xl ring-1 ring-white/10">
                        <img src="{{ $images['mechanic'] }}" alt="Мастер за работой" class="img-cover" loading="lazy" width="400" height="300"/>
                    </div>
                    <div class="col-span-5 min-h-[130px] sm:min-h-[170px] rounded-2xl overflow-hidden shadow-xl ring-1 ring-white/10">
                        <img src="{{ $images['engine'] }}" alt="Ремонт двигателя" class="img-cover" loading="lazy" width="400" height="300"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Услуги --}}
    <section id="services" class="py-24 bg-surface-950 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-[0.07] hidden lg:block pointer-events-none">
            <img src="{{ $images['diagnostics'] }}" alt="" class="img-cover" aria-hidden="true"/>
        </div>
        <div class="container mx-auto px-4 relative">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-brand-500 font-semibold text-sm uppercase tracking-widest mb-3">Услуги</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gradient">Наши ключевые услуги</h2>
                <p class="text-gray-400 mt-4">Решаем типовые и нестандартные задачи — подберём оптимальный вариант ремонта под ваш автомобиль.</p>
            </div>

            <div class="services-slider-wrap relative px-0 lg:px-14">
            <div class="swiper services-slider pb-4">
                <div class="swiper-wrapper">
                    @forelse($services as $service)
                        <div class="swiper-slide service-card group">
                            <article class="h-full flex flex-col bg-surface-800/80 rounded-2xl border border-white/5 overflow-hidden hover:border-brand-600/30 transition-colors shadow-xl">
                                <div class="card-image-wrap aspect-[16/10] relative">
                                    <img src="{{ SiteImages::forService($service) }}" alt="{{ $service->name }}" class="img-cover absolute inset-0" loading="lazy"/>
                                    <div class="absolute bottom-0 left-0 right-0 p-5 z-10">
                                        <h3 class="text-xl font-bold text-white">{{ $service->name }}</h3>
                                    </div>
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <p class="text-gray-400 text-sm leading-relaxed flex-grow mb-5">{{ $service->description }}</p>
                                    <div class="flex items-center justify-between pt-4 border-t border-white/5">
                                        <span class="text-xs uppercase tracking-wider text-gray-500">от</span>
                                        <span class="text-2xl font-extrabold text-white">{{ number_format((int)$service->price, 0, ',', ' ') }} <span class="text-base font-semibold text-gray-400">₽</span></span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="swiper-slide col-span-3 text-center text-gray-500 py-12">Услуги скоро появятся</div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-10"></div>
            </div>

            <button type="button" class="services-slider-prev swiper-button-prev !hidden lg:!flex" aria-label="Предыдущая услуга"></button>
            <button type="button" class="services-slider-next swiper-button-next !hidden lg:!flex" aria-label="Следующая услуга"></button>
            </div>

            <p class="text-center mt-12">
                <a href="#contact-form" class="inline-flex items-center gap-2 text-brand-500 hover:text-white font-semibold transition-colors">
                    Не нашли нужную услугу? Получить консультацию
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </p>
        </div>
    </section>

    {{-- Преимущества --}}
    <section id="advantages" class="py-24 relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ $images['workshop'] }}" alt="" class="img-cover opacity-[0.12]" aria-hidden="true"/>
            <div class="absolute inset-0 bg-surface-900/92"></div>
        </div>
        <div class="container mx-auto px-4 relative">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-brand-500 font-semibold text-sm uppercase tracking-widest mb-3">Почему мы</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Почему нам доверяют</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                @php
                    $advantages = [
                        ['img' => $images['engine'], 'title' => 'Гарантия 2 года', 'text' => 'Официальная гарантия на выполненные работы и установленные запчасти.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                        ['img' => $images['mechanic'], 'title' => 'Опытные мастера', 'text' => 'Специалисты с опытом от 5 лет и регулярным повышением квалификации.', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.28-1.25-.743-1.67a5.002 5.002 0 00-4.514 0A2.002 2.002 0 007 18v2m10 0H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.28-1.25.743-1.67a5.002 5.002 0 014.514 0A2.002 2.002 0 0117 18v2m-4-6a4 4 0 100-8 4 4 0 000 8z'],
                        ['img' => $images['tires'], 'title' => 'Честные цены', 'text' => 'Согласовываем стоимость до начала работ. Без скрытых платежей.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ];
                @endphp
                @foreach($advantages as $adv)
                    <article class="advantage-card rounded-2xl overflow-hidden border border-white/5 hover:border-brand-600/25 transition-all group">
                        <div class="relative h-44 overflow-hidden">
                            <img src="{{ $adv['img'] }}" alt="{{ $adv['title'] }}" class="img-cover group-hover:scale-105 transition-transform duration-700" loading="lazy"/>
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-900 to-transparent"></div>
                            <div class="absolute bottom-4 left-5 flex h-11 w-11 items-center justify-center rounded-xl bg-brand-600/90 text-white shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $adv['icon'] }}"/></svg>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $adv['title'] }}</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">{{ $adv['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Отзывы --}}
    <section id="reviews" class="py-24 bg-surface-950 relative" x-data="{ showModal: false }">
        <div class="absolute inset-0 opacity-[0.06]">
            <img src="{{ $images['contact'] }}" alt="" class="img-cover" aria-hidden="true"/>
        </div>
        <div class="container mx-auto px-4 relative">
            <div class="text-center mb-14">
                <p class="text-brand-500 font-semibold text-sm uppercase tracking-widest mb-3">Отзывы</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gradient">Что говорят клиенты</h2>
            </div>

            <div class="swiper reviews-slider">
                <div class="swiper-wrapper" id="reviews-list">
                    @forelse($reviews as $review)
                        <div class="swiper-slide h-auto">
                            <blockquote class="h-full bg-surface-800/90 p-7 rounded-2xl border border-white/5 flex flex-col">
                                <div class="flex items-center gap-1 mb-4">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-amber-400 text-lg">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <p class="text-gray-300 leading-relaxed flex-grow mb-6">«{{ $review->message }}»</p>
                                <footer class="flex items-center gap-3 pt-4 border-t border-white/5">
                                    <div class="h-10 w-10 rounded-full bg-brand-700/40 flex items-center justify-center text-brand-400 font-bold text-sm">
                                        {{ mb_substr($review->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <cite class="not-italic font-bold text-white block">{{ $review->name }}</cite>
                                        @if($review->car)
                                            <span class="text-gray-500 text-sm">{{ $review->car }}</span>
                                        @endif
                                    </div>
                                </footer>
                            </blockquote>
                        </div>
                    @empty
                        <div class="swiper-slide text-center text-gray-500 py-12">Пока нет отзывов — будьте первым!</div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-10"></div>
            </div>

            <p class="text-center mt-12">
                <button @click="showModal = true" type="button"
                        class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-brand-900/40 transition-all hover:scale-[1.02]">
                    Оставить отзыв
                </button>
            </p>
        </div>

        {{-- Modal --}}
        <div x-show="showModal" x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4" style="display: none;">
            <div @click.away="showModal = false" class="bg-surface-800 rounded-2xl shadow-2xl w-full max-w-lg p-8 border border-white/10">
                <h3 class="text-2xl font-bold text-white text-center mb-6">Ваш отзыв</h3>
                @if(session('success'))
                    <div class="bg-green-600/20 border border-green-500/30 text-green-300 p-4 rounded-xl mb-6">{{ session('success') }}</div>
                @endif
                <form id="review-form" action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="review_name" class="block text-sm font-medium text-gray-400 mb-1">Ваше имя</label>
                        <input type="text" id="review_name" name="name" required class="w-full bg-surface-950 border border-white/10 text-white rounded-xl p-3 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"/>
                    </div>
                    <div>
                        <label for="review_car" class="block text-sm font-medium text-gray-400 mb-1">Автомобиль</label>
                        <input type="text" id="review_car" name="car" placeholder="Kia Rio" class="w-full bg-surface-950 border border-white/10 text-white rounded-xl p-3 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Оценка</label>
                        <div class="flex flex-row-reverse justify-end gap-1">
                            @for($s = 5; $s >= 1; $s--)
                                <input id="star{{ $s }}" name="rating" type="radio" value="{{ $s }}" class="peer sr-only" @if($s===5) checked @endif>
                                <label for="star{{ $s }}" class="text-gray-600 peer-hover:text-amber-400 peer-checked:text-amber-400 cursor-pointer text-3xl transition-colors">★</label>
                            @endfor
                        </div>
                    </div>
                    <div>
                        <label for="review_message" class="block text-sm font-medium text-gray-400 mb-1">Текст отзыва</label>
                        <textarea id="review_message" name="message" rows="4" required class="w-full bg-surface-950 border border-white/10 text-white rounded-xl p-3 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"></textarea>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <button type="button" @click="showModal = false" id="review-modal-cancel-button" class="text-gray-500 hover:text-white">Отмена</button>
                        <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-3 rounded-xl font-bold">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- Контакты --}}
    <section id="contacts" class="py-24 bg-surface-900">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-brand-500 font-semibold text-sm uppercase tracking-widest mb-3">Контакты</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Запись на сервис</h2>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <div class="bg-surface-950 rounded-2xl border border-white/5 overflow-hidden flex flex-col">
                    <div class="relative h-48 sm:h-56 shrink-0">
                        <img src="{{ $images['contact'] }}" alt="Автосервис" class="img-cover"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-surface-950 to-transparent"></div>
                        <div class="absolute bottom-5 left-6">
                            <h3 class="text-2xl font-bold text-white">Наш автосервис</h3>
                        </div>
                    </div>
                    <div class="p-8 space-y-6 flex-grow">
                        <div class="flex gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-700/25 text-brand-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div>
                                <h4 class="font-bold text-white">Адрес</h4>
                                <p class="text-gray-400 text-sm mt-1">г. Югорск, ул. Гастало, д. 31, средний бокс</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-700/25 text-brand-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <div>
                                <h4 class="font-bold text-white">Время работы</h4>
                                <p class="text-gray-400 text-sm mt-1">Пн–Вс: 9:00 – 21:00</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-700/25 text-brand-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div>
                                <h4 class="font-bold text-white">Телефон</h4>
                                <a href="tel:+79323317777" class="text-brand-400 hover:text-white font-semibold transition-colors">+7 (932) 331-77-77</a>
                            </div>
                        </div>
                    </div>
                    <div class="aspect-video mx-8 mb-8 rounded-xl overflow-hidden border border-white/10 ring-1 ring-white/5">
                        <iframe src="https://yandex.ru/map-widget/v1/?ll=63.302046%2C61.323981&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgoyMTU3MTU3MDc2EokB0KDQvtGB0YHQuNGPLCDQpdCw0L3RgtGLLdCc0LDQvdGB0LjQudGB0LrQuNC5INCw0LLRgtC-0L3QvtC80L3Ri9C5INC-0LrRgNGD0LMg4oCUINCu0LPRgNCwLCDQrtCz0L7RgNGB0LosINGD0LvQuNGG0LAg0JPQsNGB0YLQtdC70LvQviwgMzEiCg0GNX1CFbtLdUI%2C&source=serp_navig&z=19.01" class="w-full h-full border-0" allowfullscreen loading="lazy" title="Карта — СТО мастер"></iframe>
                    </div>
                </div>

                <div id="contact-form" class="bg-surface-950 rounded-2xl border border-white/5 p-8">
                    <h3 class="text-2xl font-bold text-white mb-2">Заявка на ремонт</h3>
                    <p class="text-gray-500 text-sm mb-6">Перезвоним в течение рабочего дня</p>
                    <form id="lead-form" action="/lead" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-400 mb-1">Ваше имя</label>
                            <input type="text" id="name" name="name" required class="w-full bg-surface-900 border border-white/10 text-white rounded-xl p-3 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"/>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-400 mb-1">Телефон</label>
                            <input type="tel" id="phone" name="phone" required class="w-full bg-surface-900 border border-white/10 text-white rounded-xl p-3 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"/>
                        </div>
                        <div>
                            <label for="car" class="block text-sm font-medium text-gray-400 mb-1">Автомобиль</label>
                            <input type="text" id="car" name="car" class="w-full bg-surface-900 border border-white/10 text-white rounded-xl p-3 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"/>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-400 mb-1">Опишите проблему</label>
                            <textarea id="message" name="message" rows="4" required class="w-full bg-surface-900 border border-white/10 text-white rounded-xl p-3 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-brand-900/40 transition-all hover:scale-[1.01]">
                            Отправить заявку
                        </button>
                        <p class="text-xs text-gray-600 text-center">Нажимая кнопку, вы соглашаетесь на обработку персональных данных.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="bg-surface-950 border-t border-white/5 py-8">
    <div class="container mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
        <div>
            <p class="font-bold text-white">СТО мастер</p>
            <p class="text-gray-600 text-sm mt-1">&copy; {{ date('Y') }} Все права защищены.</p>
        </div>
        <p class="text-gray-600 text-xs max-w-sm">Информация на сайте не является публичной офертой. Фото: Unsplash (лицензия Unsplash).</p>
    </div>
</footer>

<div id="toast-container" class="toast-container"></div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const menuIconOpen = document.getElementById('menuIconOpen');
    const menuIconClose = document.getElementById('menuIconClose');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuIconOpen.classList.toggle('hidden');
        menuIconClose.classList.toggle('hidden');
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth' });
            if (!mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                menuIconOpen.classList.remove('hidden');
                menuIconClose.classList.add('hidden');
            }
        });
    });

    const servicesSlides = document.querySelectorAll('.services-slider .swiper-slide').length;
    if (servicesSlides > 0) {
        new Swiper('.services-slider', {
            loop: servicesSlides > 3,
            spaceBetween: 24,
            grabCursor: true,
            watchOverflow: true,
            autoplay: servicesSlides > 1 ? {
                delay: 4500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1280: { slidesPerView: 3 },
            },
            pagination: { el: '.services-slider .swiper-pagination', clickable: true },
            navigation: {
                nextEl: '.services-slider-next',
                prevEl: '.services-slider-prev',
            },
        });
    }

    const reviewsSwiper = new Swiper('.reviews-slider', {
        loop: true,
        spaceBetween: 24,
        autoplay: { delay: 5500, disableOnInteraction: false },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1280: { slidesPerView: 3 },
        },
        pagination: { el: '.reviews-slider .swiper-pagination', clickable: true },
    });

    const reviewForm = document.getElementById('review-form');
    if (reviewForm) {
        let isSubmitting = false;
        reviewForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;
            const submitBtn = reviewForm.querySelector('[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;
            const formData = new FormData(reviewForm);
            reviewForm.querySelectorAll('.text-red-500').forEach(el => el.remove());
            try {
                const response = await fetch(reviewForm.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': formData.get('_token') },
                    body: formData
                });
                const data = await response.json();
                if (response.ok) {
                    const newSlide = document.createElement('div');
                    newSlide.className = 'swiper-slide h-auto';
                    let stars = '';
                    for (let i = 1; i <= 5; i++) stars += `<span class="text-amber-400 text-lg">${i <= data.rating ? '★' : '☆'}</span>`;
                    newSlide.innerHTML = `
                        <blockquote class="h-full bg-surface-800/90 p-7 rounded-2xl border border-white/5 flex flex-col">
                            <div class="flex gap-1 mb-4">${stars}</div>
                            <p class="text-gray-300 leading-relaxed flex-grow mb-6">«${data.message}»</p>
                            <footer class="flex items-center gap-3 pt-4 border-t border-white/5">
                                <div class="h-10 w-10 rounded-full bg-brand-700/40 flex items-center justify-center text-brand-400 font-bold">${data.name.charAt(0)}</div>
                                <div><cite class="not-italic font-bold text-white">${data.name}</cite>${data.car ? `<span class="text-gray-500 text-sm block">${data.car}</span>` : ''}</div>
                            </footer>
                        </blockquote>`;
                    reviewsSwiper.appendSlide(newSlide);
                    reviewsSwiper.slideTo(reviewsSwiper.slides.length - 1);
                    reviewForm.reset();
                    showToast('Спасибо за ваш отзыв!');
                    document.getElementById('review-modal-cancel-button').click();
                } else if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const input = reviewForm.querySelector(`[name="${field}"]`);
                        if (input) {
                            const err = document.createElement('div');
                            err.className = 'text-red-500 text-sm mt-1';
                            err.innerText = messages[0];
                            input.parentNode.appendChild(err);
                        }
                    }
                }
            } catch {
                alert('Ошибка при отправке отзыва.');
            } finally {
                isSubmitting = false;
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    }

    const leadForm = document.getElementById('lead-form');
    if (leadForm) {
        let isSubmitting = false;
        leadForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;
            const submitBtn = leadForm.querySelector('[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;
            leadForm.querySelectorAll('.text-red-500').forEach(el => el.remove());
            const formData = new FormData(leadForm);
            try {
                const response = await fetch(leadForm.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': formData.get('_token') },
                    body: formData
                });
                const data = await response.json();
                if (response.ok) {
                    leadForm.reset();
                    showToast('Ваша заявка успешно отправлена!');
                } else if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const input = leadForm.querySelector(`[name="${field}"]`);
                        if (input) {
                            const err = document.createElement('div');
                            err.className = 'text-red-500 text-sm mt-1';
                            err.innerText = messages[0];
                            input.parentNode.appendChild(err);
                        }
                    }
                }
            } catch {
                showToast('Ошибка при отправке заявки.', 5000);
            } finally {
                isSubmitting = false;
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    }
});

function showToast(message, duration = 3000) {
    const container = document.getElementById('toast-container');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerText = message;
    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
        toast.classList.remove('show');
        toast.addEventListener('transitionend', () => toast.remove());
    }, duration);
}
</script>
</body>
</html>
