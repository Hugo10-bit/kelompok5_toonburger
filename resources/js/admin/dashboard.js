function initAdminDashboard() {
    const barsGridEl = document.getElementById('revenue-bars-grid');
    if (!barsGridEl) return;
    let chartPeriods = {};
    if (barsGridEl.dataset.chartPeriods) {
        try {
            chartPeriods = JSON.parse(barsGridEl.dataset.chartPeriods);
        } catch (e) {
            chartPeriods = {};
        }
    }

    let activePeriod = 'jan_jun';
    let activeBarIndex = 2;

    function isEnglishActive() {
        return window._tbLang === 'US' || window._tbLang === 'EN';
    }

    let cachedRefs = null;

    function getChartRefs() {
        if (cachedRefs) return cachedRefs;
        const barsGrid = document.getElementById('revenue-bars-grid');
        const monthsGrid = document.getElementById('revenue-months-grid');
        if (!barsGrid || !monthsGrid) return null;
        cachedRefs = {
            btnH1: document.getElementById('period-btn-jan-jun'),
            btnH2: document.getElementById('period-btn-jul-des'),
            yAxisEls: Array.from(document.querySelectorAll('[data-yaxis]')),
            barButtons: Array.from(barsGrid.querySelectorAll('.tb-chart-bar')).map((btn) => ({
                btn,
                tooltip: btn.querySelector('.tb-bar-tooltip'),
                dateEl: btn.querySelector('.tb-tooltip-date'),
                valEl: btn.querySelector('.tb-tooltip-val'),
            })),
            monthButtons: Array.from(monthsGrid.querySelectorAll('.tb-month-label')),
        };
        return cachedRefs;
    }

    function renderRevenueChart() {
        const refs = getChartRefs();
        if (!refs) return;

        const isEn = isEnglishActive();
        const rows = chartPeriods[activePeriod] || [];

        if (refs.btnH1 && refs.btnH2) {
            const h1Active = activePeriod === 'jan_jun';
            refs.btnH1.classList.toggle('is-active', h1Active);
            refs.btnH1.setAttribute('aria-pressed', h1Active ? 'true' : 'false');
            refs.btnH2.classList.toggle('is-active', !h1Active);
            refs.btnH2.setAttribute('aria-pressed', !h1Active ? 'true' : 'false');
        }

        refs.yAxisEls.forEach((el) => {
            const n = el.getAttribute('data-yaxis');
            const nextLabel = isEn ? `${n}M` : `${n}jt`;
            if (el.textContent !== nextLabel) el.textContent = nextLabel;
        });

        rows.forEach((row, idx) => {
            const isSelected = idx === activeBarIndex;
            const monthText = isEn ? row.en_month : row.id_month;
            const dateText = isEn ? row.date_en : row.date_id;
            const valText = isEn ? row.val_en : row.val_id;

            const barRef = refs.barButtons[idx];
            if (barRef) {
                const nextHeight = `${row.pct}%`;
                if (barRef.btn.style.height !== nextHeight) barRef.btn.style.height = nextHeight;
                barRef.btn.classList.toggle('is-active', isSelected);
                barRef.btn.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
                barRef.btn.setAttribute('aria-label', `${monthText}: ${valText}`);

                if (barRef.dateEl && barRef.dateEl.textContent !== dateText) barRef.dateEl.textContent = dateText;
                if (barRef.valEl && barRef.valEl.textContent !== valText) barRef.valEl.textContent = valText;
                if (barRef.tooltip) {
                    barRef.tooltip.classList.toggle('block', isSelected);
                    barRef.tooltip.classList.toggle('hidden', !isSelected);
                }
            }

            const monthBtn = refs.monthButtons[idx];
            if (monthBtn) {
                if (monthBtn.textContent.trim() !== monthText) monthBtn.textContent = monthText;
                monthBtn.classList.toggle('font-medium', isSelected);
                monthBtn.classList.toggle('text-[#374151]', isSelected);
                monthBtn.classList.toggle('dark:text-white', isSelected);
            }
        });
    }

    window.switchRevenuePeriod = function (period) {
        if (!chartPeriods[period]) return;
        activePeriod = period;
        activeBarIndex = period === 'jan_jun' ? 2 : 3;
        renderRevenueChart();
    };

    window.selectRevenueBar = function (idx) {
        activeBarIndex = idx;
        renderRevenueChart();
    };

    if (window._tbDashLangHandler) {
        window.removeEventListener('tb:langchange', window._tbDashLangHandler);
    }
    window._tbDashLangHandler = renderRevenueChart;
    window.addEventListener('tb:langchange', renderRevenueChart);
    if (isEnglishActive()) {
        renderRevenueChart();
    }
}

initAdminDashboard();
window.addEventListener('tb:admin:pjax:loaded', initAdminDashboard);
