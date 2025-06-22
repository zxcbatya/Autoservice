<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>СТО мастер</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Основной градиент от бордового к темно-серому */
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, #b91c1c, #7f1d1d);
        }

        /* Бордовый градиент для текста */
        .text-gradient {
            background-image: linear-gradient(to right, #ef4444, #b91c1c);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Акцентные кнопки */
        .btn-accent {
            background-image: linear-gradient(to right, #b91c1c, #be1212);
        }

        .btn-accent:hover {
            background-image: linear-gradient(to right, #7f1d1d, #9f1f1f);
        }

        /* Анимация слайдера */
        .slide-enter {
            transform: translateX(100%);
            opacity: 0;
        }

        .slide-enter.active {
            transform: translateX(0);
            opacity: 1;
            transition: all 0.5s ease-in-out;
        }

        /* Custom Swiper styles */
        .swiper-button-next,
        .swiper-button-prev {
            color: #ef4444;
            transition: transform 0.2s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            transform: scale(1.2);
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 44px;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(17, 24, 39, 0.5);
        }

        .swiper-pagination-bullet-active {
            background-color: #ef4444;
        }
        .toast-container {
            position: fixed;
            top: 80px; /* Отступ от шапки */
            right: 20px;
            z-index: 1050; /* Выше модального окна */
        }
        .toast {
            background-color: #2f855a; /* Tailwind green-700 */
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.5s ease-in-out;
        }
        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-200 font-sans">

<!-- Навигация -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-gray-900/80 backdrop-blur-md border-b border-red-900/30 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Логотип -->
            <a href="#home" class="text-2xl font-bold text-gradient flex items-center shrink-0">
                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                СТО мастер
            </a>

            <!-- Десктопное меню -->
            <div class="hidden md:flex items-center space-x-6 text-lg">
                <a href="#services" class="text-gray-300 hover:text-red-400 transition-colors">Услуги</a>
                <a href="#advantages" class="text-gray-300 hover:text-red-400 transition-colors">Преимущества</a>
                <a href="#reviews" class="text-gray-300 hover:text-red-400 transition-colors">Отзывы</a>
                <a href="#contacts" class="text-gray-300 hover:text-red-400 transition-colors">Контакты</a>
            </div>

            <!-- Контакты и CTA для десктопа -->
            <div class="hidden lg:flex items-center space-x-4">
                <a href="tel:+79323317777"
                   class="text-lg font-semibold text-white hover:text-red-400 transition-colors">+7 (932) 331-77-77</a>
                <a href="#contact-form"
                   class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-all transform hover:scale-105 shadow-lg text-lg font-bold">
                    Записаться на сервис
                </a>
            </div>

            <!-- Мобильное меню кнопка -->
            <button id="menuToggle" class="lg:hidden text-white p-2">
                <svg id="menuIconOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="menuIconClose" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    <!-- Мобильное меню -->
    <div id="mobileMenu" class="hidden lg:hidden bg-gray-900/95">
        <div class="container mx-auto px-4 pt-2 pb-4 space-y-3">
            <a href="#services"
               class="block w-full text-left nav-link text-gray-300 hover:text-red-400 transition-colors py-2">Услуги</a>
            <a href="#advantages"
               class="block w-full text-left nav-link text-gray-300 hover:text-red-400 transition-colors py-2">Преимущества</a>
            <a href="#reviews"
               class="block w-full text-left nav-link text-gray-300 hover:text-red-400 transition-colors py-2">Отзывы</a>
            <a href="#contacts"
               class="block w-full text-left nav-link text-gray-300 hover:text-red-400 transition-colors py-2">Контакты</a>
            <div class="border-t border-gray-700 pt-4 mt-2">
                <a href="#contact-form"
                   class="w-full text-center block bg-red-600 text-white px-5 py-3 rounded-lg hover:bg-red-700 transition-all font-bold">
                    Записаться на сервис
                </a>
            </div>
        </div>
    </div>
</nav>

<main class="pt-20">
    <!-- Главная секция -->
    <section id="home" class="min-h-[90vh] flex items-center bg-gray-800 relative overflow-hidden">
        <!-- ЗАМЕНИТЕ ЭТО ИЗОБРАЖЕНИЕ НА РЕАЛЬНОЕ ФОТО ВАШЕГО АВТОСЕРВИСА -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/images/XXXL.jpg') }}')"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/70 to-transparent"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-white leading-tight shadow-text">
                    Надежный ремонт автомобилей в Югорске
                </h1>
                <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Диагностика, плановое ТО, ремонт двигателя, ходовой и электрики. Используем профессиональное
                    оборудование и оригинальные запчасти.
                </p>
                <a href="#contact-form"
                   class="bg-red-600 text-white px-10 py-4 rounded-lg hover:bg-red-700 transition-all transform hover:scale-105 shadow-lg text-xl font-bold">
                    Рассчитать стоимость ремонта
                </a>
            </div>
        </div>
    </section>

    <!-- Секция Услуги -->
    <section id="services" class="py-20 bg-gray-900">
        <div class="container mx-auto px-4 relative">
            <h2 class="text-4xl font-bold text-center mb-12 text-gradient">
                Наши ключевые услуги
            </h2>

            <div class="swiper services-slider">
                <div class="swiper-wrapper">
@foreach($services as $service)
    <div class="swiper-slide bg-gray-800 p-6 rounded-xl border border-red-900/30 flex flex-col min-w-0">
        <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
        <h3 class="text-2xl font-bold mb-3 text-red-400 break-words">{{ $service->name }}</h3>
        <p class="text-gray-400 mb-4 flex-grow break-words">{{ $service->description }}</p>
        <p class="text-xl font-semibold text-white">от {{ (int)$service->price }} руб.</p>
    </div>
@endforeach
                </div>

                <div class="swiper-pagination mt-8 relative bottom-auto"></div>
            </div>

            <!-- Slider controls -->
            <div
                class="swiper-button-prev absolute top-1/2 -translate-y-1/2 left-0 hidden lg:flex items-center justify-center"></div>
            <div
                class="swiper-button-next absolute top-1/2 -translate-y-1/2 right-0 hidden lg:flex items-center justify-center"></div>

            <div class="text-center mt-16">
                <a href="#contact-form" class="text-red-400 hover:text-white text-lg font-semibold transition-colors">
                    Не нашли свою проблему? Свяжитесь с нами для консультации &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- Преимущества -->
    <section id="advantages" class="py-20 bg-gray-800 relative">
        <div
            class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1599469801908-78229b357a78?q=80&w=1974&auto=format&fit=crop')] bg-cover bg-center opacity-5"></div>
        <div class="container mx-auto px-4 relative">
            <h2 class="text-4xl font-bold text-center mb-12 text-gradient">
                Почему нам доверяют
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                <!-- Преимущество 1 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-red-900/30 rounded-full flex items-center justify-center mb-4 border-2 border-red-500">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-white">Гарантия 2 года</h3>
                    <p class="text-gray-400">Предоставляем официальную гарантию на все выполненные работы и
                        установленные запчасти.</p>
                </div>
                <!-- Преимущество 2 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-red-900/30 rounded-full flex items-center justify-center mb-4 border-2 border-red-500">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.28-1.25-.743-1.67a5.002 5.002 0 00-4.514 0A2.002 2.002 0 007 18v2M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.28-1.25.743-1.67a5.002 5.002 0 014.514 0A2.002 2.002 0 0117 18v2M12 14a4 4 0 100-8 4 4 0 000 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-white">Опытные мастера</h3>
                    <p class="text-gray-400">Наши специалисты имеют опыт работы от 5 лет и регулярно проходят повышение
                        квалификации.</p>
                </div>
                <!-- Преимущество 3 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 bg-red-900/30 rounded-full flex items-center justify-center mb-4 border-2 border-red-500">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-white">Честные цены</h3>
                    <p class="text-gray-400">Согласовываем стоимость работ до их начала. Никаких скрытых платежей и
                        навязанных услуг.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Секция Отзывы -->
    <section id="reviews" class="py-20 bg-gray-900 relative" x-data="{ showModal: false }">
        <div
            class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1581954754437-96825a17a94d?q=80&w=1932&auto=format&fit=crop')] bg-cover bg-center opacity-10"></div>
        <div class="container mx-auto px-4 relative">
            <h2 class="text-4xl font-bold text-center mb-12 text-gradient">
                Что говорят наши клиенты
            </h2>
            <div class="swiper reviews-slider">
                <div class="swiper-wrapper" id="reviews-list">
                    @forelse($reviews as $review)
                        <div class="swiper-slide bg-gray-800 p-6 rounded-xl border border-red-900/30">
                            <div class="flex items-center mb-2">
                                <span class="font-bold text-white mr-2">{{ $review->name }}</span>
                                @if($review->car)
                                    <span class="text-gray-400 text-sm">({{ $review->car }})</span>
                                @endif
                            </div>
                            <div class="flex items-center mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-yellow-400 text-lg">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <p class="text-gray-300 mb-0">{{ $review->message }}</p>
                        </div>
                    @empty
                        <div class="swiper-slide col-span-3 text-center text-gray-400">Пока нет отзывов</div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-8"></div>
            </div>
            <div class="text-center mt-12">
                <button @click="showModal = true"
                        class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-all transform hover:scale-105 shadow-lg text-lg font-bold">
                    Оставить отзыв
                </button>
            </div>
        </div>

        <!-- Модальное окно для отзыва -->
        <div
            x-show="showModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
            style="display: none;"
        >
            <div @click.away="showModal = false"
                 class="bg-gray-800 rounded-lg shadow-xl w-full max-w-lg mx-4 p-8 border border-red-900/50">
                <h3 class="text-2xl font-bold mb-6 text-white text-center">Ваш отзыв о нашей работе</h3>
                @if(session('success'))
                    <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                <form id="review-form" action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="review_name" class="block text-sm font-medium text-gray-300 mb-1">Ваше имя</label>
                        <input type="text" id="review_name" name="name" required
                               class="w-full bg-gray-900 border-gray-700 text-white rounded-md p-3 focus:border-red-500 focus:ring-red-500 transition">
                    </div>
                    <div>
                        <label for="review_car" class="block text-sm font-medium text-gray-300 mb-1">Марка и модель авто
                            (например, Kia Rio)</label>
                        <input type="text" id="review_car" name="car"
                               class="w-full bg-gray-900 border-gray-700 text-white rounded-md p-3 focus:border-red-500 focus:ring-red-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Ваша оценка</label>
                        <div class="flex flex-row-reverse justify-end items-center">
                            <input id="star5" name="rating" type="radio" value="5" class="peer sr-only"><label
                                for="star5"
                                class="text-gray-500 peer-hover:text-yellow-400 peer-checked:text-yellow-400 cursor-pointer text-4xl transition-colors">★</label>
                            <input id="star4" name="rating" type="radio" value="4" class="peer sr-only"><label
                                for="star4"
                                class="text-gray-500 peer-hover:text-yellow-400 peer-checked:text-yellow-400 cursor-pointer text-4xl transition-colors">★</label>
                            <input id="star3" name="rating" type="radio" value="3" class="peer sr-only"><label
                                for="star3"
                                class="text-gray-500 peer-hover:text-yellow-400 peer-checked:text-yellow-400 cursor-pointer text-4xl transition-colors">★</label>
                            <input id="star2" name="rating" type="radio" value="2" class="peer sr-only"><label
                                for="star2"
                                class="text-gray-500 peer-hover:text-yellow-400 peer-checked:text-yellow-400 cursor-pointer text-4xl transition-colors">★</label>
                            <input id="star1" name="rating" type="radio" value="1" class="peer sr-only"><label
                                for="star1"
                                class="text-gray-500 peer-hover:text-yellow-400 peer-checked:text-yellow-400 cursor-pointer text-4xl transition-colors">★</label>
                        </div>
                    </div>
                    <div>
                        <label for="review_message" class="block text-sm font-medium text-gray-300 mb-1">Текст
                            отзыва</label>
                        <textarea id="review_message" name="message" rows="4" required
                                  class="w-full bg-gray-900 border-gray-700 text-white rounded-md p-3 focus:border-red-500 focus:ring-red-500 transition"></textarea>
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <button type="button" @click="showModal = false" id="review-modal-cancel-button" class="text-gray-400 hover:text-white transition-colors">Отмена
                        </button>
                        <button type="submit"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-all font-bold">
                            Отправить отзыв
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Контакты и Форма -->
    <section id="contacts" class="py-20 bg-gray-800">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gradient">
                Контакты и запись на сервис
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Левая часть - Контактная информация -->
                <div class="bg-gray-900 p-8 rounded-xl border border-red-900/30">
                    <h3 class="text-3xl font-bold mb-6 text-white">Наш автосервис</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <svg class="w-7 h-7 text-red-400 mr-4 mt-1 shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <h4 class="font-bold text-lg text-white">Адрес:</h4>
                                <p class="text-gray-300">г. Югорск, ул. Гастало, д. 31 Средний бокс</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-7 h-7 text-red-400 mr-4 mt-1 shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="font-bold text-lg text-white">Время работы:</h4>
                                <p class="text-gray-300">Пн-Вс: 9:00 - 21:00 (без выходных)</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-7 h-7 text-red-400 mr-4 mt-1 shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div>
                                <h4 class="font-bold text-lg text-white">Телефон для записи:</h4>
                                <a href="tel:+79323317777"
                                   class="text-gray-300 hover:text-red-400 transition-colors text-lg">+7 (932)
                                    331-77-77</a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 aspect-video bg-gray-700 rounded-xl overflow-hidden border border-red-900/50">
                        <!-- ВАЖНО: ЗАМЕНИТЕ SRC НА КОД ВАШЕЙ ЯНДЕКС.КАРТЫ -->
                        <iframe
                            src="https://yandex.ru/map-widget/v1/?ll=63.302046%2C61.323981&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgoyMTU3MTU3MDc2EokB0KDQvtGB0YHQuNGPLCDQpdCw0L3RgtGLLdCc0LDQvdGB0LjQudGB0LrQuNC5INCw0LLRgtC-0L3QvtC80L3Ri9C5INC-0LrRgNGD0LMg4oCUINCu0LPRgNCwLCDQrtCz0L7RgNGB0LosINGD0LvQuNGG0LAg0JPQsNGB0YLQtdC70LvQviwgMzEiCg0GNX1CFbtLdUI%2C&source=serp_navig&z=19.01" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative">
                            width="100%"
                            height="100%"
                            frameborder="0">
                        </iframe>
                    </div>
                </div>
                <!-- Правая часть - Форма заявки -->
                <div id="contact-form" class="bg-gray-900 p-8 rounded-xl border border-red-900/30">
                    <h3 class="text-3xl font-bold mb-6 text-white">Заявка на ремонт</h3>
                    <form id="lead-form" action="/lead" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Ваше имя</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full bg-gray-800 border-gray-700 text-white rounded-md p-3 focus:border-red-500 focus:ring-red-500 transition">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-300 mb-1">Телефон для
                                связи</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="w-full bg-gray-800 border-gray-700 text-white rounded-md p-3 focus:border-red-500 focus:ring-red-500 transition">
                        </div>
                        <div>
                            <label for="car" class="block text-sm font-medium text-gray-300 mb-1">Марка и модель
                                автомобиля</label>
                            <input type="text" id="car" name="car"
                                   class="w-full bg-gray-800 border-gray-700 text-white rounded-md p-3 focus:border-red-500 focus:ring-red-500 transition">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-1">Опишите проблему
                                или желаемую услугу</label>
                            <textarea id="message" name="message" rows="4" required
                                      class="w-full bg-gray-800 border-gray-700 text-white rounded-md p-3 focus:border-red-500 focus:ring-red-500 transition"></textarea>
                        </div>
                        <div>
                            <button type="submit"
                                    class="w-full bg-red-600 text-white px-6 py-4 rounded-lg hover:bg-red-700 transition-all text-lg font-bold">
                                Отправить заявку
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 text-center">Нажимая "Отправить заявку", вы даете согласие на
                            обработку персональных данных.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="bg-gray-900 border-t border-red-900/30 py-6">
    <div class="container mx-auto px-4 text-center text-gray-500">
        <p>&copy; 2025 AutoService. Все права защищены.</p>
        <p class="text-xs mt-1">Информация на сайте не является публичной офертой.</p>
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

        menuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
            menuIconOpen.classList.toggle('hidden');
            menuIconClose.classList.toggle('hidden');
        });

        // Плавный скролл для якорных ссылок
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
                // Закрыть мобильное меню после клика
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    menuIconOpen.classList.remove('hidden');
                    menuIconClose.classList.add('hidden');
                }
            });
        });

        // Swiper для услуг
        const swiper = new Swiper('.services-slider', {
            loop: true,
            spaceBetween: 24,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1280: { slidesPerView: 3 }
            },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });

        // Swiper для отзывов
        const reviewsSwiper = new Swiper('.reviews-slider', {
            loop: true,
            spaceBetween: 24,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1280: { slidesPerView: 3 },
            },
            pagination: { el: '.reviews-slider .swiper-pagination', clickable: true },
        });

        // AJAX отправка формы отзыва
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
                // Очищаем ошибки
                reviewForm.querySelectorAll('.text-red-500').forEach(el => el.remove());
                let successMsg = reviewForm.querySelector('.review-success');
                if (successMsg) successMsg.remove();
                try {
                    const response = await fetch(reviewForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': formData.get('_token'),
                        },
                        body: formData
                    });
                    const data = await response.json();
                    if (response.ok) {
                        // Добавляем новый отзыв в слайдер
                        const newSlide = document.createElement('div');
                        newSlide.className = 'swiper-slide bg-gray-800 p-6 rounded-xl border border-red-900/30';
                        let stars = '';
                        for (let i = 1; i <= 5; i++) {
                            stars += `<span class=\"text-yellow-400 text-lg\">${i <= data.rating ? '★' : '☆'}</span>`;
                        }
                        newSlide.innerHTML = `
                            <div class=\"flex items-center mb-2\">
                                <span class=\"font-bold text-white mr-2\">${data.name}</span>
                                ${data.car ? `<span class=\"text-gray-400 text-sm\">(${data.car})</span>` : ''}
                            </div>
                            <div class=\"flex items-center mb-2\">${stars}</div>
                            <p class=\"text-gray-300 mb-0\">${data.message}</p>
                        `;
                        reviewsSwiper.appendSlide(newSlide);
                        reviewsSwiper.slideTo(reviewsSwiper.slides.length - 1);
                        // Очищаем форму
                        reviewForm.reset();
                        // Показываем всплывающее уведомление
                        showToast('Спасибо за ваш отзыв!');
                        // Программно нажимаем кнопку "Отмена", чтобы закрыть модалку
                        document.getElementById('review-modal-cancel-button').click();
                    } else if (data.errors) {
                        // Показываем ошибки
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const input = reviewForm.querySelector(`[name=\"${field}\"]`);
                            if (input) {
                                const err = document.createElement('div');
                                err.className = 'text-red-500 text-sm mt-1';
                                err.innerText = messages[0];
                                input.parentNode.appendChild(err);
                            }
                        }
                    }
                } catch (err) {
                    alert('Ошибка при отправке отзыва. Попробуйте позже.');
                } finally {
                    isSubmitting = false;
                    if (submitBtn) submitBtn.disabled = false;
                }
            });
        }

        // AJAX отправка формы заявки
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
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': formData.get('_token'),
                        },
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
                } catch (err) {
                    showToast('Ошибка при отправке заявки.', 5000);
                } finally {
                    isSubmitting = false;
                    if (submitBtn) submitBtn.disabled = false;
                }
            });
        }
    });

    // Helper function to show a toast notification
    function showToast(message, duration = 3000) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerText = message;
        container.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // Animate out and remove
        setTimeout(() => {
            toast.classList.remove('show');
            toast.addEventListener('transitionend', () => toast.remove());
        }, duration);
    }
</script>

</body>
</html>
