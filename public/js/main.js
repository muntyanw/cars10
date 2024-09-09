window.addEventListener('DOMContentLoaded', () => {

    // Open side menu

    const btnSide = document.querySelector('.btn-aside');

    if (btnSide) {
        const sidebarMenu = document.querySelector('.sidebar');
        const modalOverlay = document.querySelector('.overlay-modal');

        btnSide.addEventListener('click', () => {
            sidebarMenu.classList.add('opened');
            modalOverlay.classList.remove('hidden');
        });

        modalOverlay.addEventListener('click', () => {
            sidebarMenu.classList.remove('opened');
            modalOverlay.classList.add('hidden');
        });
    }


    // Tabs product type

    const
        btnBox = document.querySelector('.control-panel__btn-box'),
        btnList = document.querySelector('.control-panel__btn-list'),
        productContainer = document.querySelector('.product'),
        controlPanel = document.querySelector('.control-panel__switcher');

    if (controlPanel) {
        btnBox.addEventListener('click', () => {
            btnBox.classList.add('control-panel__btn--active');
            btnList.classList.remove('control-panel__btn--active');
            productContainer.classList.remove('product__type-list');
        });

        btnList.addEventListener('click', () => {
            btnList.classList.add('control-panel__btn--active');
            btnBox.classList.remove('control-panel__btn--active');
            productContainer.classList.add('product__type-list');
        });
    }

    // Theme Mode

    const
        toggleSwitch = document.querySelector('.header_checkbox'),
        currentTheme = localStorage.getItem('theme'),
        body = document.querySelector('body');


    if (toggleSwitch && currentTheme) {
        body.setAttribute('data-theme', currentTheme);

        if (currentTheme === 'light') {
            toggleSwitch.checked = true;
        }
    }

    function switchTheme(e) {
        if (e.target.checked) {
            body.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
        } else {
            body.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
        }
    }

    if (toggleSwitch) toggleSwitch.addEventListener('change', switchTheme, false);

    // Select

    (($) => {
        $('.select').each(function () {

            const parent = $(this).parent(),
                  search = $(this).hasClass('search'),
                  searchPlaceholder = $(this).attr('data-search-placeholder');


            $(this).select2({
                placeholder: '',
                minimumResultsForSearch: search ? 1 : -1,
                searchInputPlaceholder: '',
                language: {
                    noResults: function () {
                        return "Нічого не знайдено";
                    }
                }
            }).on('select2:open', function () {
                parent.find($('.select-icon')).addClass('color-icon');
                parent.find($('.select-arrow__icon')).addClass('color-arrow');

                if (searchPlaceholder) {
                    $('input.select2-search__field').prop('placeholder', searchPlaceholder);
                }

            }).on('select2:close', function () {
                parent.find($('.select-icon')).removeClass('color-icon');
                parent.find($('.select-arrow__icon')).removeClass('color-arrow');
            }).on('select2:select', function () {
                parent.find($('.select-icon')).addClass('color-icon');
                parent.find($('.select-arrow__icon')).removeClass('color-arrow').addClass('white');
                parent.find($('.select-custom .select2-selection--single')).addClass('selected');
            });
        })
    })(jQuery);

    // DataPicker

    (($) => {
        $.fn.datepicker.languages['uk-UA'] = {
            format: 'dd.mm.YYYY',
            days: ['Неділя', 'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'П\'ятниця', 'Субота'],
            daysShort: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            daysMin: ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            months: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
            monthsShort: ['Січ', 'Лют', 'Бер', 'Кві', 'Тра', 'Чер', 'Лип', 'Сер', 'Вер', 'Жов', 'Лис', 'Гру'],
            weekStart: 1,
            startView: 0,
            yearFirst: false,
            yearSuffix: ''
        };

        $('.datepicker-input[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            language: 'uk-UA',
            show: function () {
                $(this).parent().addClass('open');
                $('.datepicker-container').css('width', $('.datepicker').width() - 4);
            },
            hide: function () {
                $(this).parent().removeClass('open');
            },
            pick: function () {
                $(this).parent().addClass('selected');
            }
        });
    })(jQuery);

    // Input type password

    const password = document.querySelectorAll('.input-wrap--password');

    if (password) {
        password.forEach(pass => {
            const passIcon = pass.querySelector('.toggle-password'),
                  passField = pass.querySelector('.input');

            passIcon.addEventListener('click', () => {
                if (passField.type === 'password') {
                    passField.setAttribute('type', 'text');
                } else {
                    passField.setAttribute('type', 'password');
                }
            });
        });
    }

    // Input type file

    const file = document.querySelectorAll('.input-wrap--file');

    file.forEach(f => {
        const fileInput = f.querySelector('.input-file'),
              fileNameLabel = document.querySelector('.file-name'),
              parent = fileNameLabel.parentNode.parentNode;

        fileInput.addEventListener('change', (e) => {

            const [file] = e.target.files;
            const { name: fileName, size } = file;
            const fileSize = (size / 1000).toFixed(2);
            const fileNameAndSize = `${fileName} - ${fileSize}KB`;
            fileNameLabel.textContent = fileNameAndSize;

            if (fileNameLabel.value !== 'Завантажте аватар') {
                parent.classList.add('selected');
            } else {
                parent.classList.remove('selected');
            }
        });

    });

    // Filter

    const filterBtn = document.querySelector('.filter-btn'),
          filterCloseBtn = document.querySelector('.filter__close'),
          filterContainer = document.querySelector('.filter');

    if (filterBtn) {
        filterBtn.addEventListener('click', () => {
            filterContainer.classList.add('opened');
            filterBtn.classList.add('hidden');
        });

        filterCloseBtn.addEventListener('click', () => {
            filterContainer.classList.remove('opened');
            filterBtn.classList.remove('hidden');
        });
    }

    // Modal

    if(document.querySelector('.modal')) {
        const modalOverlay = document.querySelector('.overlay-modal');

        document.addEventListener('click', modalHandler);

        function modalHandler(e) {
            const modalBtnOpen = e.target.closest('.js-modal');

            if (modalBtnOpen) {
                e.preventDefault();
                const modalSelector = modalBtnOpen.dataset.modal;
                showModal(document.querySelector(modalSelector));
            }

            const modalBtnClose = e.target.closest('.modal-close');
            if (modalBtnClose) {
                e.preventDefault();
                hideModal(modalBtnClose.closest('.modal'));
            }

            if (e.target.matches('#modal-backdrop')) {
                hideModal(document.querySelector('.modal.show'));
            }

            modalOverlay.addEventListener('click', () => {
                modalOverlay.classList.add('hidden');
                document.querySelectorAll('.modal').forEach(el => {
                    el.classList.remove('show');
                    document.querySelector('body').style.overflow = "initial";
                });
            });
        }

        function showModal(modalElem) {
            modalElem.classList.add('show');
            modalOverlay.classList.remove('hidden');
            document.querySelector('body').style.overflow = "hidden";
        }

        function hideModal(modalElem) {
            modalElem.classList.remove('show');
            modalOverlay.classList.add('hidden');
            document.querySelector('body').style.overflow = "initial";
        }
    }

    // Slider Details

    if (document.querySelector('.details__swiper')) {
        const detailsSliderThumbnail = new Swiper('.details__swiper-thumb', {
            slidesPerView: 4,
            spaceBetween: 14,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });

        const detailsSlider = new Swiper('.details__swiper', {
            spaceBetween: 14,
            effect: 'fade',
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: detailsSliderThumbnail
            }
        });
    }

})