<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-logo">SportEvents</a>
                <p class="footer-tagline">
                    Платформа для организации спортивных мероприятий
                </p>
            </div>

            <div class="footer-grid">
                <div class="footer-section">
                    <h3>Участникам</h3>
                    <ul>
                        <li><a href="{{ route('events.index') }}">Поиск мероприятий</a></li>
                        <li><a href="{{ route('register') }}">Регистрация</a></li>
                        <li><a href="{{ route('support') }}">Помощь</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Организаторам</h3>
                    <ul>
                        @auth
                            @if(auth()->user()->is_organizer)
                                <li><a href="">Создать мероприятие</a></li>
                            @else
                                <li><a href="{{ route('profile') }}">Стать организатором</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('register') }}">Стать организатором</a></li>
                        @endauth
                        <li><a href="#">Тарифы</a></li>
                        <li><a href="#">Документация</a></li>
                        <li><a href="{{ route('support') }}">Поддержка</a></li>
                    </ul>
                </div>

                <div class="footer-section footer-contact">
                    <h3>Контакты</h3>
                    <ul>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:SportEvents@yandex.ru">SportEvents@yandex.ru</a>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>8 (800) 123-12-12</span>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>г. Сыктывкар</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-copyright">
                © 2026 SportEvents. Все права защищены.
            </div>

            <div class="footer-social">
                <a href="#" class="social-link" title="VK">
                    <i class="fab fa-vk"></i>
                </a>
                <a href="#" class="social-link" title="Telegram">
                    <i class="fab fa-telegram"></i>
                </a>
                <a href="#" class="social-link" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
