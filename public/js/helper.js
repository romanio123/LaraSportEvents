 // ========== ДАННЫЕ ==========
        const STORAGE_KEY = 'helpdesk_professional';
        
        // Начальные данные (IDEF0: входные данные - обращения)
        const mockTickets = [
            { id: 1001, date: '2026-03-11', topic: 'Не запускается CRM', client: 'Иванов А.А.', status: 'Новая', assignee: '', description: 'После обновления не открывается' },
            { id: 1002, date: '2026-03-10', topic: 'Сброс пароля', client: 'Петрова Е.М.', status: 'В работе', assignee: 'Смирнов', description: 'Требуется восстановить доступ' },
            { id: 1003, date: '2026-03-09', topic: 'Настроить почту', client: 'ООО "Прогресс"', status: 'Выполнена', assignee: 'Смирнов', description: 'Настроить Outlook для сотрудников' },
            { id: 1004, date: '2026-03-08', topic: 'Нет доступа к серверу', client: 'Сидоров П.К.', status: 'Новая', assignee: '', description: 'Ошибка 403 при входе' },
            { id: 1005, date: '2026-03-07', topic: 'Обновить 1С', client: 'Бухгалтерия', status: 'В работе', assignee: 'Козлов', description: 'Обновить до последней версии' }
        ];

        let tickets = [];
        let currentFilter = 'all';
        let searchQuery = '';

        // ========== ЗАГРУЗКА И СОХРАНЕНИЕ ==========
        function loadTickets() {
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored) {
                tickets = JSON.parse(stored);
            } else {
                tickets = [...mockTickets];
            }
            tickets.sort((a, b) => new Date(b.date) - new Date(a.date));
        }

        function saveToStorage() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(tickets));
        }

        // ========== СТАТИСТИКА (выходные данные - отчетность) ==========
        function updateStats() {
            const total = tickets.length;
            const newCount = tickets.filter(t => t.status === 'Новая').length;
            const progress = tickets.filter(t => t.status === 'В работе').length;
            const done = tickets.filter(t => t.status === 'Выполнена').length;

            document.getElementById('totalTickets').textContent = total;
            document.getElementById('newTickets').textContent = newCount;
            document.getElementById('progressTickets').textContent = progress;
            document.getElementById('doneTickets').textContent = done;
        }

        // ========== ФИЛЬТРАЦИЯ И ПОИСК ==========
        function getFilteredTickets() {
            return tickets.filter(ticket => {
                // Фильтр по статусу
                if (currentFilter !== 'all' && ticket.status !== currentFilter) return false;
                
                // Поиск по ID или теме
                if (searchQuery) {
                    const query = searchQuery.toLowerCase();
                    const idMatch = ticket.id.toString().includes(query);
                    const topicMatch = ticket.topic.toLowerCase().includes(query);
                    if (!idMatch && !topicMatch) return false;
                }
                return true;
            });
        }

        // ========== ОТОБРАЖЕНИЕ ТАБЛИЦЫ ==========
        function renderTable() {
            const filtered = getFilteredTickets();
            const tbody = document.getElementById('ticketsBody');
            
            if (filtered.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="empty-state">
                            <div style="font-size: 3rem; margin-bottom: 16px;">📭</div>
                            <p>Заявок не найдено</p>
                        </td>
                    </tr>
                `;
            } else {
                tbody.innerHTML = filtered.map(ticket => {
                    const statusClass = 
                        ticket.status === 'Новая' ? 'status-new' : 
                        ticket.status === 'В работе' ? 'status-progress' : 'status-done';
                    return `
                        <tr>
                            <td><span class="ticket-id">#${ticket.id}</span></td>
                            <td>${ticket.date}</td>
                            <td>${ticket.topic}</td>
                            <td>${ticket.client}</td>
                            <td>
                                <span class="status-badge ${statusClass}">
                                    ${ticket.status}
                                </span>
                            </td>
                            <td>
                                <div class="assignee">
                                    <span class="assignee-avatar">${ticket.assignee ? ticket.assignee[0] : '?'}</span>
                                    ${ticket.assignee || '—'}
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    ${ticket.status !== 'Выполнена' ? 
                                        `<button class="action-btn resolve-btn" onclick="resolveTicket(${ticket.id})" title="Решить задачу">✅</button>` : ''
                                    }
                                    <button class="action-btn" onclick="editTicket(${ticket.id})" title="Редактировать">✏️</button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            }
            updateStats();
        }

        // ========== ДЕЙСТВИЯ С ЗАЯВКАМИ ==========
        function resolveTicket(id) {
            const ticket = tickets.find(t => t.id === id);
            if (ticket && ticket.status !== 'Выполнена') {
                ticket.status = 'Выполнена';
                saveToStorage();
                renderTable();
                showToast('Заявка решена и закрыта');
            }
        }

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Новая заявка';
            document.getElementById('ticketForm').reset();
            document.getElementById('ticketId').value = '';
            document.getElementById('status').value = 'Новая';
            document.getElementById('ticketModal').classList.add('active');
        }

        function editTicket(id) {
            const ticket = tickets.find(t => t.id === id);
            if (!ticket) return;

            document.getElementById('modalTitle').textContent = 'Редактирование заявки';
            document.getElementById('ticketId').value = ticket.id;
            document.getElementById('topic').value = ticket.topic;
            document.getElementById('client').value = ticket.client;
            document.getElementById('assignee').value = ticket.assignee || '';
            document.getElementById('status').value = ticket.status;
            document.getElementById('description').value = ticket.description || '';
            
            document.getElementById('ticketModal').classList.add('active');
        }

        function saveTicket() {
            const topic = document.getElementById('topic').value.trim();
            const client = document.getElementById('client').value.trim();

            if (!topic || !client) {
                showToast('Заполните обязательные поля', true);
                return;
            }

            const id = document.getElementById('ticketId').value;
            const assignee = document.getElementById('assignee').value.trim();
            const status = document.getElementById('status').value;
            const description = document.getElementById('description').value.trim();

            if (id) {
                // Обновление существующей
                const index = tickets.findIndex(t => t.id == id);
                if (index !== -1) {
                    tickets[index] = {
                        ...tickets[index],
                        topic,
                        client,
                        assignee,
                        status,
                        description
                    };
                }
                showToast('Заявка обновлена');
            } else {
                // Создание новой
                const newId = tickets.length > 0 ? Math.max(...tickets.map(t => t.id)) + 1 : 1001;
                const today = new Date().toISOString().split('T')[0];
                
                tickets.unshift({
                    id: newId,
                    date: today,
                    topic,
                    client,
                    status: status || 'Новая',
                    assignee,
                    description
                });
                showToast('Заявка создана');
            }

            saveToStorage();
            renderTable();
            closeModal();
        }

        function closeModal() {
            document.getElementById('ticketModal').classList.remove('active');
        }

        function showToast(message, isError = false) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.style.backgroundColor = isError ? '#ef4444' : '#1e293b';
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        function applySearch() {
            searchQuery = document.getElementById('searchInput').value;
            renderTable();
        }

        // ========== ИНИЦИАЛИЗАЦИЯ ==========
        loadTickets();
        renderTable();

        // Фильтры
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                currentFilter = tab.dataset.filter;
                renderTable();
            });
        });

        // Поиск при нажатии Enter
        document.getElementById('searchInput').addEventListener('keyup', (e) => {
            if (e.key === 'Enter') applySearch();
        });

        // Закрытие модалки по клику на фон
        document.getElementById('ticketModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('ticketModal')) closeModal();
        });

        // Защита от перезагрузки формы
        document.getElementById('ticketForm').addEventListener('submit', (e) => {
            e.preventDefault();
            saveTicket();
        });